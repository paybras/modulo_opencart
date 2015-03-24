<?php

function parcelar($valorTotal, $taxa, $nParcelas)
	{
		$taxa = $taxa/100;
		$cadaParcela = ($valorTotal*$taxa)/(1-(1/pow(1+$taxa, $nParcelas)));
		return round($cadaParcela, 2);
	}


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
        
        $anos_validade_cartao="";

		for($i=date("Y"); $i< (date("Y") + 10); $i++)
        {
            $anos_validade_cartao .= '<option value="'.($i-2000).'">'.$i.'</option>';
        }        
        
        $valor=number_format($pedido->row['total'], 2, '.', '');
		$maximo_parcelas=12;
		$juros=2.49;
		$semjuros=1;
		
		
		if($valor>5) 
		{
			$splitss = (int) ($valor/5);
			
			if($splitss<=$maximo_parcelas)
			{
				$total_parcelas = $splitss;
			}
			else
			{
				$total_parcelas = $maximo_parcelas;
			}
		}
		else
		{
			$total_parcelas = 1;
		}
		
		#calcula o parcelamento de acordo com o valor do pedido. A parcela mínima do Paybrás é de 5 reais
	
		$parcelamento='<select name="parcelas" id="parcelas">';
		
		
		for($j=1; $j<=$total_parcelas;$j++) 
		{
		
			if($semjuros>=$j) 
			{
			
				$parcelas = $valor/$j;
				$parcelas = number_format($parcelas, 2, '.', '');
				
				$parcelamento .= '<option value="'.$j.'">'.$j.'x de R$'.number_format($parcelas, 2,',', '.').' Sem Juros</option>';
				
				
				
			}
			else
			{
			
				$parcelas = parcelar($valor, $juros, $j);
				$parcelas = number_format($parcelas, 2, '.', '');
				
				$parcelamento .= '<option value="'.$j.'">'.$j.'x de R$'.number_format($parcelas, 2,',', '.').' Com Juros de '.number_format($juros, 2, ',', ',').'% A.M.</option>
				
				';
				
				
			}
		
		}
		
		$parcelamento .='</select>';
        
        $fatura_cep=preg_replace("/[^0-9,.]/", "", $pedido->row['payment_postcode']);
        $fatura_cep=substr($fatura_cep,0,5). '-'. substr($fatura_cep,5,3);


?>


		


<form action="index.php?route=payment/paybrasc/confirm" method="post" enctype="application/x-www-form-urlencoded" name="pagamento" id="pagamento" >

  <div id="coluna1" style="width:50%; display:block; position:relative; float:left">
<div id="cartao_de_credito" style=" width:519px; height:389px; background-image:url(image/paybras/cartao-<?php echo $this->config->get('paybrasc_template') ?>.png); display:block; position:relative; margin-bottom:60px">

<div id="imagem_bandeira" style="display:block; position:relative; float:left; width:519px; height:30px; padding-left:330px; margin-top:50px"> </div>
  <div id="cart_numero1" style="margin-left:20px;margin-top:15px;width: 360px; display:block; height:50px; float:left; position:relative">
    <input name="cartao_numero1" type="text" class="meucartao" id="cartao_numero1" style="border:none; width:360px; padding-left:10px; height:38px; font-size:18px; color:#333; font-weight:bold" tabindex="1" autocomplete="off" onKeyUp="mudaBandeira();" maxlength="4">
  </div>
  <div id="titular" style="margin-left:19px;margin-top:20px;width: 500px; display:block; height:50px; float:left; position:relative">
    <input name="cartao_titular" type="text" class="meucartao"  id="cartao_titular" style="border:none; width:222px; padding-left:10px; height:38px; font-size:18px; color:#333; font-weight:bold" tabindex="5" autocomplete="off">
    <select name="cartao_mes" id="cartao_mes" style="border:none; width:53px; padding-left:0px; height:38px; font-size:18px; color:#333; font-weight:bold; margin-left:7PX">
      <option value="-1" selected>--</option>
      <option value="01">01</option>
      <option value="02">02</option>
      <option value="03">03</option>
      <option value="04" >04</option>
      <option value="05">05</option>
      <option value="06">06</option>
      <option value="07">07</option>
      <option value="08">08</option>
      <option value="09">09</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
    </select>
    <select name="cartao_ano" id="cartao_ano" style="border:none; width:73px;  height:38px; font-size:18px; color:#333; font-weight:bold; height:">
      <option value="-1">--</option>
			  
			 <?php echo $anos_validade_cartao ?>
			
              
                
                  
    </select>
