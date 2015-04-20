<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1>Paybras Transparente - Cartões de Crédito</h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span>Salvar</span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span>Cancelar</span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="application/x-www-form-urlencoded" id="form">
      <table width="100%" class="form">
	  
	  <tr><td colspan='2'><h2>Configuração do Módulo</h2></td></tr>
	  
	        <tr>
	          <td>Modo de Operação</td>
	          <td><select name="paybrasc_modo" id="paybrasc_modo">
	            <option value="2"  <?php if ($paybrasc_modo==2) echo 'selected';  ?>>Produção</option>
	            <option value="1" <?php if ($paybrasc_modo==1) echo 'selected';  ?>>Sandbox</option>
	           
	           
              </select>                          
        </tr> 
	        <tr>
	          <td>Template</td>
	          <td><select name="paybrasc_template" id="paybrasc_template">
	            <option value="azul" <?php if($paybrasc_template=='azul') echo 'selected'; ?>>Cartão Azul</option>
	            <option value="1" <?php if($paybrasc_template==1) echo 'selected'; ?>>Simples</option>
	            <option value="verde" <?php if($paybrasc_template=='verde') echo 'selected'; ?>>Cartão Verde</option>
	            <option value="rosa" <?php if($paybrasc_template=='rosa') echo 'selected'; ?>>Cartão Rosa</option>
	            <option value="preto" <?php if($paybrasc_template=='preto') echo 'selected'; ?>>Cartão Preto</option>
	            <option value="roxo" <?php if($paybrasc_template=='roxo') echo 'selected'; ?>>Cartão Roxo</option>
                <option value="vermelho" <?php if($paybrasc_template=='vermelho') echo 'selected'; ?>>Cartão Vermelho</option>
                <option value="cinza" <?php if($paybrasc_template=='cinza') echo 'selected'; ?>>Cartão Cinza</option>
                <option value="laranja" <?php if($paybrasc_template=='laranja') echo 'selected'; ?>>Cartão Laranja</option>
              </select>                          
        </tr>
	        <tr>
	          <td>Mostrar logo do Paybras</td>
	          <td><label for="paybrasc_logo"><input name="paybrasc_logo" type="radio" id="radio" value="1" <?php if ($paybrasc_logo == 1) echo 'checked'; ?>>Sim </label>
              <label for="paybrasc_logo"><input type="radio" <?php if ($paybrasc_logo != 1) echo 'checked'; ?> name="paybrasc_logo" id="radio2" value="0"> Não    </label>           
        </tr>
	        <tr>
        <td width="23%"><span class="required">*</span> Nome do Modulo:</td>
        <td width="77%">
		<input type="text" name="paybrasc_nome" value="<?php echo $paybrasc_nome; ?>" size='80' />
		(nome que aparecerá no checkout e será visível ao comprador)</tr>
	  
	  	  <tr>
	  	    <td>Zona:</td>
	  	    <td><select name="paybrasc_geo_zone_id">
	  	      <option value="0">Todas as Zonas</option>
	  	      <?php foreach ($geo_zones as $geo_zone) { ?>
	  	      
	  	      <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
	  	      
	  	      <?php } ?>
  	        </select></td>
  	    </tr>
	  	  

      <tr>
        <td>Ordem:</td>
        <td><input type="text" name="paybrasc_sort_order" value="<?php echo $paybrasc_sort_order; ?>" size="1" /></td>
      </tr>
	  
	  <tr>
	    <td>Status:</td>
	    <td><select name="paybrasc_status">
	      <?php if ($paybrasc_status) { ?>
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
          <input name="paybrasc_email_conta" type="text" id="paybrasc_email_conta" value="<?php echo $paybrasc_email_conta; ?>" size='80' />
          <br /></td>
        
      </tr>
	  
    <tr>
        <td width="23%"><span class="required">*</span> Token</td>
        <td width="77%">
		<input name="paybrasc_token" type="text" id="paybrasc_token" value="<?php echo $paybrasc_token; ?>" size="70" />
          <br /> </td>

      </tr>
	        <tr>
	          <td colspan="2"><h2>Checkout</h2></td>
        </tr>
	        <tr>
	          <td colspan="2">Usar campo &quot;Empresa&quot; (companny) como campo nº do endereço? <label for="paybrasc_company"><input name="paybrasc_company" type="radio" id="radio" value="1" <?php if ($paybrasc_company == 1) echo 'checked'; ?>>Sim </label>
              <label for="paybrasc_company"><input type="radio" <?php if ($paybrasc_company != 1) echo 'checked'; ?> name="paybrasc_company" id="radio2" value="0"> Não    </label>           
        </td>
        </tr>
	        <tr>
	          <td colspan="2"><h2>Status dos Pedidos</h2></td>
        </tr>
	        <tr>
	          <td>Aguardando Pagamento</td>
	          <td><?php echo $this->getComboStatus('paybrasc_aguardando_pagamento', $paybrasc_aguardando_pagamento); ?> (primeiro status após conclusão do pedido)</td>
        </tr>
	        <tr>
	          <td>Pagamento Em Análise</td>
	          <td><?php echo $this->getComboStatus('paybrasc_pagamento_analise', $paybrasc_pagamento_analise); ?>            
        (pagamento em análise pelo Paybras)</tr>
	        <tr>
	          <td>Pagamento Confirmado</td>
	          <td><?php echo $this->getComboStatus('paybrasc_pagamento_confirmado', $paybrasc_pagamento_confirmado); ?>            
        (pagamento concluído com sucesso)</tr>
	        <tr>
	          <td>Pagamento Não autorizado</td>
	          <td><?php echo $this->getComboStatus('paybrasc_pagamento_nao_autorizado', $paybrasc_pagamento_nao_autorizado); ?>            
        (pagamento negado pela operadora ou pela análise de risco do Paybras)</tr>
	        <tr>
	          <td>Pagamento Cancelado</td>
	          <td><?php echo $this->getComboStatus('paybrasc_pagamento_cancelado', $paybrasc_pagamento_cancelado); ?>            
        (a transação foi cancelada sem ter sido paga)</tr>
	        <tr>
	          <td>Chargeback em Análise</td>
	          <td><?php echo $this->getComboStatus('paybrasc_disputa', $paybrasc_disputa); ?>            
        (seu pedido sofreu chargeback e está em análise pela Paybras)</tr>
	        <tr>
	          <td>Devolvido</td>
	          <td><?php echo $this->getComboStatus('paybrasc_pagamento_devolvido', $paybrasc_pagamento_devolvido); ?>            
        (o pagamento foi devolvido ao cliente)</tr>
	        <tr>
	          <td>Recusado</td>
	          <td><?php echo $this->getComboStatus('paybrasc_pagamento_recusado', $paybrasc_pagamento_recusado); ?> (a análise de risco da Paybras recusou este pagamento)                          
        </tr>
	        <tr>
	          <td>Erro</td>
	          <td><?php echo $this->getComboStatus('paybrasc_pagamento_erro', $paybrasc_pagamento_erro); ?> (ocorreu um erro e o pagamento não pôde ser concluído. Verifique o log de erros do Opencart)            
        </tr>
	        <tr>
	          <td colspan="2">Mensagens de Status</td>
        </tr>
	        <tr>
	          <td colspan="2">Estas são as mensagens que serão mostradas ao usuário quando ele concluir o pagamento via Cartão de Crédito na sua loja.            </td>
        </tr>
	        <tr>
	          <td>&nbsp;</td>
	          <td>            
        </tr>
	        <tr>
	          <td>Pagamento Confirmado</td>
	          <td><textarea name="paybrasc_mensagem_confirmado" cols="80" rows="5" id="paybrasc_mensagem_confirmado"><?php echo $paybrasc_mensagem_confirmado ?></textarea>                          
        </tr>
	        <tr>
	          <td>Pagamento em Análise</td>
	          <td><textarea name="paybrasc_mensagem_analise" cols="80" rows="5" id="paybrasc_mensagem_analise"><?php echo $paybrasc_mensagem_analise ?></textarea>                          
        </tr>
	        <tr>
	          <td>Pagameto não autorizado</td>
	          <td><textarea name="paybrasc_mensagem_nao_autorizado" cols="80" rows="5" id="paybrasc_mensagem_nao_autorizado"><?php echo $paybrasc_mensagem_nao_autorizado ?></textarea>                          
        </tr>
	        <tr>
	          <td>Erro no Pagamento</td>
	          <td><textarea name="paybrasc_mensagem_erro" cols="80" rows="5" id="paybrasc_mensagem_erro"><?php echo $paybrasc_mensagem_erro ?></textarea>                          
        </tr>
	  
	  
      </table>
    </form>
  </div>
</div>
</body>
</body>
