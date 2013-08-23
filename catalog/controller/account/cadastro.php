<?php 
class ControllerAccountCadastro extends Controller {
	private $error = array();
	// inicio módulo cpf ###############################################   
	public function estado_autocompletar() {
		$this->load->model('localisation/zone');
		$code = $this->model_localisation_zone->getZonesByEstado($this->request->get['estado']);
		if ($code <> "") {
			$output = '<option value="' . $code . '" selected="selected"> '.$this->request->get['estado'].'</option>';
		}else{
			$output = "";
		}
		$this->response->setOutput($output);
	} 
	
  	public function index() {
  		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		if ($this->customer->isLogged()) {
	  		$this->redirect($this->url->link('account/account', '', 'SSL'));
    	}
		
    	$this->language->load('account/register');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
			
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			// inicio módulo cpf ###############################################
			
			/* se for como visitante
			if ($this->request->post['visitante']){
				//$this->session->data['guest']['customer_group_id'] = $customer_group_id;
				$this->session->data['guest']['firstname'] = $this->request->post['firstname'];
				$this->session->data['guest']['lastname'] = '';
				$this->session->data['guest']['email'] = $this->request->post['email'];
				$this->session->data['guest']['telephone'] = $this->request->post['telephone'];
				$this->session->data['guest']['fax'] = $this->request->post['fax'];
				
				$this->session->data['guest']['payment']['firstname'] = $this->request->post['firstname'];
				$this->session->data['guest']['payment']['lastname'] = '';				
				$this->session->data['guest']['payment']['company'] = '';
				$this->session->data['guest']['payment']['company_id'] = '';
				$this->session->data['guest']['payment']['tax_id'] = '';
				$this->session->data['guest']['payment']['address_1'] = $this->request->post['address_1'];
				$this->session->data['guest']['payment']['address_2'] = $this->request->post['address_2'];
				$this->session->data['guest']['payment']['postcode'] = $this->request->post['postcode'];
				$this->session->data['guest']['payment']['city'] = $this->request->post['city'];
				$this->session->data['guest']['payment']['country_id'] = $this->request->post['country_id'];
				$this->session->data['guest']['payment']['zone_id'] = $this->request->post['zone_id'];
				
				$this->load->model('localisation/country');
		
				$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
				
				if ($country_info) {
					$this->session->data['guest']['payment']['country'] = $country_info['name'];	
					$this->session->data['guest']['payment']['iso_code_2'] = $country_info['iso_code_2'];
					$this->session->data['guest']['payment']['iso_code_3'] = $country_info['iso_code_3'];
					$this->session->data['guest']['payment']['address_format'] = $country_info['address_format'];
				} else {
					$this->session->data['guest']['payment']['country'] = '';	
					$this->session->data['guest']['payment']['iso_code_2'] = '';
					$this->session->data['guest']['payment']['iso_code_3'] = '';
					$this->session->data['guest']['payment']['address_format'] = '';
				}
							
				$this->load->model('localisation/zone');

				$zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);
				
				if ($zone_info) {
					$this->session->data['guest']['payment']['zone'] = $zone_info['name'];
					$this->session->data['guest']['payment']['zone_code'] = $zone_info['code'];
				} else {
					$this->session->data['guest']['payment']['zone'] = '';
					$this->session->data['guest']['payment']['zone_code'] = '';
				}
				
				
				// Default Payment Address
				$this->session->data['payment_country_id'] = $this->request->post['country_id'];
				$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
				
				
				$this->session->data['guest']['shipping']['firstname'] = $this->request->post['firstname'];
				$this->session->data['guest']['shipping']['lastname'] = '';
				$this->session->data['guest']['shipping']['company'] = '';
				$this->session->data['guest']['shipping']['address_1'] = $this->request->post['address_1'];
				$this->session->data['guest']['shipping']['address_2'] = $this->request->post['address_2'];
				$this->session->data['guest']['shipping']['postcode'] = $this->request->post['postcode'];
				$this->session->data['guest']['shipping']['city'] = $this->request->post['city'];
				$this->session->data['guest']['shipping']['country_id'] = $this->request->post['country_id'];
				$this->session->data['guest']['shipping']['zone_id'] = $this->request->post['zone_id'];
				
				if ($country_info) {
					$this->session->data['guest']['shipping']['country'] = $country_info['name'];	
					$this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
					$this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
					$this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
				} else {
					$this->session->data['guest']['shipping']['country'] = '';	
					$this->session->data['guest']['shipping']['iso_code_2'] = '';
					$this->session->data['guest']['shipping']['iso_code_3'] = '';
					$this->session->data['guest']['shipping']['address_format'] = '';
				}
	
				if ($zone_info) {
					$this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
					$this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
				} else {
					$this->session->data['guest']['shipping']['zone'] = '';
					$this->session->data['guest']['shipping']['zone_code'] = '';
				}
				
				// Default Shipping Address
				$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
				$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
				$this->session->data['shipping_postcode'] = $this->request->post['postcode'];
			
				
				$this->session->data['account'] = 'guest';
				
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}else{
			*/
				//se for cadastro normal
				
				if (isset($this->request->post['visitante'])) {
					$this->request->post['password'] = rand(100000000,999999999);
				}
				
				$this->model_account_customer->addCustomer($this->request->post);

				$this->customer->login($this->request->post['email'], $this->request->post['password']);

				unset($this->session->data['guest']);
				
				// Default Shipping Address
				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
					$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
					$this->session->data['shipping_postcode'] = $this->request->post['postcode'];				
				}
				