</div>
  <div id="titular" style="margin-left:19px;margin-top:35px;width: 180px; display:block; height:50px; float:left; position:relative; padding-left:375px">
    <input name="cartao_codigo"  type="text" class="meucartao" id="cartao_codigo" style="border:none; width:98px; padding-left:10px; height:50px; font-size:18px; color:#333; font-weight:bold" tabindex="5" autocomplete="off" maxlength="4">
  </div>
  <div id="cart_nome"></div>
  <div id="cart_cvv"></div>
</div>

</div>


<div id="coluna2" style="width:40%; display:block; position:relative; float:right">

<?php if($this->config->get('paybrasc_logo')==1) { ?>
<div id="logo_paybras" style="display:block; position:absolute; left:210px; float:right; width:180px; height:70px;"><img src="image/paybras/logo_paybras.gif" width="172" height="67"  alt=""/></div>

<?php } ?>
  <p><strong>CPF do Titular <br>
    <input name="cartao_cpf" type="text" id="cartao_cpf" style="width:180px !important; padding:5px !important" autocomplete="off" onKeyUp=";movetoNext(this, 'data_nascimento')" size="30" maxlength="14"  tabindex="6" onKeyPress="mascarar('###.###.###-##', this)"/>
  </strong></p>
  <p><strong>Telefone</strong><br>
    (
    <input name="cartao_telefone_ddd" type="text" id="cartao_telefone_ddd" style="width:40px !important; padding:5px !important" tabindex="8" autocomplete="off" onKeyUp="movetoNext(this, 'cartao_telefone')" size="30" maxlength="2" />
    )
    <input name="cartao_telefone" type="text" id="cartao_telefone" style="width:80px !important; padding:5px !important" tabindex="9" autocomplete="off" size="40" maxlength="9" />
    <input type="hidden" name="bandeira_cartao" id="bandeira_cartao">
    <input id="hash_cliente" type="hidden" name="hash_cliente">
    <input id="cartao_token" type="hidden" name="cartao_token">
 
</p>
  <div id="combo_parcelas" ><BR><?php echo $parcelamento; ?></div>
  <CENTER>
    <div id="div_botao_enviar">
      <p><BR>
        
        <input name="Botão" id="botao_enviar" type="button" onClick="pagar()" value="Concluir Pagamento" class="button" />
      </p>
      <p>
        <input name="fatura_nome" type="hidden" id="fatura_nome" value="<?php echo $pedido->row['payment_firstname'].' '.$pedido->row['payment_lastname']; ?>">
        <input name="fatura_numero" type="hidden" id="fatura_numero" value="">
        <input name="fatura_endereco" type="hidden" id="fatura_endereco" value="<?php echo $pedido->row['payment_address_1'] ?>">
        <input name="fatura_bairro" type="hidden" id="fatura_bairro" value="<?php echo $pedido->row['payment_address_2'] ?>">
        <input name="fatura_cidade" type="hidden" id="fatura_cidade" value="<?php echo $pedido->row['payment_city'] ?>">
        <input name="fatura_estado" type="hidden" id="fatura_estado" value="<?php echo $estado->row['code'] ?>">
        <input name="fatura_cep" type="hidden" id="fatura_cep" value="<?php echo $fatura_cep ?>" >
        <input name="fatura_numero" type="hidden" id="fatura_numero" value="">
        <input type="hidden" name="cartao_numero" id="cartao_numero" value="">
      </p>
      <p>&nbsp;</p>
    </div>
    <div id="carregando">
      <center>
        <img src="image/paybras/carregando.gif" />
      </center>
    </div>
  </CENTER>
</div>

</form>		
   
        <div id="popup" class="popup">
<P>&nbsp;</P>
  
  </div>

<?php


?>
<link href="catalog/view/theme/default/stylesheet/messi.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/paybrasc.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

$( document ).ready(function() {


});

$.getScript("catalog/view/javascript/paybrasc-validacao.js", function(){ });
$.getScript("catalog/view/javascript/messi.min.js", function(){ });

</script>