<?php

/**
 * @author Andresa - contato@andresa.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/

require_once('config.php');   
require_once(DIR_SYSTEM . 'startup.php');
require_once('catalog/model/checkout/order.php');

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);


$res	= $db->query("SELECT url_paybras FROM ".DB_PREFIX."order WHERE md5(id_transacao_paybras)='".$_GET['id']."' LIMIT 1");

header("Location: " .$res->row['url_paybras']);
exit;


?>
