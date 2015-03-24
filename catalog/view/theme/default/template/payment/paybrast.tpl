<?php

    #Seleciona dados do pedido

        $registry = new Registry();
		
		// Loader
		$loader = new Loader($registry);
		$registry->set('load', $loader);
		 
		// Config
		$config = new Config();
		$registry->set('config', $config);

		$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		$registry->set('db', $db);
		$pedido = $db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '".$this->session->data['order_id']."'");
        $estado = $db->query("SELECT code FROM `" . DB_PREFIX . "zone` WHERE zone_id = ".$pedido->row['payment_zone_id']);
        
        
        $valor=number_format($pedido->row['total'], 2, '.', '');
        
      
?><form action="index.php?route=payment/paybrast/confirm" method="post" enctype="application/x-www-form-urlencoded" name="pagamento" id="pagamento" >

 <CENTER>
 <?php if($this->config->get('paybrast_logo')==1) { ?>
  <div id="logo_paybras" style="display:block; position:relative;  float:left; width:180px; height:70px;"><img src="image/paybras/logo.png" width="172" height="67"  alt=""/></div>

<?php } ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="28%" height="103" align="left" valign="top">CPF do Pagador<br>            <input name="cpf" type="text" id="cpf" size="33" maxlength="14" onKeyPress="mascarar('###.###.###-##', this)">
          <br>
          <br></td>
          <td>
            <label>
              <input name="banco" type="radio" value="tef_itau" checked />
              <img src="image/paybras/itau.png">
            </label>
            
            <label>
              <input type="radio" name="banco" value="tef_bradesco"/>
              <img src="image/paybras/bradesco.png">
            </label>
            
            <label>
              <input id="fb3" type="radio" name="banco" value="tef_bb" />
              <img src="image/paybras/bb.png">
          </label></td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="center"><div id="div_botao_enviar">
      <p><BR>
        
        
        <input name="Botão" id="botao_enviar" type="button" onClick="pagar()" value="Finalizar e Gerar Boleto" class="button" />
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
    <div id="carregando" style="display:none">
      <center>
        <img src="image/paybras/carregando.gif" />
      </center>
    </div></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </CENTER>

</form>		
<style>
label > input{ /* HIDE RADIO */
  display:none;
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
}
label > input:checked + img{ /* (CHECKED) IMAGE STYLES */
  border:5px solid #666;
}

label > input + img:hover{
  cursor:pointer;
  border:5px solid #666;
  margin:-5px;
}

</style>
<script type="text/javascript">

$( document ).ready(function() {

});

$.getScript("catalog/view/javascript/paybrast-validacao.js", function(){ });
</script>