<?php
/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/

class ControllerPaymentPaybrasB extends Controller 
{
  public function converte_utf($utf8)
  {
	  return utf8_encode($utf8);
  }
  
  
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
  protected function index() 
  {
    $this->data['button_confirm'] = 'Confirmar';
	$this->data['button_back'] = 'Voltar';

	
	$this->load->model('checkout/order');
	$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
    $this->data['pedido'] = $order_info['order_id'];
	
	$this->data['desconto'] = $this->config->get('paybrasb_desconto');
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
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paybrasb.tpl')) {
	  $this->template = $this->config->get('config_template') . '/template/payment/paybrasb.tpl';
	} else {
	  $this->template = 'default/template/payment/paybrasb.tpl';
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
		if(!$pedido->row['shipping_zone_id']) $pedido->row['shipping_zone_id']=$pedido->row['payment_zone_id'];
		
		
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

        $desconto = number_format($cupom + $voucher, 2, '.', '') * -1;
		
$notificacao=$this->config->get('config_url').'paybras/retorno.php';

if($this->config->get('config_secure'))
	$notificacao = str_replace("http", "https", $notificacao);

if(!$pedido->row['shipping_address_1']) $pedido->row['shipping_address_1']=$pedido->row['payment_address_1'];
if(!$pedido->row['shipping_address_2']) $pedido->row['shipping_address_2']=$pedido->row['payment_address_2'];

if(!$pedido->row['shipping_city']) $pedido->row['shipping_city']=$pedido->row['payment_city'];

if(!$pedido->row['shipping_postcode']) $pedido->row['shipping_postcode']=$pedido->row['payment_postcode'];
if(!$estado2->row['code']) $estado2->row['code']= $estado->row['code'];

$telefone = preg_replace("/[^0-9,.]/", "", $pedido->row['telephone']);
$telefone_ddd = substr($telefone, 0, 2);
$telefone_numero = substr($telefone, 2, 9);

if(strlen($telefone_numero) < 8)
	$telefone_numero = str_pad($telefone_numero, 8, 0);
	
if(!$pedido->row['shipping_address_2']) $pedido->row['shipping_address_2']='N/D';


	
	$dados['recebedor_api_token'] = $this->config->get('paybrasb_token');
	$dados['recebedor_email'] = $this->config->get('paybrasb_email_conta');
	$dados['pedido_id'] = $pedido->row['order_id'];
	$dados['pedido_descricao'] = 'Pedido '.$pedido->row['order_id'].' efetuado em Loja Teste';
	$dados['pedido_meio_pagamento'] = 'boleto';
	$dados['pedido_moeda'] = 'BRL';
	$dados['pedido_valor_total_original'] = $pedido->row['total'];
	$dados['pagador_nome'] = ($this->converte_utf($pedido->row['firstname']).' '.$this->converte_utf($pedido->row['lastname']));
	$dados['pagador_email'] = $pedido->row['email'];
	$dados['pagador_cpf'] = preg_replace("/[^0-9]/","",$request->post['cartao_cpf']);
	$dados['pagador_rg'] = '';
	$dados['pagador_telefone_ddd'] = $telefone_ddd;
	$dados['pagador_telefone'] = $telefone_numero;
	#$dados['pagador_sexo'] = '';
	#$dados['pagador_data_nascimento'] = '05/02/1988';
	$dados['pagador_ip'] = $this->get_ip();
	$dados['pagador_logradouro'] = ($this->converte_utf($pedido->row['shipping_address_1']));
	$dados['pagador_numero'] = 'x';
	$dados['pagador_complemento'] =($this->converte_utf($pedido->row['shipping_address_2']));
	$dados['pagador_bairro'] =($this->converte_utf($pedido->row['shipping_address_2']));
	$dados['pagador_cep'] =  str_replace(array('.', '-'), '', $pedido->row['shipping_postcode']);
	$dados['pagador_cidade'] =  $this->converte_utf($pedido->row['shipping_city']);
	$dados['pagador_estado'] = $this->converte_utf($estado->row['code']);
	
	$dados['pagador_pais'] = 'BRA';
	$dados['entrega_nome'] =($this->converte_utf($pedido->row['firstname']).' '.$this->converte_utf($pedido->row['lastname']));
	$dados['entrega_estado'] =   $this->converte_utf($estado->row['code']);
	$dados['entrega_pais'] = 'BRA';
	$dados['entrega_logradouro'] = ($this->converte_utf($pedido->row['shipping_address_1']));
	$dados['entrega_numero'] = 'x';
	$dados['entrega_complemento'] =($this->converte_utf($pedido->row['shipping_address_2']));
	$dados['entrega_bairro'] =($this->converte_utf($pedido->row['shipping_address_2']));
	$dados['entrega_cep'] = str_replace(array('.', '-'), '', $pedido->row['shipping_postcode']);
	$dados['entrega_cidade'] = $this->converte_utf($pedido->row['shipping_city']);
	
	
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
	$url_boleto=$resultado->url_boleto;
	$linha_digitavel=$resultado->linha_digitavel;
	
	$output='';
	
	 if($resultado->status_codigo==1 && $resultado->sucesso==1)
	{
		#Atualiza o status da transacao na tabela dos pedidos	
            $this->db->query("UPDATE ".DB_PREFIX."order SET id_transacao_paybras ='" .$transacao . "', url_paybras='".$url_boleto."###".$linha_digitavel."' WHERE order_id=".$pedido->row['order_id']);
			
		$url_boleto=$this->config->get('config_url').'pagar.php?id='.md5($transacao);
		$botao_boleto='<a href="'.$this->config->get('config_url').'pagar.php?id='.md5($transacao).'" target="_blank"><img src="'.$this->config->get('config_url').'image/paybras/botao_imprimir_boleto.png" align="left" /></a>';
		#Aguardando pagamento / Pagamento em Análise
			$output = "<script>window.location.href = 'index.php?route=information/paybrasb&tipo=1&transacao=".md5($transacao)."';</script>"; 
            $this->model_checkout_order->confirm($order_id, $this->config->get('paybrasb_aguardando_pagamento'), $comment = '<P>Caso ainda não tenha efetuado o pagamento de seu boleto, você pode imprimir a segunda via do mesmo clicando no botão abaixo:</P>'.$botao_boleto.'<BR><BR><P>Link direto:'.$url_boleto."<BR><BR>Codigo de Barras:".$linha_digitavel."</P>", $notfy = true);
			
			
		
	}
	else
	{
		#Ocorreu um erro no pagamento
            $log->write('Erro ao tentar realizar transação. Dados enviados:');
            $log->write($xml);

            $log->write('Dados recebidos do PaybrasB:');
            $log->write(print_r($retorno, true));

            $output = "<script>window.location = 'index.php?route=information/paybrasb&tipo=4';</script>";
            $this->model_checkout_order->confirm($order_id, $this->config->get('paybrasb_pagamento_erro'), $comment = 'Boleto Bancário', $notify = false);
	}
	
			

		
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