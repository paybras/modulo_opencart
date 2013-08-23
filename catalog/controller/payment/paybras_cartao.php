<?php
require_once "paybras.php";

class ControllerPaymentPaybrasCartao extends Controller {
	protected function index() {
		$this->language->load('payment/paybras_cartao');

		//pega serviço para calculo de parcelas
		if ($this->config->get('paybras_cartao_ambience') == 'live') {
    		$url = 'https://paybras.com/payment/getParcelas';
		} elseif ($this->config->get('paybras_cartao_ambience') == 'sandbox') {
			$url = 'https://sandbox.paybras.com/payment/getParcelas';		
		} elseif ($this->config->get('paybras_cartao_ambience') == 'local') {
    		$url = 'http://localhost/paybras/payment/getParcelas';
  		} 
		
		$this->data['text_credit_card'] = $this->language->get('text_credit_card');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_type_payment'] = $this->language->get('text_type_payment');
		
		$this->data['entry_cc_owner'] = $this->language->get('entry_cc_owner');
		$this->data['entry_cc_type'] = $this->language->get('entry_cc_type');
		$this->data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$this->data['entry_cc_parcelas'] = $this->language->get('entry_cc_parcelas');
		$this->data['entry_cc_start_date'] = $this->language->get('entry_cc_start_date');
		$this->data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$this->data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
		$this->data['entry_cc_issue'] = $this->language->get('entry_cc_issue');

		$this->data['entry_cc_owner_cpf'] = $this->language->get('entry_cc_owner_cpf');
		$this->data['entry_cc_owner_nasc'] = $this->language->get('entry_cc_owner_nasc');
		$this->data['entry_cc_owner_phone'] = $this->language->get('entry_cc_owner_phone');


		$this->data['paybras_cartao_carddata'] = $this->config->get('paybras_cartao_carddata');
		
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		
		$this->data['cards'] = array();

		$this->data['cards'][] = array(
			'text'  => 'Visa', 
			'value' => 'visa'
		);

		$this->data['cards'][] = array(
			'text'  => 'MasterCard', 
			'value' => 'mastercard'
		);
		
		$this->data['cards'][] = array(
			'text'  => 'American Express', 
			'value' => 'amex'
		);
		
		$this->data['cards'][] = array(
			'text'  => 'Diners Club', 
			'value' => 'diners'
		);
		
		$this->data['cards'][] = array(
			'text'  => 'Elo', 
			'value' => 'elo'
		);

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$order_info['total'];

		//Realiza Calculo de parcelas
		$cal_parc['recebedor_email'] = $this->config->get('paybras_cartao_email');
		$cal_parc['recebedor_api_token'] = $this->config->get('paybras_cartao_token');
		$cal_parc['pedido_valor_total'] = $order_info['total'];
		$this->data['parcelas'] = json_decode(Paybras::curl($url, $cal_parc), true);
		
		$this->data['months'] = array();
		
		$month = 'Janeiro,Fevereiro,Março,Abril,Maio,Junho,Julho,Agosto,Setembro,Outubro,Novembro,Dezembro';
		$month = explode(",", $month);

		foreach ($month as $key => $value) {
			$this->data['months'][] = array(
				'text'  => $value,
				'value' => sprintf('%02d', $key+1)
			);
		}
		
		$today = getdate();
		
		$this->data['year_valid'] = array();
		
		for ($i = $today['year'] - 10; $i < $today['year'] + 1; $i++) {	
			$this->data['year_valid'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)), 
				'value' => strftime('%y', mktime(0, 0, 0, 1, 1, $i))
			);
		}

		$this->data['year_expire'] = array();

		for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
			$this->data['year_expire'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%y', mktime(0, 0, 0, 1, 1, $i)) 
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paybras_cartao.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/paybras_cartao.tpl';
		} else {
			$this->template = 'default/template/payment/paybras_cartao.tpl';
		}	
		
		$this->render();		
	}
	
	public function send() {
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $dados['ambiente'] = $this->config->get('paybras_cartao_ambience');
        $dados['meio_pagamento'] = 'cartao';
        $dados['recebedor_email'] = $this->config->get('paybras_cartao_email');
        $dados['recebedor_api_token'] = $this->config->get('paybras_cartao_token');
        $dados['config_name'] = $this->config->get('config_name');
        $dados['dados_cartao'] = $this->request->post;
        $dados['cartao_carddata'] = $this->config->get('cartao_carddata');
        $dados['dados_pedido'] = $order_info;
        $dados['dados_produtos'] = $this->cart->getProducts();
        $dados['has_shipping'] = $this->cart->hasShipping();

        $paybras = new Paybras($dados);

        $data = $paybras->montaDadosEnvio();
    	$validacao = Paybras::validaMensagem($data['dados_envio']);

    	if($validacao['sucesso']){
            $url = $data['dados_conexao'];
            $data = $data['dados_envio'];

    		$response = json_decode(Paybras::curl($url, $data), true);

    		if(!$response['sucesso']) {
				$this->response->setOutput(json_encode($response));
			} else {
                $this->model_checkout_order->confirm($this->session->data['order_id'], 2);

                $comment = null;
                if(!isset($response['nao_autorizado_codigo']) || empty($response['nao_autorizado_codigo'])) {
                    $response['nao_autorizado_codigo'] = null;
                }

                $statusOpecart = Paybras::getStatusOpencart($response['status_codigo'], $response['nao_autorizado_codigo']);

                $response['status_codigo'] = $statusOpecart['status_code'];
                $response['status_comment'] = $statusOpecart['status_comment'];

				$this->model_checkout_order->update($this->session->data['order_id'], $response['status_codigo'], $response['status_comment'], true);
                $json['sucesso'] = '1';
                $json['url'] = $this->url->link('checkout/success');
				$this->response->setOutput(json_encode($json));
			}
		} else {
			$this->response->setOutput(json_encode($validacao));
		}
	}
}
?>