<?php
class ControllerModuleDados extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/dados');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
                
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_setting_setting->editSetting('dados', $this->request->post);		                                 
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
                
               
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
                $this->data['link'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'], 'SSL');
                
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/dados', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/dados', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['dados_status'])) {
			$this->data['dados_status'] = $this->request->post['dados_status'];
                       
		} elseif ($this->config->get('dados_status')) { 
			$this->data['dados_status'] = $this->config->get('dados_status');
		}
		
		if (isset($this->request->post['dados_cpf'])) {
			$this->data['dados_cpf'] = $this->request->post['dados_cpf'];
                       
		} elseif ($this->config->get('dados_cpf')) { 
			$this->data['dados_cpf'] = $this->config->get('dados_cpf');
		} else {
			$this->data['dados_cpf'] = 0;
		}

		
		if (isset($this->request->post['dados_cnpj'])) {
			$this->data['dados_cnpj'] = $this->request->post['dados_cnpj'];
                       
		} elseif ($this->config->get('dados_cnpj')) { 
			$this->data['dados_cnpj'] = $this->config->get('dados_cnpj');
		} else {
			$this->data['dados_cnpj'] = 0;
		}

		if (isset($this->request->post['dados_nascimento'])) {
			$this->data['dados_nascimento'] = $this->request->post['dados_nascimento'];
                       
		} elseif ($this->config->get('dados_nascimento')) { 
			$this->data['dados_nascimento'] = $this->config->get('dados_nascimento');
		} else {
			$this->data['dados_nascimento'] = 0;
		}
                
		
        // chama a view
		$this->template = 'module/dados.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	/*
	function add_column_if_not_exist($db, $column, $column_attr = "VARCHAR( 255 ) NULL" ){
		$exists = false;
		$columns = mysql_query("show columns from $db");
		while($c = mysql_fetch_assoc($columns)){
			if($c['Field'] == $column){
				$exists = true;
				break;
			}
		}      
		if(!$exists){
			mysql_query("ALTER TABLE `$db` ADD `$column`  $column_attr");
		}
	}
	*/
    public function install() {
	 /*
		$this->add_column_if_not_exist("customer","cpf","VARCHAR( 14 ) NOT NULL AFTER  `telephone`");
		$this->add_column_if_not_exist("customer","cnpj","VARCHAR( 18 ) NOT NULL AFTER  `cpf`");
		$this->add_column_if_not_exist("customer","razao_social","VARCHAR( 250 ) NOT NULL AFTER  `cnpj`");
		$this->add_column_if_not_exist("customer","inscricao_estadual","VARCHAR( 200 ) NOT NULL AFTER  `razao_social`");
		$this->add_column_if_not_exist("customer","ddd","VARCHAR( 4 ) NOT NULL AFTER  `inscricao_estadual`");
		$this->add_column_if_not_exist("customer","data_nascimento","DATE NOT NULL AFTER  `ddd`");
		
		
		$this->add_column_if_not_exist("address","numero","VARCHAR( 15 ) NOT NULL AFTER  `address_1`");
		$this->add_column_if_not_exist("address","complemento","VARCHAR( 200 ) NOT NULL AFTER  `numero`");
	
	
		$this->add_column_if_not_exist("order","shipping_numero","VARCHAR( 15 ) NOT NULL AFTER  `shipping_address_1`");
		$this->add_column_if_not_exist("order","shipping_complemento","VARCHAR( 200 ) NOT NULL AFTER  `shipping_numero`");
		$this->add_column_if_not_exist("order","payment_numero","VARCHAR( 15 ) NOT NULL AFTER  `payment_address_1`");
		$this->add_column_if_not_exist("order","payment_complemento","VARCHAR( 200 ) NOT NULL AFTER  `payment_numero`");
		$this->add_column_if_not_exist("order","ddd","VARCHAR( 4 ) NOT NULL AFTER  `email`");
		*/
		
       $query = $this->db->query("ALTER TABLE  " . DB_PREFIX . "customer ADD  `cpf` VARCHAR( 14 ) NOT NULL AFTER  `telephone` ,
			ADD  `cnpj` VARCHAR( 18 ) NOT NULL AFTER  `cpf` ,
			ADD  `razao_social` VARCHAR( 250 ) NOT NULL AFTER  `cnpj` ,
			ADD  `inscricao_estadual` VARCHAR( 200 ) NOT NULL AFTER  `razao_social` ,
			ADD  `ddd` VARCHAR( 4 ) NOT NULL AFTER  `inscricao_estadual` ,
			ADD  `data_nascimento` DATE NOT NULL AFTER  `ddd`");	

		$query = $this->db->query("ALTER TABLE  " . DB_PREFIX . "address 
			ADD  `numero` VARCHAR( 15 ) NOT NULL AFTER  `address_1` ,
			ADD  `complemento` VARCHAR( 200 ) NOT NULL AFTER  `numero` ");
			
		$query = $this->db->query("ALTER TABLE  `" . DB_PREFIX . "order`  
			ADD  `shipping_numero` VARCHAR( 15 ) NOT NULL AFTER  `shipping_address_1` ,
			ADD  `shipping_complemento` VARCHAR( 200 ) NOT NULL AFTER  `shipping_numero`");
			
		$query = $this->db->query("ALTER TABLE  `" . DB_PREFIX . "order`  
			ADD  `payment_numero` VARCHAR( 15 ) NOT NULL AFTER  `payment_address_1` ,
			ADD  `payment_complemento` VARCHAR( 200 ) NOT NULL AFTER  `payment_numero` ");
			
		$query = $this->db->query("ALTER TABLE  `" . DB_PREFIX . "order`  
			ADD  `ddd` VARCHAR( 4 ) NOT NULL AFTER  `email` ");		
			
	}
		
		
    public function uninstall() { 
		  /*
		  $query = $this->db->query("ALTER TABLE `" . DB_PREFIX . "customer`
		  DROP `cpf`,
		  DROP `cnpj`,
		  DROP `razao_social`,
		  DROP `inscricao_estadual`,
		  DROP `ddd`,
		  DROP `data_nascimento`;");
		  
		  $query = $this->db->query("ALTER TABLE `" . DB_PREFIX . "address`
		  DROP `numero`,
		  DROP `complemento`;");	

		  $query = $this->db->query("ALTER TABLE `" . DB_PREFIX . "order`
		  DROP `ddd`,
		  DROP `shipping_numero`,
		  DROP `shipping_complemento`,
		  DROP `payment_numero`,
		  DROP `payment_complemento`;");	
		  */

		  
		  
		  $this->load->model('setting/setting');
		  $this->model_setting_setting->editSetting('dados', array('dados_status' => '0'));			  
    }        
}
?>