<?php echo $header; ?>
<script>
$(function(){
	$('input[name="address_1"]').parent().parent().hide();
	$('input[name="address_2"]').parent().parent().hide();
	$('input[name="numero"]').parent().parent().hide();
	$('input[name="complemento"]').parent().parent().hide();
	$('input[name="city"]').parent().parent().hide();
	$('select[name="country_id"]').parent().parent().hide();
	$('select[name="zone_id"]').parent().parent().hide();
	if ($('input[name="postcode"]').val().length != 0 ) {
		$('input[name="address_1"]').parent().parent().fadeIn('slow');
		$('input[name="address_2"]').parent().parent().fadeIn('slow');
		$('input[name="numero"]').parent().parent().fadeIn('slow');
		$('input[name="complemento"]').parent().parent().fadeIn('slow');
		$('input[name="city"]').parent().parent().fadeIn('slow');
		$('select[name="country_id"]').parent().parent().fadeIn('slow');
		$('select[name="zone_id"]').parent().parent().fadeIn('slow');
	}		
	$('input[name="postcode"]').blur(function(){
		
		if ($('input[name="postcode"]').val().length != 0 ) {
			$('input[name="address_1"]').parent().parent().fadeIn('slow');
			$('input[name="address_2"]').parent().parent().fadeIn('slow');
			$('input[name="numero"]').parent().parent().fadeIn('slow');
			$('input[name="complemento"]').parent().parent().fadeIn('slow');
			$('input[name="city"]').parent().parent().fadeIn('slow');
			$('select[name="country_id"]').parent().parent().fadeIn('slow');
			$('select[name="zone_id"]').parent().parent().fadeIn('slow');

			cep = $.trim($('input[name="postcode"]').val().replace('-', ''));
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+cep, function(){
				if(resultadoCEP["resultado"] == "1"){
					$('input[name="address_1"]').val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
					$('input[name="address_2"]').val(unescape(resultadoCEP["bairro"]));
					$('input[name="city"]').val(unescape(resultadoCEP["cidade"]));
					$('select[name=\'zone_id\']').load('index.php?route=account/cadastro/estado_autocompletar&estado='+unescape(resultadoCEP["uf"]));			
				}else{
					alert("Endereço do cep não encontrado. Digite o endereço manualmente!");
				}
			});
		}	
	});
});	

<?php if ($error_warning) { ?>
$.colorbox({
	overlayClose: true,
	opacity: 0.3,
	width: '720px',
	height: '110px',
	href: false,
	html: '<div class="warning"><?php echo $error_warning; ?></div>'
});	

<?php } ?>
</script>

