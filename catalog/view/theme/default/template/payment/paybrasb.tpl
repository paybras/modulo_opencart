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
             


?><form action="index.php?route=payment/paybrasb/confirm" method="post" enctype="application/x-www-form-urlencoded" name="pagamento" id="pagamento" >
  <div id="coluna2" style="width:40%; display:block; position:relative; float:right">
    
  <?php if($this->config->get('paybrasb_logo')==1) { ?>
  <div id="logo_paybras" style="display:block; position:relative;  float:left; width:180px; height:70px;"><img src="image/paybras/logo_paybras.gif" width="172" height="67"  alt=""/></div>

<?php } ?>
  <p><strong>CPF do Pagador:<br>
    <input name="cartao_cpf" type="text" id="cartao_cpf" style="width:180px !important; padding:5px !important" autocomplete="off" onKeyUp="" size="30" maxlength="14"  tabindex="6" onKeyPress="mascarar('###.###.###-##', this)"/>
  </strong></p>
  <CENTER>
    <div id="div_botao_enviar">
      <p><BR>
        
        <input id="hash_cliente" type="hidden" name="hash_cliente">
        <input name="Botão" id="botao_enviar" type="button" onClick="pagar()" value="Finalizar e Gerar Boleto" class="button" />
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
    <div id="carregando" style="display:none">
      <center>
        <img src="image/paybras/carregando.gif" />
      </center>
    </div>
</CENTER>
</div>
</form>		
<script type="text/javascript">

$.getScript("catalog/view/javascript/paybrasb-validacao.js", function(){ });
 total_compra = '<?php echo number_format($pedido->row["total"], 2, ".", ""); ?>' ;
</script>