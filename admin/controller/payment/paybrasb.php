<?php 
/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
class ControllerPaymentPaybrasB extends Controller 
{
	private $error = array(); 
	private $status;

	public function index() 
	{
		$this->load->language('payment/paybrasb');
		
		$titulo = 'Paybrás Transparente - Boleto Bancário';
		$this->load->model('setting/setting');
		$this->document->setTitle($titulo);
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') 
		{
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('paybrasb', $this->request->post);				
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
		 'href'      => HTTPS_SERVER . 'index.php?route=payment/paybrasb',
		 'text'      => 'Paybras Transparente - Boleto Bancário',
		 'separator' => ' :: '
		 );
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/paybrasb&token=' . $this->session->data['token'];
				
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
        $current_settings = $this->model_setting_setting->getSetting('paybrasb');

		if (isset($this->request->post['paybrasb_sort_order'])) 
		{
			$this->data['paybrasb_sort_order'] = $this->request->post['paybrasb_sort_order'];
		} 
		else 
		{
			$this->data['paybrasb_sort_order'] = isset($current_settings['paybrasb_sort_order']) ? $current_settings['paybrasb_sort_order'] : ''; 
		} 
		if (isset($this->request->post['paybrasb_desconto'])) 
		{
			$this->data['paybrasb_desconto'] = $this->request->post['paybrasb_desconto'];
		} 
		else 
		{
			$this->data['paybrasb_desconto'] = isset($current_settings['paybrasb_desconto']) ? $current_settings['paybrasb_desconto'] : ''; 
		} 
		if (isset($this->request->post['paybrasb_modo'])) 
		{
			$this->data['paybrasb_modo'] = $this->request->post['paybrasb_modo'];
		} 
		else 
		{
			$this->data['paybrasb_modo'] = isset($current_settings['paybrasb_modo']) ? $current_settings['paybrasb_modo'] : ''; 
		} 
		
				if (isset($this->request->post['paybrasb_status'])) 
		{
			$this->data['paybrasb_status'] = $this->request->post['paybrasb_status'];
		} 
		else 
		{
			$this->data['paybrasb_status'] = isset($current_settings['paybrasb_status']) ? $current_settings['paybrasb_status'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasb_logo'])) 
		{
			$this->data['paybrasb_logo'] = $this->request->post['paybrasb_logo'];
		} 
		else 
		{
			$this->data['paybrasb_logo'] = isset($current_settings['paybrasb_logo']) ? $current_settings['paybrasb_logo'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasb_erro'])) 
		{
			$this->data['paybrasb_erro'] = $this->request->post['paybrasb_erro'];
		} 
		else 
		{
			$this->data['paybrasb_erro'] = isset($current_settings['paybrasb_erro']) ? $current_settings['paybrasb_erro'] : ''; 
		} 
		 
		if (isset($this->request->post['paybrasb_template'])) 
		{
			$this->data['paybrasb_template'] = $this->request->post['paybrasb_template'];
		} 
		else 
		{
			$this->data['paybrasb_template'] = isset($current_settings['paybrasb_template']) ? $current_settings['paybrasb_template'] : ''; 
		} 
		
		

		if (isset($this->request->post['paybrasb_tipo_conta'])) 
		{
			$this->data['paybrasb_modo'] = $this->request->post['paybrasb_modo'];
		} 
		else 
		{
			$this->data['paybrasb_modo'] = isset($current_settings['paybrasb_modo']) ? $current_settings['paybrasb_modo'] : ''; 
		} 

		if (isset($this->request->post['paybrasb_nome'])) 
		{
			$this->data['paybrasb_nome'] = $this->request->post['paybrasb_nome'];
		} 
		else 
		{
			$this->data['paybrasb_nome'] = isset($current_settings['paybrasb_nome']) ? $current_settings['paybrasb_nome'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasb_mensagem_aguardando'])) 
		{
			$this->data['paybrasb_mensagem_aguardando'] = $this->request->post['paybrasb_mensagem_aguardando'];
		} 
		else 
		{
			$this->data['paybrasb_mensagem_aguardando'] = isset($current_settings['paybrasb_mensagem_aguardando']) ? $current_settings['paybrasb_mensagem_aguardando'] : ''; 
		} 


		
		if (isset($this->request->post['paybrasb_aguardando_pagamento'])) 
		{
			$this->data['paybrasb_aguardando_pagamento'] = $this->request->post['paybrasb_aguardando_pagamento'];
		} 
		else 
		{
			$this->data['paybrasb_aguardando_pagamento'] = isset($current_settings['paybrasb_aguardando_pagamento']) ? $current_settings['paybrasb_aguardando_pagamento'] : ''; 
		} 

		#$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['paybrasb_geo_zone_id'])) 
		{
			$this->data['paybrasb_geo_zone_id'] = $this->request->post['paybrasb_geo_zone_id'];
		} 
		else 
		{
			$this->data['paybrasb_geo_zone_id'] = isset($current_settings['paybrasb_geo_zone_id']) ? $current_settings['paybrasb_geo_zone_id'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasb_email_conta'])) 
		{
			$this->data['paybrasb_email_conta'] = $this->request->post['paybrasb_email_conta'];
		} 
		else 
		{
			$this->data['paybrasb_email_conta'] = isset($current_settings['paybrasb_email_conta']) ? $current_settings['paybrasb_email_conta'] : ''; 
		} 

		if (isset($this->request->post['paybrasb_token'])) 
		{
			$this->data['paybrasb_token'] = $this->request->post['paybrasb_token'];
		} 
		else 
		{
			$this->data['paybrasb_token'] = isset($current_settings['paybrasb_token']) ? $current_settings['paybrasb_token'] : ''; 
		} 

		if (isset($this->request->post['paybrasb_pagamento_analise'])) 
		{
			$this->data['paybrasb_pagamento_analise'] = $this->request->post['paybrasb_pagamento_analise'];
		} 
		else 
		{
			$this->data['paybrasb_pagamento_analise'] = isset($current_settings['paybrasb_pagamento_analise']) ? $current_settings['paybrasb_pagamento_analise'] : ''; 
		} 
if (isset($this->request->post['paybrasb_pagamento_erro'])) 
		{
			$this->data['paybrasb_pagamento_erro'] = $this->request->post['paybrasb_pagamento_erro'];
		} 
		else 
		{
			$this->data['paybrasb_pagamento_erro'] = isset($current_settings['paybrasb_pagamento_erro']) ? $current_settings['paybrasb_pagamento_erro'] : ''; 
		} 
				
		if (isset($this->request->post['paybrasb_pagamento_confirmado'])) 
		{
			$this->data['paybrasb_pagamento_confirmado'] = $this->request->post['paybrasb_pagamento_confirmado'];
		} 
		else 
		{
			$this->data['paybrasb_pagamento_confirmado'] = isset($current_settings['paybrasb_pagamento_confirmado']) ? $current_settings['paybrasb_pagamento_confirmado'] : ''; 
		} 

		if (isset($this->request->post['paybrasb_pagamento_nao_autorizado'])) 
		{
			$this->data['paybrasb_pagamento_nao_autorizado'] = $this->request->post['paybrasb_pagamento_nao_autorizado'];
		} 
		else 
		{
			$this->data['paybrasb_pagamento_nao_autorizado'] = isset($current_settings['paybrasb_pagamento_nao_autorizado']) ? $current_settings['paybrasb_pagamento_nao_autorizado'] : ''; 
		} 
		
		if (isset($this->request->post['paybrasb_pagamento_cancelado'])) 
		{
			$this->data['paybrasb_pagamento_cancelado'] = $this->request->post['paybrasb_pagamento_cancelado'];
		} 
		else 
		{
			$this->data['paybrasb_pagamento_cancelado'] = isset($current_settings['paybrasb_pagamento_cancelado']) ? $current_settings['paybrasb_pagamento_cancelado'] : ''; 
		} 


		if (isset($this->request->post['paybrasb_disputa'])) 
		{
			$this->data['paybrasb_disputa'] = $this->request->post['paybrasb_disputa'];
		} 
		else 
		{
			$this->data['paybrasb_disputa'] = $this->config->get('paybrasb_disputa'); 
		} 
		
		
		
		
		if (isset($this->request->post['paybrasb_devolvido'])) 
		{
			$this->data['paybrasb_devolvido'] = $this->request->post['paybrasb_devolvido'];
		} 
		else 
		{
			$this->data['paybrasb_devolvido'] = $this->config->get('paybrasb_devolvido'); 
		} 
		
		
		$this->load->model('localisation/geo_zone');
												
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
				
		$this->template = 'payment/paybrasb.tpl';
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