<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1 class="heading"><?php echo $heading_title; ?></h1>
  <div class="heading_bottom"></div>
  <p><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" id="register" enctype="multipart/form-data">
    <h2><?php echo $text_your_details; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> Nome Completo</td>
          <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
            <?php if ($error_firstname) { ?>
            <span class="error"><?php echo $error_firstname; ?></span>
            <?php } ?></td>
        </tr>
        <input type="hidden" name="lastname" value=" " />
        <tr>
          <td><span class="required">*</span> <?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
			<td><span class="required">*</span> <?php echo $entry_telephone; ?></td>

				<td>
				<input type="text" name="ddd" size="2" maxlength="2" style="width:30px;min-width:30px;" value="<?php echo $ddd; ?>" /> 
				 <?php if ($error_ddd) { ?>
				<span class="error"><?php echo $error_ddd; ?></span>
				<?php } ?>
				<input type="text" name="telephone" maxlength="9"  style="width:130px;min-width:130px;" value="<?php echo $telephone; ?>" />
				</td>
			<tr>		
			<tr>
			  <td><?php if ($this->config->get('dados_nascimento')){?><span class="required">*</span><?php } ?> Data de Nascimento:</td>
			  <?php 
			  $dataparts = explode("-",$data_nascimento);
			  if (sizeof($dataparts)<>"3"){
				  $data = $data_nascimento;
			  }else{
				  $data = $dataparts[2]."/".$dataparts[1]."/".$dataparts[0]; 
			  }
			  ?>
			  <td><input type="text" name="data_nascimento" value="<?php echo $data; ?>">
			  <?php if ($error_data_nascimento) { ?>
			  <span class="error"><?php echo $error_data_nascimento; ?></span>
			  <?php } ?>
			  </td>
			</tr>
			<tr>
			  <td>Tipo:</td>
			  <td >
				  <?php if ($cpf<>"" ){?>
				  <input type="radio" name="pessoa" id="fisica" checked value="fisica">
				  Pessoa Física 
				  <input type="radio" id="juridica" name="pessoa" value="juridica">
				  Pessoa Juridica
				  <?php }else if ($cnpj<>"" ){?>
				  <input type="radio" name="pessoa" id="fisica" value="fisica">
				  Pessoa Física 
				  <input type="radio" id="juridica" name="pessoa" checked value="juridica">
				  Pessoa Juridica
				  <?php
				  }else{
				  ?>
				  <input type="radio" name="pessoa" id="fisica" checked value="fisica">
				  Pessoa Física 
				  <input type="radio" id="juridica" name="pessoa" value="juridica">
				  Pessoa Juridica
				  <?php
				  }
				  ?> 
			  </td>
			</tr>
			<tr class="pessoa_fisica">
			  <td><?php if ($this->config->get('dados_cpf')){?><span class="required">*</span><?php } ?> CPF:</td>
			  <td><input type="text" name="cpf"  id="cpf" value="<?php echo $cpf; ?>" > 
			  <?php if ($error_cpf) { ?>
			  <span class="error"><?php echo $error_cpf; ?></span>
			  <?php } ?></td>
			</tr>
			<tr class="pessoa_juridica">
			  <td><?php if ($this->config->get('dados_cnpj')){?><span class="required">*</span><?php } ?> CNPJ:</td>
			  <td><input type="text" name="cnpj" id="cnpj" value="<?php echo $cnpj; ?>">
			   <?php if ($error_cnpj) { ?>
			  <span class="error"><?php echo $error_cnpj; ?></span>
			  <?php } ?>
			  </td>
			</tr>
			<tr class="pessoa_juridica">
			  <td>Razão Social:</td>
			  <td><input type="text" name="razao_social" value="<?php echo $razao_social; ?>"> </td>
			</tr>
			<tr class="pessoa_juridica">
			  <td>Inscrição Estadual:</td>
			  <td><input type="text" name="inscricao_estadual" value="<?php echo $inscricao_estadual; ?>"> </td>
			</tr>	
      </table>
    </div>
    <h2><?php echo $text_your_address; ?></h2>
    <div class="content">
      <table class="form">
        
        <tr>
          <td><span class="required">*</span> Endereço:</td>
          <td><input type="text" name="address_1" value="<?php echo $address_1; ?>" />
            <?php if ($error_address_1) { ?>
            <span class="error"><?php echo $error_address_1; ?></span>
            <?php } ?></td>
        </tr>
		<tr>
		  <td><span class="required">*</span> Número: </td>
		  <td><input type="text" name="numero" value="<?php echo $numero; ?>" />
					<?php if (isset($error_numero)) { ?>
					<span class="error"><?php echo $error_numero; ?></span>
					<?php } ?>
		  </td>
		</tr>
		<tr>
		  <td>Complemento:</td>
		  <td>
			<input type="text" name="complemento" value="<?php echo $complemento; ?>" />
		  </td>
		</tr>
        <tr>
          <td><?php echo $entry_address_2; ?></td>
          <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_city; ?></td>
          <td><input type="text" name="city" value="<?php echo $city; ?>" />
            <?php if ($error_city) { ?>
            <span class="error"><?php echo $error_city; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span  class="required">*</span> <?php echo $entry_postcode; ?></td>
          <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" />
            <?php if ($error_postcode) { ?>
            <span class="error"><?php echo $error_postcode; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_country; ?></td>
          <td><select name="country_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_country) { ?>
            <span class="error"><?php echo $error_country; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
          <td><select name="zone_id">
            </select>
            <?php if ($error_zone) { ?>
            <span class="error"><?php echo $error_zone; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_your_password; ?></h2>
    <div class="content">
      <?php 
	  if ($this->config->get('config_guest_checkout')){	 
			//$selecionar = "checked";
			$selecionar = "";
	  ?>
	  <div> <input type="checkbox" name="visitante" id="visitante" value="1" <?php echo $selecionar; ?> > <label for="visitante">Ao marcar essa opção você estará comprando como visitante e não precisará colocar uma senha. A desvantagem disso é que não poderá acompanhar seu pedido pela loja.</label><br><br> </div>	
	  <script>
		$(document).ready(function(){
			 if ($("#visitante").is(":checked")){
					$("#cadastro").hide();
			   }else{
					$("#cadastro").show();
			   }
			$("#visitante").click(function(){   
			   if ($("#visitante").is(":checked")){
					$("#cadastro").hide();
			   }else{
					$("#cadastro").show();
			   }
			});   
		});
	  </script>
	  <?php } ?>
      <table class="form" id="cadastro">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_newsletter; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td><?php if ($newsletter) { ?>
            <input type="radio" name="newsletter" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="newsletter" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="newsletter" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="left">
		<a href="#" class="button" id="fdb"><span><?php echo $button_continue; ?></span></a>
		<?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
		<?php echo $text_agree; ?>
      </div>
    </div>
    <?php } else { ?>
    <div class="buttons">
      <div class="left">    
		<a href="#" class="button" id="fdb"><span><?php echo $button_continue; ?></span></a>
      </div>
    </div>
    <?php } ?>
  </form>
  <script type="text/javascript">
	$('#fdb').live('click', function() {
		$('#register').submit();
		return false;
	});
	</script>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('input[name=\'customer_group_id\']:checked').live('change', function() {
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
<?php } ?>	

	if (customer_group[this.value]) {
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('#company-id-display').show();
		} else {
			$('#company-id-display').hide();
		}
		
		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show();
		} else {
			$('#company-id-required').hide();
		}
		
		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show();
		} else {
			$('#tax-id-display').hide();
		}
		
		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show();
		} else {
			$('#tax-id-required').hide();
		}	
	}
});

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});
//--></script> 
<?php echo $footer; ?>