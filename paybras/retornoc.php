<?php

/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/

require_once('../config.php');   
require_once(DIR_SYSTEM . 'startup.php');
require_once('../catalog/model/checkout/order.php');


$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

function get_config($config)
{
	global $db;
	$config = $db->query("SELECT `value` FROM `" . DB_PREFIX . "setting`  where `key`='".$config."'");
    return $config->row['value'];
}

$retorno= json_decode($_POST['data']);

if(get_config('paybrasc_token')==$retorno->recebedor_api_token)
{
	$config= new Config();
    $registry = new Registry();
    $loader = new Loader($registry);
    $registry->set('load', $loader);
    $registry->set('config', $config);
    $registry->set('db', $db);
    $registry->set('model_checkout_order', new ModelCheckoutOrder($registry));
    
    $orderModel = $registry->get('model_checkout_order');

	    $res	= $db->query("SELECT `order_id` FROM `".DB_PREFIX."order` WHERE `id_transacao_paybras`='".$retorno->transacao_id."' LIMIT 1");
		
		
		$id_transacao=$res->row['order_id'];

		switch($retorno->status_codigo)
		{
			case 1:
			case 2:
			$novoStatus=get_config('paybrasc_pagamento_analise');
			break;
			
			case 4:
			$novoStatus=get_config('paybrasc_pagamento_confirmado');
			break;
			
			case 3:
			
			#não autorizado
			$novoStatus=get_config('paybrasc_pagamento_nao_autorizado');
			
			break;
			case 9:#chargeback em analise
			$novoStatus=get_config('paybrasc_disputa');
			break;
			
			case 6:
			$novoStatus=get_config('paybrasc_pagamento_devolvido');
			break;
			
			case 5:
			$novoStatus=get_config('paybrasc_pagamento_recusado');
			break;


		}
		
		 if ($novoStatus) 
		 {
			$resultado = $orderModel->update($id_transacao, $novoStatus,  true);
			
		$ret['retorno'] = 'ok';
		echo json_encode($ret);	
		}
		#manda email informando
		
		/*$message="Status do ";
		
		$subject="";
		
		
		$mail = new Mail();
			$mail->protocol = get_config('config_mail_protocol');
			$mail->parameter = get_config('config_mail_parameter');
			$mail->hostname = get_config('config_smtp_host');
			$mail->username = get_config('config_smtp_username');
			$mail->password = get_config('config_smtp_password');
			$mail->port = get_config('config_smtp_port');
			$mail->timeout = get_config('config_smtp_timeout');				
			$mail->setTo($this->request->post['email']);
			$mail->setFrom(get_config('config_email'));
			$mail->setSender(get_config('config_name'));
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();*/
}

?>
