<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1>Paybras Transparente - TEF</h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span>Salvar</span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span>Cancelar</span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="application/x-www-form-urlencoded" id="form">
      <table width="100%" class="form">
	  
	  <tr><td colspan='2'><h2>Configuração do Módulo</h2></td></tr>
	  
	        <tr>
	          <td>Modo de Operação</td>
	          <td><select name="paybrast_modo" id="paybrast_modo">
	            <option value="2"  <?php if ($paybrast_modo==2) echo 'selected';  ?>>Produção</option>
	            <option value="1" <?php if ($paybrast_modo==1) echo 'selected';  ?>>Sandbox</option>
	           
	           
              </select>                          
        </tr>
	        <tr>
	          <td>Mostrar logo do Paybras</td>
	          <td><label for="paybrast_logo"><input name="paybrast_logo" type="radio" id="radio" value="1" <?php if ($paybrast_logo == 1) echo 'checked'; ?>>Sim </label>
              <label for="paybrast_logo"><input type="radio" <?php if ($paybrast_logo != 1) echo 'checked'; ?> name="paybrast_logo" id="radio2" value="0"> Não    </label>           
        </tr>
	        <tr>
	          <td width="23%"><span class="required">*</span> Nome do Modulo:</td>
	          <td width="77%">
	            <input type="text" name="paybrast_nome" value="<?php echo $paybrast_nome; ?>" size='80' />
        (nome que aparecerá no checkout e será visível ao comprador)</tr>
	  
	  	  <tr>
	  	    <td>Zona:</td>
	  	    <td><select name="paybrast_geo_zone_id">
	  	      <option value="0">Todas as Zonas</option>
	  	      <?php foreach ($geo_zones as $geo_zone) { ?>
	  	      
	  	      <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
	  	      
	  	      <?php } ?>
  	        </select></td>
  	    </tr>
	  	  

      <tr>
        <td>Ordem:</td>
        <td><input type="text" name="paybrast_sort_order" value="<?php echo $paybrast_sort_order; ?>" size="1" /></td>
      </tr>
	  
	  <tr>
	    <td>Status:</td>
	    <td><select name="paybrast_status">
	      <?php if ($paybrast_status) { ?>
	      <option value="1" selected="selected">Ativo</option>
	      <option value="0">Inativo</option>
	      <?php } else { ?>
	      <option value="1">Ativo</option>
	      <option value="0" selected="selected">Inativo</option>
	      <?php } ?>
	      </select>	       (defina como Ativo para que esta forma de pagamento seja oferecida aos compradores)</td></tr>
	  
	  <tr><td colspan='2'><h2>Dados da Conta Paybras</h2></td></tr>
  
      <tr>
        <td width="23%"><span class="required">*</span> E-mail da conta:</td>
        <td width="77%">
          <input name="paybrast_email_conta" type="text" id="paybrast_email_conta" value="<?php echo $paybrast_email_conta; ?>" size='80' />
          <br /></td>
        
      </tr>
	  
    <tr>
        <td width="23%"><span class="required">*</span> TOKEN </td>
        <td width="77%">
		<input name="paybrast_token" type="text" id="paybrast_token" value="<?php echo $paybrast_token; ?>" size="70" />
          <br /> </td>

      </tr>
	        <tr>
	          <td colspan="2"><h2>Status dos Pedidos</h2></td>
        </tr>
	        <tr>
	          <td>Aguardando Pagamento</td>
	          <td><?php echo $this->getComboStatus('paybrast_aguardando_pagamento', $paybrast_aguardando_pagamento); ?> (primeiro status após conclusão do pedido)</td>
        </tr>
	        <tr>
	          <td>Pagamento Confirmado</td>
	          <td><?php echo $this->getComboStatus('paybrast_pagamento_confirmado', $paybrast_pagamento_confirmado); ?>            
        (pagamento concluído com sucesso)</tr>
	        <tr>
	          <td>Pagamento Cancelado</td>
	          <td><?php echo $this->getComboStatus('paybrast_pagamento_cancelado', $paybrast_pagamento_cancelado); ?>            
        (a transação foi cancelada sem ter sido paga)</tr>
	        <tr>
	          <td>Disputa Paybras</td>
	          <td><?php echo $this->getComboStatus('paybrast_disputa', $paybrast_disputa); ?>            
        (o cliente abriu disputa no Paybras)</tr>
	        <tr>
	          <td>Devolvido</td>
	          <td><?php echo $this->getComboStatus('paybrast_pagamento_devolvido', $paybrast_devolvido); ?>            
        (o pagamento foi devolvido ao cliente)</tr>
	        <tr>
	          <td>Erro</td>
	          <td><?php echo $this->getComboStatus('paybrast_pagamento_erro', $paybrast_erro); ?> (ocorreu um erro e o pagamento não pôde ser concluído. Verifique o log de erros do Opencart)            
        </tr>
	  
	  
      </table>
    </form>
  </div>
</div>
</body>
</body>