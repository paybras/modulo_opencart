<?php

/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
class ControllerPaymentPaybrasC extends Controller 
{
	public function get_ip()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} 
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else 
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}


  public function converte_utf($utf8)
  {
	  return utf8_encode($utf8);
  }
  
  protected function index() 
  {
    $this->data['button_confirm'] = 'Confirmar';
	$this->data['button_back'] = 'Voltar';

	
	$this->load->model('checkout/order');
	$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
    $this->data['pedido'] = $order_info['order_id'];
	
	$this->data['desconto'] = $this->config->get('paybras_desconto');
	$this->data['valorpedido'] = $order_info['total'];
	
    $this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
    $this->data['continue'] = HTTPS_SERVER . 'index.php?route=checkout/success';
	
    if ($this->request->get['route'] != 'checkout/guest_step_3') 
	{
 	 $this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
    } else {
      $this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
    }	
    $this->id = 'payment';
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paybrasc.tpl')) {
	  $this->template = $this->config->get('config_template') . '/template/payment/paybrasc.tpl';
	} else {
	  $this->template = 'default/template/payment/paybrasc.tpl';
	}	
	$this->render();
  }

  public function confirm() 
  {
        global $request;
        global $log;

		$this->load->model('checkout/order');

	    $order_id = $this->session->data['order_id'];
	
		$pedido = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '".$order_id."'");
		
		$estado = $this->db->query("SELECT code FROM `" . DB_PREFIX . "zone` WHERE zone_id = ".$pedido->row['payment_zone_id']);
		$estado2 = $this->db->query("SELECT code FROM `" . DB_PREFIX . "zone` WHERE zone_id = ".$pedido->row['shipping_zone_id']);

		$pais = $this->db->query("SELECT iso_code_3 FROM `" . DB_PREFIX . "country` WHERE country_id = ".$pedido->row['payment_country_id']);

        $produtos_result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_product` WHERE order_id = " . $order_id);
		$frete_result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE code = 'shipping' AND order_id = '".$order_id."'");
		$cupom_result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE code = 'coupon' AND order_id = '".$order_id."'");
		$voucher_result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE code = 'voucher' AND order_id = '".$order_id."'");
		
		if(isset($frete_result->row['value']))
        $frete = number_format($frete_result->row['value'], 2, '.', '');
		else $frete=0;

        $temCupomDesconto = (count($cupom_result->rows)) ? true : false;
        $temVoucherDesconto = (count($voucher_result->rows)) ? true : false;

        $cupom = 0;
        $voucher = 0;
        $desconto = 0;

        if ($temCupomDesconto) {
            $cupom = abs($cupom_result->rows[0]['value']);
        }
				
        if ($temVoucherDesconto) {
            $voucher = abs($voucher_result->rows[0]['value']);
        }

        $desconto = number_format($cupom + $voucher, 2, '.', '');
		
$notificacao=$this->config->get('config_url').'paybras/retorno.php';

if($this->config->get('config_secure'))
	$notificacao = str_replace("http", "https", $notificacao);


if(!$pedido->row['shipping_address_1']) $pedido->row['shipping_address_1']=$_POST['fatura_endereco'];
if(!$pedido->row['shipping_address_2']) $pedido->row['shipping_address_2']=$_POST['fatura_bairro'];
if(!$pedido->row['shipping_city']) $pedido->row['shipping_city']=$_POST['fatura_cidade'];
if(!$pedido->row['shipping_postcode']) $pedido->row['shipping_postcode']=$_POST['fatura_cep'];
if(!$estado->row['code']) $estado->row['code']=$_POST['fatura_estado'];


$dados['recebedor_api_token'] = $this->config->get('paybrasc_token');
	$dados['recebedor_email'] = $this->config->get('paybrasc_email_conta');
	$dados['pedido_id'] = $order_id;
	$dados['pedido_descricao'] = 'Pedido '.$order_id.' efetuado em teste';
	$dados['pedido_meio_pagamento'] = 'cartao';
	$dados['pedido_moeda'] = 'BRL';
	$dados['pedido_valor_total_original'] = $pedido->row['total'];
	$dados['pagador_nome'] = $this->converte_utf($pedido->row['firstname']).' '.$this->converte_utf($pedido->row['lastname']);
	$dados['pagador_email'] = $pedido->row['email'];
	$dados['pagador_cpf'] = preg_replace("/[^0-9]/","",$request->post['cartao_cpf']);
	$dados['pagador_rg'] = '';
	$dados['pagador_telefone_ddd'] = $_POST['cartao_telefone_ddd'];
	$dados['pagador_telefone'] = $_POST['cartao_telefone'];
	$dados['pagador_ip'] = $this->get_ip();
	$dados['pagador_logradouro'] = ($this->converte_utf($pedido->row['shipping_address_1']));
	$dados['pagador_numero'] = 'x';
	$dados['pagador_complemento'] =($this->converte_utf($pedido->row['shipping_address_2']));
	$dados['pagador_bairro'] =($this->converte_utf($pedido->row['shipping_address_2']));
	$dados['pagador_cep'] =  str_replace(array('.', '-'), '', $pedido->row['shipping_postcode']);
	$dados['pagador_cidade'] =  $this->converte_utf($pedido->row['shipping_city']);
	$dados['pagador_estado'] = $this->converte_utf($estado->row['code']);
	
	$dados['pagador_pais'] = 'BRA';
	$dados['entrega_nome'] = utf8_encode($_POST['fatura_nome']);
	$dados['entrega_estado'] = utf8_encode($_POST['fatura_estado']);
	$dados['entrega_pais'] = 'BRA';
	$dados['entrega_logradouro'] = utf8_encode($_POST['fatura_endereco']);
	$dados['entrega_numero'] = utf8_encode($_POST['fatura_numero']);
	$dados['entrega_complemento'] = utf8_encode($_POST['fatura_bairro']);
	$dados['entrega_bairro'] = utf8_encode($_POST['fatura_bairro']);
	$dados['entrega_cep'] = utf8_encode($_POST['fatura_cep']);
	$dados['entrega_cidade'] = utf8_encode($_POST['fatura_cidade']) ;
	
	$dados['cartao_numero']=$_POST['cartao_numero1'];
	$dados['cartao_parcelas']=$_POST['parcelas'];
	$dados['cartao_codigo_de_seguranca']=$_POST['cartao_codigo'];
	$dados['cartao_bandeira']=$_POST['bandeira_cartao'];
	$dados['cartao_portador_nome']=$_POST['cartao_titular'];
	$dados['cartao_validade_mes']=$_POST['cartao_mes'];
	$dados['cartao_validade_ano']=$_POST['cartao_ano'];
	$dados['cartao_portador_cpf']=$_POST['cartao_cpf'];
	#$dados['cartao_portador_data_de_nascimento']=$_POST['data_nascimento'];
	$dados['cartao_portador_telefone_ddd']=$_POST['cartao_telefone_ddd'];
	$dados['cartao_portador_telefone']=$_POST['cartao_telefone'];
	
	foreach($produtos_result->rows as $produto) {
	{
		$valor_produto = number_format($produto['price'], 2, '.', '');
		$object = new stdClass();
		$produto =  array('produto_codigo'=>$produto['product_id'], 'produto_nome'=> $produto['name'],'produto_categoria'=>'','produto_valor'=>$valor_produto,'produto_qtd'=>$produto['quantity'] ,'produto_peso'=>0);
		
		foreach ($produto as $key => $value)
		{
			$object->$key = $value;
		}
		$dados['produtos'][] = $object;
	}
	$data_string=json_encode($dados);
	
	if($this->config->get('paybrasb_modo')==2)
		$url='https://service.paybras.com/payment/api/criaTransacao';
	else
		$url='https://sandbox.paybras.com/payment/api/criaTransacao';
	
	$ch = curl_init();

        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
		
	$resultado=(json_decode((curl_exec($ch))));

	$status = $resultado->status_codigo;    
    $transacao = $resultado->transacao_id; 
	#descomente para depurar	
	#file_put_contents('XML-paybras.txt', print_r($resultado, true) .'   '.$xml);
    
	$output = '';
	
	 if($status == 1 or $status==2)
	{
		#Aguardando pagamento / Pagamento em Análise
			$output = "<script>window.location.href = 'index.php?route=information/paybrasc&tipo=1';</script>"; 
            $this->model_checkout_order->confirm($order_id, $this->config->get('paybrasc_pagamento_analise'), $comment = '', $notify = true);
		
	}
	else if($status==4 )
	{
		#APROVADO
			$output = "<script>window.location.href = 'index.php?route=information/paybrasc&tipo=3';</script>"; 
            $this->model_checkout_order->confirm($order_id,$this->config->get('paybrasc_pagamento_confirmado'), $comment = '', $notify = true);
		
	}
	else if($status == 3 )
	{
		#nao autorizado
			$output = "<script>window.location.href = 'index.php?route=information/paybrasc&tipo=2';</script>"; 
			#muda o status da transacao
            $this->model_checkout_order->confirm($order_id, $this->config->get('paybrasc_pagamento_nao_autorizado'), $comment = '', $notify = true);

	}
	else
	{
		#Ocorreu um erro no pagamento
            $log->write('Erro ao tentar realizar transação. Dados enviados:');
            $log->write($xml);

            $log->write('Dados recebidos do PaybrasC:');
            $log->write(print_r($resultado, true));

            $output = "<script>window.location = 'index.php?route=information/paybrasc&tipo=4';</script>";
            $this->model_checkout_order->confirm($order_id, $this->config->get('paybrasc_pagamento_erro'), $comment = 'Cartão de Crédito', $notify = false);
	}
	
	
		
			#Atualiza o status da transacao na tabela dos pedidos	
            $this->db->query("UPDATE ".DB_PREFIX."order SET id_transacao_paybras ='" .$transacao . "' WHERE order_id=".$pedido->row['order_id']);

		
		if (!empty($this->session->data['order_id'])) 
		{
			 //Limpa a sessão
			$this->cart->clear();
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
		}
		
		$this->response->setOutput($output);
	}
	
  }

}
?>