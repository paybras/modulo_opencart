<?php
/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
class ControllerInformationPaybrasT extends Controller 
{
   private $error = array();
      
     public function index() {
      $this->language->load('information/paybrast'); 
		
         $this->data['breadcrumbs'] = array();

         $this->data['breadcrumbs'][] = array(
           'text'      => $this->language->get('text_home'),
         'href'      => $this->url->link('common/home'),           
           'separator' => false
         );

		$tipo=$_REQUEST['tipo'];

	   if($tipo==4)
	   {
			
		   $this->data['heading_title'] = "Um erro ocorreu"; 
		   $this->data['conteudo_centro'] = 'Não foi possível processar seu pedido. Por favor, tente novamente, ou selecione uma nova forma de pagamento';
		   
	   }
	   else if($tipo==9)
	   {
		   
			
		   $this->data['heading_title'] = "Pedido concluído com sucesso!"; 
		   $this->data['conteudo_centro'] = 'Obrigado por concluir seu pedido. Em breve ele começará a ser processado.';
		   
		   
	   }
	   else exit;

      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/paybrast.tpl')) 
	  { 
         $this->template = $this->config->get('config_template') . '/template/information/paybrast.tpl';
      } else {
         $this->template = 'default/template/information/paybrast.tpl'; 
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