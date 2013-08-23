<?php
require_once('config.php');
   
#Inicialização
require_once(DIR_SYSTEM . 'startup.php');

#banco de dados 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Criação do campo de url do pagamento na tabela de pedidos
$db->query("ALTER TABLE `" .DB_PREFIX. "order` ADD `payment_url` VARCHAR(250) NOT NULL AFTER `payment_code`;");

echo utf8_decode("BANCO ATUALIZADO COM SUCESSO. PROSSIGA COM A INSTALAÇÃO");

?>