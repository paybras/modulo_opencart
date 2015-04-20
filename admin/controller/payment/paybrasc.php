<?php 
/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
class ControllerPaymentPaybrasC extends Controller 
{
	private $error = array(); 
	private $status;

	public function index() 
	{
		$this->load->language('payment/paybrasc');
		
		$titulo = 'Paybras - Cartões de Crédito';
		$this->load->model('setting/setting');
		$this->document->setTitle($titulo);
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') 
		{
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('paybrasc', $this->request->post);				
			$this->session->data['success'] = 'Dados foram salvos com sucesso!';
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		if (isset($this->error['warning'])) 
		{
			$this->data['error_warning'] = $this->error['warning'];
		} 
		else 
		{
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['email'])) 
		{
			$this->data['error_email'] = $this->error['email'];
		} 
		else 
		{
			$this->data['error_email'] = '';
		}
				
		if (isset($this->error['encryption'])) 
		{
			$this->data['error_encryption'] = $this->error['encryption'];
		} 
		else 
		{
			$this->data['error_encryption'] = '';
		}

		$this->document->breadcrumbs = array();
		
		$this->document->breadcrumbs[] = array(
		 'href'      => HTTPS_SERVER . 'index.php?route=common/home',
		 'text'      => 'Inicial',
		 'separator' => FALSE
		 );
		
		$this->document->breadcrumbs[] = array(
		 'href'      => HTTPS_SERVER . 'index.php?route=extension/payment',
		 'text'      => 'Pagamentos',
		 'separator' => ' :: '
		 );
		
		$this->document->breadcrumbs[] = array(
		 'href'      => HTTPS_SERVER . 'index.php?route=payment/paybrasc',
		 'text'      => 'Cartões de Crédito Paybras Transparente',
		 'separator' => ' :: '
		 );
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/paybrasc&token=' . $this->session->data['token'];
				
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
        $current_settings = $this->model_setting_setting->getSetting('paybrasc');

		if (isset($this->request->post['paybrasc_sort_order'])) 
		{
			$this->data['paybrasc_sort_order'] = $this->request->post['paybrasc_sort_order'];
		} 
		else 
		{
			$this->data['paybrasc_sort_order'] = isset($current_settings['paybrasc_sort_order']) ? $current_settings['paybrasc_sort_order'] : ''; 
		} 
		if (isset($this->request->post['paybrasc_modo'])) 
		{
			$this->data['paybrasc_modo'] = $this->request->post['paybrasc_modo'];
		} 
		else 
		{
			$this->data['paybrasc_modo'] = isset($current_settings['paybrasc_modo']) ? $current_settings['paybrasc_modo'] : ''; 
		} 
		
				if (isset($this->request->post['paybrasc_status'])) 
		{
			$this->data['paybrasc_status'] = $this->request->post['paybrasc_status'];
		} 
		else 
		{
			$this->data['paybrasc_status'] = isset($current_settings['paybrasc_status']) ? $current_settings['paybrasc_status'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasc_erro'])) 
		{
			$this->data['paybrasc_erro'] = $this->request->post['paybrasc_erro'];
		} 
		else 
		{
			$this->data['paybrasc_erro'] = isset($current_settings['paybrasc_erro']) ? $current_settings['paybrasc_erro'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasc_logo'])) 
		{
			$this->data['paybrasc_logo'] = $this->request->post['paybrasc_logo'];
		} 
		else 
		{
			$this->data['paybrasc_logo'] = isset($current_settings['paybrasc_logo']) ? $current_settings['paybrasc_logo'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasc_company'])) 
		{
			$this->data['paybrasc_company'] = $this->request->post['paybrasc_company'];
		} 
		else 
		{
			$this->data['paybrasc_company'] = isset($current_settings['paybrasc_company']) ? $current_settings['paybrasc_company'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasc_template'])) 
		{
			$this->data['paybrasc_template'] = $this->request->post['paybrasc_template'];
		} 
		else 
		{
			$this->data['paybrasc_template'] = isset($current_settings['paybrasc_template']) ? $current_settings['paybrasc_template'] : ''; 
		} 

		if (isset($this->request->post['paybrasc_tipo_conta'])) 
		{
			$this->data['paybrasc_modo'] = $this->request->post['paybrasc_modo'];
		} 
		else 
		{
			$this->data['paybrasc_modo'] = isset($current_settings['paybrasc_modo']) ? $current_settings['paybrasc_modo'] : ''; 
		} 

		if (isset($this->request->post['paybrasc_nome'])) 
		{
			$this->data['paybrasc_nome'] = $this->request->post['paybrasc_nome'];
		} 
		else 
		{
			$this->data['paybrasc_nome'] = isset($current_settings['paybrasc_nome']) ? $current_settings['paybrasc_nome'] : ''; 
		} 


		
		if (isset($this->request->post['paybrasc_aguardando_pagamento'])) 
		{
			$this->data['paybrasc_aguardando_pagamento'] = $this->request->post['paybrasc_aguardando_pagamento'];
		} 
		else 
		{
			$this->data['paybrasc_aguardando_pagamento'] = isset($current_settings['paybrasc_aguardando_pagamento']) ? $current_settings['paybrasc_aguardando_pagamento'] : ''; 
		} 

		#$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['paybrasc_geo_zone_id'])) 
		{
			$this->data['paybrasc_geo_zone_id'] = $this->request->post['paybrasc_geo_zone_id'];
		} 
		else 
		{
			$this->data['paybrasc_geo_zone_id'] = isset($current_settings['paybrasc_geo_zone_id']) ? $current_settings['paybrasc_geo_zone_id'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasc_email_conta'])) 
		{
			$this->data['paybrasc_email_conta'] = $this->request->post['paybrasc_email_conta'];
		} 
		else 
		{
			$this->data['paybrasc_email_conta'] = isset($current_settings['paybrasc_email_conta']) ? $current_settings['paybrasc_email_conta'] : ''; 
		} 

		if (isset($this->request->post['paybrasc_token'])) 
		{
			$this->data['paybrasc_token'] = $this->request->post['paybrasc_token'];
		} 
		else 
		{
			$this->data['paybrasc_token'] = isset($current_settings['paybrasc_token']) ? $current_settings['paybrasc_token'] : ''; 
		} 

		if (isset($this->request->post['paybrasc_pagamento_analise'])) 
		{
			$this->data['paybrasc_pagamento_analise'] = $this->request->post['paybrasc_pagamento_analise'];
		} 
		else 
		{
			$this->data['paybrasc_pagamento_analise'] = isset($current_settings['paybrasc_pagamento_analise']) ? $current_settings['paybrasc_pagamento_analise'] : ''; 
		} 
if (isset($this->request->post['paybrasc_pagamento_erro'])) 
		{
			$this->data['paybrasc_pagamento_erro'] = $this->request->post['paybrasc_pagamento_erro'];
		} 
		else 
		{
			$this->data['paybrasc_pagamento_erro'] = isset($current_settings['paybrasc_pagamento_erro']) ? $current_settings['paybrasc_pagamento_erro'] : ''; 
		} 
				
		if (isset($this->request->post['paybrasc_pagamento_confirmado'])) 
		{
			$this->data['paybrasc_pagamento_confirmado'] = $this->request->post['paybrasc_pagamento_confirmado'];
		} 
		else 
		{
			$this->data['paybrasc_pagamento_confirmado'] = isset($current_settings['paybrasc_pagamento_confirmado']) ? $current_settings['paybrasc_pagamento_confirmado'] : ''; 
		} 

		if (isset($this->request->post['paybrasc_pagamento_nao_autorizado'])) 
		{
			$this->data['paybrasc_pagamento_nao_autorizado'] = $this->request->post['paybrasc_pagamento_nao_autorizado'];
		} 
		else 
		{
			$this->data['paybrasc_pagamento_nao_autorizado'] = isset($current_settings['paybrasc_pagamento_nao_autorizado']) ? $current_settings['paybrasc_pagamento_nao_autorizado'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasc_pagamento_cancelado'])) 
		{
			$this->data['paybrasc_pagamento_cancelado'] = $this->request->post['paybrasc_pagamento_cancelado'];
		} 
		else 
		{
			$this->data['paybrasc_pagamento_cancelado'] = isset($current_settings['paybrasc_pagamento_cancelado']) ? $current_settings['paybrasc_pagamento_cancelado'] : ''; 
		} 


		if (isset($this->request->post['paybrasc_disputa'])) 
		{
			$this->data['paybrasc_disputa'] = $this->request->post['paybrasc_disputa'];
		} 
		else 
		{
			$this->data['paybrasc_disputa'] = $this->config->get('paybrasc_disputa'); 
		} 
		
		
		
		
		if (isset($this->request->post['paybrasc_pagamento_devolvido'])) 
		{
			$this->data['paybrasc_pagamento_devolvido'] = $this->request->post['paybrasc_pagamento_devolvido'];
		} 
		else 
		{
			$this->data['paybrasc_pagamento_devolvido'] = $this->config->get('paybrasc_pagamento_devolvido'); 
		} 
		
		if (isset($this->request->post['paybrasc_mensagem_confirmado'])) 
		{
			$this->data['paybrasc_mensagem_confirmado'] = $this->request->post['paybrasc_mensagem_confirmado'];
		} 
		else 
		{
			$this->data['paybrasc_mensagem_confirmado'] = $this->config->get('paybrasc_mensagem_confirmado'); 
		} 
		
		if (isset($this->request->post['paybrasc_mensagem_erro'])) 
		{
			$this->data['paybrasc_mensagem_erro'] = $this->request->post['paybrasc_mensagem_erro'];
		} 
		else 
		{
			$this->data['paybrasc_mensagem_erro'] = $this->config->get('paybrasc_mensagem_erro'); 
		} 
		
		if (isset($this->request->post['paybrasc_mensagem_analise'])) 
		{
			$this->data['paybrasc_mensagem_analise'] = $this->request->post['paybrasc_mensagem_analise'];
		} 
		else 
		{
			$this->data['paybrasc_mensagem_analise'] = $this->config->get('paybrasc_mensagem_analise'); 
		} 
		
		if (isset($this->request->post['paybrasc_mensagem_analise'])) 
		{
			$this->data['paybrasc_mensagem_analise'] = $this->request->post['paybrasc_mensagem_analise'];
		} 
		else 
		{
			$this->data['paybrasc_mensagem_analise'] = $this->config->get('paybrasc_mensagem_analise'); 
		} 
		
		if (isset($this->request->post['paybrasc_mensagem_nao_autorizado'])) 
		{
			$this->data['paybrasc_mensagem_nao_autorizado'] = $this->request->post['paybrasc_mensagem_nao_autorizado'];
		} 
		else 
		{
			$this->data['paybrasc_mensagem_nao_autorizado'] = $this->config->get('paybrasc_mensagem_nao_autorizado'); 
		} 
		
		if (isset($this->request->post['paybrasc_pagamento_recusado'])) 
		{
			$this->data['paybrasc_pagamento_recusado'] = $this->request->post['paybrasc_pagamento_recusado'];
		} 
		else 
		{
			$this->data['paybrasc_pagamento_recusado'] = $this->config->get('paybrasc_pagamento_recusado'); 
		} 
		
		
		
		$this->load->model('localisation/geo_zone');
												
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
				
		$this->template = 'payment/paybrasc.tpl';
		$this->children = array(
		'common/header',	
		'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function setStatus()
	{

		$sql="SELECT order_status_id, name FROM ".DB_PREFIX."order_status WHERE language_id=".$this->config->get('config_language_id')."";
		
		$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		$res=$db->query($sql);
		
		$this->status = $res->rows;
		
	}
	
	public function getComboStatus($nome, $selecionado=false)
	{
		if(!$this->status)
		{
			  
			$this->setStatus();
			
		}
		$combo='<select name="'.$nome.'" id="'.$nome.'">';
		
		for($i=0; $i < count($this->status); $i++)
		{
			if($this->status[$i]['order_status_id']!=$selecionado)
				$combo .='<option value="'.$this->status[$i]['order_status_id'].'" >'.$this->status[$i]['name'].'</option>>';
			else
				$combo .='<option value="'.$this->status[$i]['order_status_id'].'" selected="selected">'.$this->status[$i]['name'].'</option>>';
			
		}
		
		$combo .="</select>";
		
		
		return ($combo);
		
		
	}
	
	public function install()
	{
		
		$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		
		#primeiro verifica se o campo existe
		$sql="SELECT * 
		FROM information_schema.COLUMNS 
		WHERE 
			TABLE_SCHEMA = '".DB_DATABASE."' 
		AND TABLE_NAME = '".DB_PREFIX."order' 
		AND COLUMN_NAME = 'id_transacao_paybras'";
		$configura=$db->query($sql);
		
		if($configura->num_rows==0)
		{
		
		#cria o campo
		$db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `id_transacao_paybras` VARCHAR(36) NULL ;");
		
		
		}
		
		$sql="SELECT * 
		FROM information_schema.COLUMNS 
		WHERE 
			TABLE_SCHEMA = '".DB_DATABASE."' 
		AND TABLE_NAME = '".DB_PREFIX."order' 
		AND COLUMN_NAME = 'url_paybras'";
		$configura=$db->query($sql);
		
		if($configura->num_rows==0)
		{
		
		#cria o campo
		$db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `url_paybras` TEXT NULL ;");
		
		
		}
		
	}
}
?>
