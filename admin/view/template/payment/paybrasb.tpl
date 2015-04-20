<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1>Paybrás Transparente - Boleto Bancário</h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span>Salvar</span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span>Cancelar</span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="application/x-www-form-urlencoded" id="form">
      <table width="100%" class="form">
	  
	  <tr><td colspan='2'><h2>Configuração do Módulo</h2></td></tr>
	  
	        <tr>
	          <td>Modo de Operação</td>
	          <td><select name="paybrasb_modo" id="paybrasb_modo">
	            <option value="2"  <?php if ($paybrasb_modo==2) echo 'selected';  ?>>Produção</option>
	            <option value="1" <?php if ($paybrasb_modo==1) echo 'selected';  ?>>Sandbox</option>
	           
	           
              </select>                          
        </tr>
	        <tr>
	          <td>Mostrar logo da Paybrás</td>
	          <td><label for="paybrasb_logo"><input name="paybrasb_logo" type="radio" id="radio" value="1" <?php if ($paybrasb_logo == 1) echo 'checked'; ?>>Sim </label>
              <label for="paybrasb_logo"><input type="radio" <?php if ($paybrasb_logo != 1) echo 'checked'; ?> name="paybrasb_logo" id="radio2" value="0"> Não    </label>           
        </tr>
	        <tr>
	          <td>Desconto para Boleto </td>
	          <td><input name="paybrasb_desconto" type="text" id="paybrasb_desconto" value="<?php echo $paybrasb_desconto; ?>">
              (%)                                        
        </tr>
	        <tr>
        <td width="23%"><span class="required">*</span> Nome do Modulo:</td>
        <td width="77%">
		<input type="text" name="paybrasb_nome" value="<?php echo $paybrasb_nome; ?>" size='80' />
		(nome que aparecerá no checkout e será visível ao comprador)</tr>
	  
	  	  <tr>
	  	    <td>Zona:</td>
	  	    <td><select name="paybrasb_geo_zone_id">
	  	      <option value="0">Todas as Zonas</option>
	  	      <?php foreach ($geo_zones as $geo_zone) { ?>
	  	      
	  	      <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
	  	      
	  	      <?php } ?>
  	        </select></td>
  	    </tr>
	  	  

      <tr>
        <td>Ordem:</td>
        <td><input type="text" name="paybrasb_sort_order" value="<?php echo $paybrasb_sort_order; ?>" size="1" /></td>
      </tr>
	  
	  <tr>
	    <td>Status:</td>
	    <td><select name="paybrasb_status">
	      <?php if ($paybrasb_status) { ?>
	      <option value="1" selected="selected">Ativo</option>
	      <option value="0">Inativo</option>
	      <?php } else { ?>
	      <option value="1">Ativo</option>
	      <option value="0" selected="selected">Inativo</option>
	      <?php } ?>
	      </select> 
	    (defina como Ativo para que esta forma de pagamento seja oferecida aos compradores)</td></tr>
	  
	  <tr><td colspan='2'><h2>Dados da Conta Paybrás</h2></td></tr>
  
      <tr>
        <td width="23%"><span class="required">*</span> E-mail da conta:</td>
        <td width="77%">
          <input name="paybrasb_email_conta" type="text" id="paybrasb_email_conta" value="<?php echo $paybrasb_email_conta; ?>" size='80' />
          <br /></td>
        
      </tr>
	  
    <tr>
        <td width="23%"><span class="required">*</span> Token</td>
        <td width="77%">
		<input name="paybrasb_token" type="text" id="paybrasb_token" value="<?php echo $paybrasb_token; ?>" size="70" />
          <br /> </td>

      </tr>
	        <tr>
	          <td colspan="2"><h2>Status dos Pedidos</h2></td>
        </tr>
	        <tr>
	          <td>Aguardando Pagamento</td>
	          <td><?php echo $this->getComboStatus('paybrasb_aguardando_pagamento', $paybrasb_aguardando_pagamento); ?> (primeiro status após conclusão do pedido)</td>
        </tr>
	        <tr>
	          <td>Pagamento Confirmado</td>
	          <td><?php echo $this->getComboStatus('paybrasb_pagamento_confirmado', $paybrasb_pagamento_confirmado); ?>            
        (pagamento concluído com sucesso)</tr>
	        <tr>
	          <td>Pagamento Cancelado</td>
	          <td><?php echo $this->getComboStatus('paybrasb_pagamento_cancelado', $paybrasb_pagamento_cancelado); ?>            
        (a transação foi cancelada sem ter sido paga)</tr>
	        <tr>
	          <td>Erro</td>
	          <td><?php echo $this->getComboStatus('paybrasb_disputa', $paybrasb_disputa); ?>            
        (ocorreu um erro no pagamento,verifique o log do opencart para detalhes)</tr>
	        <tr>
	          <td>Devolvido</td>
	          <td><?php echo $this->getComboStatus('paybrasb_pagamento_devolvido', $paybrasb_devolvido); ?>            
        (o pagamento foi devolvido ao cliente)</tr>
	        <tr>
	          <td colspan="2"><h2>Mensagem de Status</h2></td>
        </tr>
	        <tr>
	          <td colspan="2">Essa é a mensagem informando ao cliente que o boleto dele aguarda pagamento</td>
        </tr>
	        <tr>
	          <td>&nbsp;</td>
	          <td>            
        </tr>
	        <tr>
	          <td>Aguardando Pagamento</td>
	          <td><textarea name="paybrasb_mensagem_aguardando" cols="80" rows="5" maxlength="" id="paybrasb_mensagem_confirmado"><?php echo $paybrasb_mensagem_aguardando; ?></textarea>                          
        </tr>
	  
	  
      </table>
    </form>
  </div>
</div>
</body>
</body>