				// Default Payment Address
				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_country_id'] = $this->request->post['country_id'];
					$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];			
				}
			// }
							  	    		
			if ($this->cart->hasShipping()){			  	  
				$this->redirect($this->url->link('checkout/checkout'));
			}else{
				$this->redirect($this->url->link('account/success'));
			}	
			// fim módulo cpf ###############################################
			
    	} 

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_register'),
			'href'      => $this->url->link('account/cadastro', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', 'SSL'));
		$this->data['text_your_details'] = $this->language->get('text_your_details');
    	$this->data['text_your_address'] = $this->language->get('text_your_address');
    	$this->data['text_your_password'] = $this->language->get('text_your_password');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
						
    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
    	$this->data['entry_address_1'] = $this->language->get('entry_address_1');
    	$this->data['entry_address_2'] = $this->language->get('entry_address_2');
    	$this->data['entry_postcode'] = $this->language->get('entry_postcode');
    	$this->data['entry_city'] = $this->language->get('entry_city');
    	$this->data['entry_country'] = $this->language->get('entry_country');
    	$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');

		$this->data['button_continue'] = $this->language->get('button_continue');
    
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}	
		
		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}	
		// inicio módulo cpf ###############################################   
		if (isset($this->error['data_nascimento'])) {
			$this->data['error_data_nascimento'] = $this->error['data_nascimento'];
		} else {
			$this->data['error_data_nascimento'] = '';
		}
				
		if (isset($this->error['cpf'])) {
			$this->data['error_cpf'] = $this->error['cpf'];
		} else {
			$this->data['error_cpf'] = '';
		}
				
		if (isset($this->error['cnpj'])) {
			$this->data['error_cnpj'] = $this->error['cnpj'];
		} else {
			$this->data['error_cnpj'] = '';
		}
		if (isset($this->error['ddd'])) {
			$this->data['error_ddd'] = $this->error['ddd'];
		} else {
			$this->data['error_ddd'] = '';
		}
		if (isset($this->error['numero'])) {
			$this->data['error_numero'] = $this->error['numero'];
		} else {
			$this->data['error_numero'] = '';
		}	
		// fim módulo cpf ###############################################   
	
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
		
		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
 		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}
		
  		if (isset($this->error['company_id'])) {
			$this->data['error_company_id'] = $this->error['company_id'];
		} else {
			$this->data['error_company_id'] = '';
		}
		
  		if (isset($this->error['tax_id'])) {
			$this->data['error_tax_id'] = $this->error['tax_id'];
		} else {
			$this->data['error_tax_id'] = '';
		}
								
  		if (isset($this->error['address_1'])) {
			$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}
   		
		if (isset($this->error['city'])) {
			$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}
		
		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$this->data['error_zone'] = $this->error['zone'];
		} else {
			$this->data['error_zone'] = '';
		}
		
    	$this->data['action'] = $this->url->link('account/cadastro', '', 'SSL');
		
		if (isset($this->request->post['firstname'])) {
    		$this->data['firstname'] = $this->request->post['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
    		$this->data['lastname'] = $this->request->post['lastname'];
		} else {
			$this->data['lastname'] = '';
		}
		
		if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
    		$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = '';
		}
		
		// inicio módulo cpf ###############################################   
		if (isset($this->request->post['data_nascimento'])) {
			$this->data['data_nascimento'] = $this->request->post['data_nascimento'];
		} else {
			$this->data['data_nascimento'] = '';
		}
		if (isset($this->request->post['pessoa'])) {
			$this->data['pessoa'] = $this->request->post['pessoa'];
		} else {
			$this->data['pessoa'] = '';
		}
		if (isset($this->request->post['cpf'])) {
			$this->data['cpf'] = $this->request->post['cpf'];
		} else {
			$this->data['cpf'] = '';
		}
		if (isset($this->request->post['cnpj'])) {
				$this->data['cnpj'] = $this->request->post['cnpj'];
		} else {
			$this->data['cnpj'] = '';
		}
		if (isset($this->request->post['razao_social'])) {
				$this->data['razao_social'] = $this->request->post['razao_social'];
		} else {
			$this->data['razao_social'] = '';
		}
		if (isset($this->request->post['inscricao_estadual'])) {
				$this->data['inscricao_estadual'] = $this->request->post['inscricao_estadual'];
		} else {
			$this->data['inscricao_estadual'] = '';
		}
		
		if (isset($this->request->post['ddd'])) {
				$this->data['ddd'] = $this->request->post['ddd'];
		} else {
			$this->data['ddd'] = '';
		}
		if (isset($this->request->post['numero'])) {
				$this->data['numero'] = $this->request->post['numero'];
		} else {
			$this->data['numero'] = '';
		}
		
		if (isset($this->request->post['complemento'])) {
			$this->data['complemento'] = $this->request->post['complemento'];
		} else {
			$this->data['complemento'] = '';
		}
		
	
		// fim módulo cpf ###############################################   
		
		if (isset($this->request->post['fax'])) {
    		$this->data['fax'] = $this->request->post['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['company'])) {
    		$this->data['company'] = $this->request->post['company'];
		} else {
			$this->data['company'] = '';
		}

		$this->load->model('account/customer_group');
		
		$this->data['customer_groups'] = array();
		
		if (is_array($this->config->get('config_customer_group_display'))) {
			$customer_groups = $this->model_account_customer_group->getCustomerGroups();
			
			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}
		
		if (isset($this->request->post['customer_group_id'])) {
    		$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}
		
		// Company ID
		if (isset($this->request->post['company_id'])) {
    		$this->data['company_id'] = $this->request->post['company_id'];
		} else {
			$this->data['company_id'] = '';
		}
		
		// Tax ID
		if (isset($this->request->post['tax_id'])) {
    		$this->data['tax_id'] = $this->request->post['tax_id'];
		} else {
			$this->data['tax_id'] = '';
		}
						
		if (isset($this->request->post['address_1'])) {
    		$this->data['address_1'] = $this->request->post['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
    		$this->data['address_2'] = $this->request->post['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
    		$this->data['postcode'] = $this->request->post['postcode'];
		//} elseif (isset($this->session->data['shipping_postcode'])) {
			//$this->data['postcode'] = $this->session->data['shipping_postcode'];		
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->request->post['city'])) {
    		$this->data['city'] = $this->request->post['city'];
		} else {
			$this->data['city'] = '';
		}

    	if (isset($this->request->post['country_id'])) {
      		$this->data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_country_id'];		
		} else {	
      		$this->data['country_id'] = $this->config->get('config_country_id');
    	}

    	if (isset($this->request->post['zone_id'])) {
      		$this->data['zone_id'] = $this->request->post['zone_id']; 	
		} elseif (isset($this->session->data['shipping_zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_zone_id'];			
		} else {
      		$this->data['zone_id'] = '';
    	}
		
		$this->load->model('localisation/country');
		
    	$this->data['countries'] = $this->model_localisation_country->getCountries();
		
		if (isset($this->request->post['password'])) {
    		$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) {
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}
		
		if (isset($this->request->post['newsletter'])) {
    		$this->data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$this->data['newsletter'] = '';
		}	

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		
		if (isset($this->request->post['agree'])) {
      		$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/cadastro.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/cadastro.tpl';
		} else {
			$this->template = 'default/template/account/cadastro.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
				
		$this->response->setOutput($this->render());	
  	}

  	private function validate() {
    	if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
      		$this->error['firstname'] = "O Nome Completo é obrigatório e deve ter entre 1 e 32 caracteres!";
    	}

    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		// inicio módulo cpf ###############################################   
		// separa a data
		$dataparts = explode("/",$this->request->post['data_nascimento']);
		// se o campo de data for preenchido ai será validado
		if (strlen(utf8_decode($this->request->post['data_nascimento'])) > 0) {
			// se a array n?o tiver 3 posições nem checa a data
			if (sizeof($dataparts)<>"3"){
				$this->error['data_nascimento'] = "Essa data não é válida";
			}else{
				//checa se o que foi digitado a data
				if (!checkdate($dataparts[1],$dataparts[0],$dataparts[2])) {
						$this->error['data_nascimento'] = "Essa data não é válida";
				}
			} 
		}elseif (strlen(utf8_decode($this->request->post['data_nascimento'])) < 1) {
			if ($this->config->get('dados_nascimento')){
				$this->error['data_nascimento'] = "O campo Data de Nascimento é obrigatório";  
			}
		}
		
		
		if ($this->request->post['pessoa'] == "fisica"){
			if ($this->config->get('dados_cpf')){
				if ((strlen(utf8_decode($this->request->post['cpf'])) < 1) || (strlen(utf8_decode($this->request->post['cpf'])) > 14)) {
						$this->error['cpf'] = "O CPF é obrigatório";  
				}elseif (!$this->customer->cpf($this->request->post['cpf'])){
					$this->error['cpf'] = "O CPF é inválido!";  
				}
			}
		}else if ($this->request->post['pessoa'] == "juridica"){
			if ($this->config->get('dados_cnpj')){
				 if ((strlen(utf8_decode($this->request->post['cnpj'])) < 1) || (strlen(utf8_decode($this->request->post['cnpj'])) > 18)&&($this->request->post['pessoa'] == "juridica")) {
				$this->error['cnpj'] = "O CNPJ é obrigatório";
				}elseif (!$this->customer->cnpj($this->request->post['cnpj'])){
					$this->error['cnpj'] = "O CNPJ é inválido!";  
				}
			}	
		}
		
		if ((strlen(utf8_decode($this->request->post['ddd'])) < 1)) {
				$this->error['ddd'] = "O campo DDD é obrigatório";
		}
		if ((strlen(utf8_decode($this->request->post['numero'])) < 1)) {
				$this->error['numero'] = "O campo número é obrigatório";
		}
		
		if ((strlen(utf8_decode($this->request->post['postcode'])) < 1)) {
      		$this->error['postcode'] = "O campo CEP é obrigatório";
    	}
		
		// Fim módulo cpf ###############################################   

    	if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}
		
    	if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}
		
		// Customer Group
		$this->load->model('account/customer_group');
		
		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
			
		if ($customer_group) {	
			// Company ID
			if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
				$this->error['company_id'] = $this->language->get('error_company_id');
			}
			
			// Tax ID 
			if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
				$this->error['tax_id'] = $this->language->get('error_tax_id');
			}						
		}
		
    	if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
      		$this->error['address_1'] = "O campo Endereço é obrigatório e deve ter entre 3 e 128 caracteres";
    	}

    	if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
      		$this->error['city'] = "O campo Cidade é obrigatório e deve ter entre 2 e 128 caracteres";
    	}

		$this->load->model('localisation/country');
		
		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
		
		if ($country_info) {
			if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
				$this->error['postcode'] = $this->language->get('error_postcode');
			}
			
			// VAT Validation
			$this->load->helper('vat');
			
			if ($this->config->get('config_vat') && $this->request->post['tax_id'] && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
				$this->error['tax_id'] = $this->language->get('error_vat');
			}
		}

    	if ($this->request->post['country_id'] == '') {
      		$this->error['country'] = $this->language->get('error_country');
    	}
		
    	if ($this->request->post['zone_id'] == '') {
      		$this->error['zone'] = $this->language->get('error_zone');
    	}


	
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('error_password');
			}
			if ($this->request->post['confirm'] != $this->request->post['password']) {
				$this->error['confirm'] = $this->language->get('error_confirm');
			}
		

    	
		
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info && !isset($this->request->post['agree'])) {
      			$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}
		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}	
}
?>