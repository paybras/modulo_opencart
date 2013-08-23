<?php

require_once "paybras.php";

class ControllerPaymentPaybrasTef extends Controller {
	protected function index() {

		$this->language->load('payment/paybras_tef');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['text_type_payment'] = $this->language->get('text_type_payment');
        $this->data['text_wait'] = $this->language->get('text_wait');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paybras_tef.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/paybras_tef.tpl';
		} else {
			$this->template = 'default/template/payment/paybras_tef.tpl';
		}	
		
		$this->render();		
	}
	
	public function send() {
		$this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $dados['ambiente'] = $this->config->get('paybras_cartao_ambience');
        $dados['meio_pagamento'] = 'tef_bb';
        $dados['recebedor_email'] = $this->config->get('paybras_cartao_email');
        $dados['recebedor_api_token'] = $this->config->get('paybras_cartao_token');
        $dados['config_name'] = $this->config->get('config_name');
        $dados['dados_pedido'] = $order_info;
        $dados['dados_produtos'] = $this->cart->getProducts();
        $dados['has_shipping'] = $this->cart->hasShipping();
        $dados['tef_redirect'] = $this->config->get('paybras_tef_redirect');

        $paybras = new Paybras($dados);

        $data = $paybras->montaDadosEnvio();
        $validacao = Paybras::validaMensagem($data['dados_envio']);;

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

				$this->model_checkout_order->update($this->session->data['order_id'], $response['status_codigo'], $response['status_comment'], true, $response['url_pagamento']);
                $json['sucesso'] = '1';
                $json['url_pagamento'] = $response['url_pagamento'];
                $json['url_success'] = $this->url->link('checkout/success');
				$this->response->setOutput(json_encode($json));
			}
		} else {
			$this->response->setOutput(json_encode($validacao));
		}
	}
}
?>