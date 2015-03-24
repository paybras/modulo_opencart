<?php 
/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
class ControllerPaymentPaybrasT extends Controller 
{
	private $error = array(); 
	private $status;

	public function index() 
	{
		$this->load->language('payment/paybrast');
		
		$titulo = 'Paybras Transparente - Boleto Bancário';
		$this->load->model('setting/setting');
		$this->document->setTitle($titulo);
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') 
		{
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('paybrast', $this->request->post);				
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
		 'href'      => HTTPS_SERVER . 'index.php?route=payment/paybrast',
		 'text'      => 'Paybras Transparente - Boleto Bancário',
		 'separator' => ' :: '
		 );
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/paybrast&token=' . $this->session->data['token'];
				
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
        $current_settings = $this->model_setting_setting->getSetting('paybrast');

		if (isset($this->request->post['paybrast_sort_order'])) 
		{
			$this->data['paybrast_sort_order'] = $this->request->post['paybrast_sort_order'];
		} 
		else 
		{
			$this->data['paybrast_sort_order'] = isset($current_settings['paybrast_sort_order']) ? $current_settings['paybrast_sort_order'] : ''; 
		} 
		if (isset($this->request->post['paybrast_modo'])) 
		{
			$this->data['paybrast_modo'] = $this->request->post['paybrast_modo'];
		} 
		else 
		{
			$this->data['paybrast_modo'] = isset($current_settings['paybrast_modo']) ? $current_settings['paybrast_modo'] : ''; 
		} 
		
				if (isset($this->request->post['paybrast_status'])) 
		{
			$this->data['paybrast_status'] = $this->request->post['paybrast_status'];
		} 
		else 
		{
			$this->data['paybrast_status'] = isset($current_settings['paybrast_status']) ? $current_settings['paybrast_status'] : ''; 
		} 
		
		if (isset($this->request->post['paybrast_erro'])) 
		{
			$this->data['paybrast_erro'] = $this->request->post['paybrast_erro'];
		} 
		else 
		{
			$this->data['paybrast_erro'] = isset($current_settings['paybrast_erro']) ? $current_settings['paybrast_erro'] : ''; 
		} 
		
		if (isset($this->request->post['paybrast_logo'])) 
		{
			$this->data['paybrast_logo'] = $this->request->post['paybrast_logo'];
		} 
		else 
		{
			$this->data['paybrast_logo'] = isset($current_settings['paybrast_logo']) ? $current_settings['paybrast_logo'] : ''; 
		} 
		
		if (isset($this->request->post['paybrast_template'])) 
		{
			$this->data['paybrast_template'] = $this->request->post['paybrast_template'];
		} 
		else 
		{
			$this->data['paybrast_template'] = isset($current_settings['paybrast_template']) ? $current_settings['paybrast_template'] : ''; 
		} 

		if (isset($this->request->post['paybrast_tipo_conta'])) 
		{
			$this->data['paybrast_modo'] = $this->request->post['paybrast_modo'];
		} 
		else 
		{
			$this->data['paybrast_modo'] = isset($current_settings['paybrast_modo']) ? $current_settings['paybrast_modo'] : ''; 
		} 

		if (isset($this->request->post['paybrast_nome'])) 
		{
			$this->data['paybrast_nome'] = $this->request->post['paybrast_nome'];
		} 
		else 
		{
			$this->data['paybrast_nome'] = isset($current_settings['paybrast_nome']) ? $current_settings['paybrast_nome'] : ''; 
		} 


		
		if (isset($this->request->post['paybrast_aguardando_pagamento'])) 
		{
			$this->data['paybrast_aguardando_pagamento'] = $this->request->post['paybrast_aguardando_pagamento'];
		} 
		else 
		{
			$this->data['paybrast_aguardando_pagamento'] = isset($current_settings['paybrast_aguardando_pagamento']) ? $current_settings['paybrast_aguardando_pagamento'] : ''; 
		} 

		#$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['paybrast_geo_zone_id'])) 
		{
			$this->data['paybrast_geo_zone_id'] = $this->request->post['paybrast_geo_zone_id'];
		} 
		else 
		{
			$this->data['paybrast_geo_zone_id'] = isset($current_settings['paybrast_geo_zone_id']) ? $current_settings['paybrast_geo_zone_id'] : ''; 
		} 
		
		if (isset($this->request->post['paybrast_email_conta'])) 
		{
			$this->data['paybrast_email_conta'] = $this->request->post['paybrast_email_conta'];
		} 
		else 
		{
			$this->data['paybrast_email_conta'] = isset($current_settings['paybrast_email_conta']) ? $current_settings['paybrast_email_conta'] : ''; 
		} 

		if (isset($this->request->post['paybrast_token'])) 
		{
			$this->data['paybrast_token'] = $this->request->post['paybrast_token'];
		} 
		else 
		{
			$this->data['paybrast_token'] = isset($current_settings['paybrast_token']) ? $current_settings['paybrast_token'] : ''; 
		} 

		if (isset($this->request->post['paybrast_pagamento_analise'])) 
		{
			$this->data['paybrast_pagamento_analise'] = $this->request->post['paybrast_pagamento_analise'];
		} 
		else 
		{
			$this->data['paybrast_pagamento_analise'] = isset($current_settings['paybrast_pagamento_analise']) ? $current_settings['paybrast_pagamento_analise'] : ''; 
		} 
if (isset($this->request->post['paybrast_pagamento_erro'])) 
		{
			$this->data['paybrast_pagamento_erro'] = $this->request->post['paybrast_pagamento_erro'];
		} 
		else 
		{
			$this->data['paybrast_pagamento_erro'] = isset($current_settings['paybrast_pagamento_erro']) ? $current_settings['paybrast_pagamento_erro'] : ''; 
		} 
				
		if (isset($this->request->post['paybrast_pagamento_confirmado'])) 
		{
			$this->data['paybrast_pagamento_confirmado'] = $this->request->post['paybrast_pagamento_confirmado'];
		} 
		else 
		{
			$this->data['paybrast_pagamento_confirmado'] = isset($current_settings['paybrast_pagamento_confirmado']) ? $current_settings['paybrast_pagamento_confirmado'] : ''; 
		} 

		if (isset($this->request->post['paybrast_pagamento_nao_autorizado'])) 
		{
			$this->data['paybrast_pagamento_nao_autorizado'] = $this->request->post['paybrast_pagamento_nao_autorizado'];
		} 
		else 
		{
			$this->data['paybrast_pagamento_nao_autorizado'] = isset($current_settings['paybrast_pagamento_nao_autorizado']) ? $current_settings['paybrast_pagamento_nao_autorizado'] : ''; 
		} 
		
		if (isset($this->request->post['paybrast_pagamento_cancelado'])) 
		{
			$this->data['paybrast_pagamento_cancelado'] = $this->request->post['paybrast_pagamento_cancelado'];
		} 
		else 
		{
			$this->data['paybrast_pagamento_cancelado'] = isset($current_settings['paybrast_pagamento_cancelado']) ? $current_settings['paybrast_pagamento_cancelado'] : ''; 
		} 


		if (isset($this->request->post['paybrast_disputa'])) 
		{
			$this->data['paybrast_disputa'] = $this->request->post['paybrast_disputa'];
		} 
		else 
		{
			$this->data['paybrast_disputa'] = $this->config->get('paybrast_disputa'); 
		} 
		
		
		
		
		if (isset($this->request->post['paybrast_devolvido'])) 
		{
			$this->data['paybrast_devolvido'] = $this->request->post['paybrast_devolvido'];
		} 
		else 
		{
			$this->data['paybrast_devolvido'] = $this->config->get('paybrast_devolvido'); 
		} 
		
		
		$this->load->model('localisation/geo_zone');
												
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
				
		$this->template = 'payment/paybrast.tpl';
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
