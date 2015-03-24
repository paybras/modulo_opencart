<?php
/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
class ControllerInformationPaybrasB extends Controller 
{
   private $error = array();
      
     public function index() {
      $this->language->load('information/paybrasb'); 
		
         $this->data['breadcrumbs'] = array();

         $this->data['breadcrumbs'][] = array(
           'text'      => $this->language->get('text_home'),
         'href'      => $this->url->link('common/home'),           
           'separator' => false
         );

		$tipo=$_REQUEST['tipo'];
		
		#seleciona linha digitável do boleto
		$pedido = $this->db->query("SELECT url_paybras FROM `" . DB_PREFIX . "order` WHERE md5(id_transacao_paybras) = '".$this->request->get['transacao']."'");
		
		
		
		$linha_digitavel=(explode('###', $pedido->row['url_paybras']));
		$linha_digitavel=end($linha_digitavel);
		if(!$pedido->row['shipping_zone_id']) $pedido->row['shipping_zone_id']=$pedido->row['payment_zone_id'];

	   if($tipo!=1)
			exit;
			
			$teste='Seu pedido foi enviado com sucesso. Contudo, é necessário que seja efetuado o pagamento do boleto bancário para que ele possa ser processado. Para imprimir seu boleto, clique no botão abaixo:<BR><BR><a href="'.$this->config->get('config_url').'pagar.php?id='.$this->request->get['transacao'].'" target="_blank"><img src="image/paybras/botao_imprimir_boleto.png" align="left" /></a><BR><BR><BR><BR><BR><BR><BR><BR><BR>Codigo de barras: '.$linha_digitavel;
			
		   $this->data['heading_title'] = "Obrigado por seu pedido!"; 
		   $this->data['conteudo_centro'] = $teste;
			

      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/paybrasb.tpl')) 
	  { 
         $this->template = $this->config->get('config_template') . '/template/information/paybrasb.tpl';
      } else {
         $this->template = 'default/template/information/paybrasb.tpl'; 
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
}
?>