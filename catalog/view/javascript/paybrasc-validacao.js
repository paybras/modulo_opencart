/**
 * @author Andresa
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
 
 function is_int(value){
  if((parseInt(value)) && !isNaN(value)){
      return true;
  } else {
      return false;
  }
}

function mascarar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)

  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }

}

function validarDDD()
{
	if(document.getElementById('cartao_telefone_ddd').value.length!=2)
	{
		new Messi('Por favor, preencha corretamente o campo DDD. Ele deve conter 2 dígitos numéricos.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});

		return false;
	}
	
	if(!is_int(document.getElementById('cartao_telefone_ddd').value))
	{
			new Messi('Por favor, preencha corretamente o campo DDD. Ele deve conter 2 dígitos numéricos.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});


		return false;
	}
	
	return true;
}



function validarTelefone()
{	
	if((document.getElementById('cartao_telefone').value.length)<8)
	{
		new Messi('Por favor, preencha corretamente o campo Telefone. Ele deve ter 8 a 9 dígitos numéricos.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});

		return false;
	}
		
	if(!is_int(document.getElementById('cartao_telefone').value))
	{
		new Messi('Por favor, preencha corretamente o campo Telefone. Ele deve ter 8 a 9 dígitos numéricos.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
		return false;
	}

	
	return true;
}



function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function getNumeroCartao()
	{
		
		cartao1 = document.getElementById('cartao_numero1').value;
		
		
		return cartao1;
		
	}


function validarCartao()
{
    var isValid = false;
	
	
	var cardNumber = getNumeroCartao();
	var cardType = getBandeira(cardNumber);
	
    var ccCheckRegExp = /[^\d ]/;
	
    isValid = !ccCheckRegExp.test(cardNumber);

    if (isValid){
        var cardNumbersOnly = cardNumber.replace(/ /g,"");
        var cardNumberLength = cardNumbersOnly.length;
        var lengthIsValid = false;
        var prefixIsValid = false;
        var prefixRegExp;

		switch(cardType){
			
			case "MASTERCARD":
				lengthIsValid = (cardNumberLength == 16);
				
				if(!is_int(document.getElementById('cartao_codigo').value))
				{
					new Messi('O código de Segurança do cartão (CVV) deve ser numérico! Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
				
					return false;
					
				}

				if(document.getElementById('cartao_codigo').value.length!=3)
				{
					new Messi('O código de Segurança do cartão deve ter 3 dígitos. Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
					return false;
					
				}
				
				prefixRegExp = /^5[1-5]/;
			break;
			
			
			 case "DINERS":
				lengthIsValid = (cardNumberLength == 14);
				
				if(!is_int(document.getElementById('cartao_codigo').value))
				{
					new Messi('O código de Segurança do cartão deve ser numérico! Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					return false;
					
				}
				
				if(document.getElementById('cartao_codigo').value.length!=3)
				{
					new Messi('O código de Segurança do cartão deve ter 3 dígitos. Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
					return false;
					
				}
				
				prefixRegExp = /^3/;
			break;
			
			 case "HIPERCARD":
				lengthIsValid = (cardNumberLength == 13 || cardNumberLength == 16 |cardNumberLength == 19);
				
				if(!is_int(document.getElementById('cartao_codigo').value))
				{
					new Messi('O código de Segurança do cartão deve ser numérico! Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					return false;
					
				}
				
				if(document.getElementById('cartao_codigo').value.length!=3)
				{
					new Messi('O código de Segurança do cartão deve ter 3 dígitos. Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
					return false;
					
				}

			break;
			
			case "VISA":
				lengthIsValid = (cardNumberLength == 16 || cardNumberLength == 13);
				
				if(!is_int(document.getElementById('cartao_codigo').value))
				{
					new Messi('O código de Segurança do cartão deve ser numérico! Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					return false;
					
				}
				
				if(document.getElementById('cartao_codigo').value.length!=3)
				{
					new Messi('O código de Segurança do cartão deve ter 3 dígitos. Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
					return false;
					
				}
				prefixRegExp = /^4/;
			break;
			
			case "AMEX":
				lengthIsValid = (cardNumberLength == 15);
				if(document.getElementById('cartao_codigo').value.length!=4)
				{
					new Messi('O código de Segurança do cartão deve ter 4 dígitos. Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
					return false;
					
				}
				prefixRegExp = /^3/;
			break;
			
			case "ELO":
				lengthIsValid = (cardNumberLength == 16);
				
				if(document.getElementById('cartao_codigo').value.length!=3)
				{
					new Messi('O código de Segurança do cartão deve ter 3 dígitos. Por favor, verifique este campo e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
					return false;
					
				}
				prefixRegExp = /^6/;
			break;
			
			default:
				prefixRegExp = /^$/;
					new Messi('Por favor, informe corretamente todos os números do seu cartão de crédito. As bandeiras válidas são: Mastercard, Visa, American Express, ELO, Hipercard e Diners.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
				
			break;
		}
	
		isValid = lengthIsValid;
    }
	else
	{
					new Messi('O número de seu cartão parece ser inválido. Por favor, verifique todos os dígitos e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
		return false;
		
	}
	
    if (isValid)
	{
        var numberProduct;
        var numberProductDigitIndex;
        var checkSumTotal = 0;
        for (digitCounter = cardNumberLength - 1; digitCounter >= 0; digitCounter--){
            checkSumTotal += parseInt (cardNumbersOnly.charAt(digitCounter));
            digitCounter--;
            numberProduct = String((cardNumbersOnly.charAt(digitCounter) * 2));
            for (var productDigitCounter = 0; productDigitCounter < numberProduct.length; productDigitCounter++){
                checkSumTotal += parseInt(numberProduct.charAt(productDigitCounter));
            }
        }
        isValid = (checkSumTotal % 10 == 0);
    }
	if(isValid==false)
	{
					new Messi('O número de seu cartão parece ser inválido. Por favor, verifique todos os dígitos e tente novamente.', {modal: true, title: 'Atenção!', titleClass: 'anim warning', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
					
		return false;
		
	}
	return true;
}


function verificarCPF(cpf)
{
	c=cpf.substr(0,3) +""+cpf.substr(4,3)+""+cpf.substr(8,3)+""+cpf.substr(12,2);
		if (c.length != 11 || c == "00000000000" || c == "11111111111" || c == "22222222222" || c == "33333333333" || c == "44444444444" || c == "55555555555" || c == "66666666666" || c == "77777777777" || c == "88888888888" || c == "99999999999")
		{
			return false;
		}
		
		var i;
		s = c;
		var c = s.substr(0,9);
		var dv = s.substr(9,2);
		var d1 = 0;
		var v = false;

		for (i = 0; i < 9; i++)
		{
			d1 += c.charAt(i)*(10-i);
		}
		if (d1 == 0)
		{
			v = true;
			
			return false;
		}
		d1 = 11 - (d1 % 11);
		
		if (d1 > 9) d1 = 0;
		
		if (dv.charAt(0) != d1)
		{
			v = true;
			return false;
		}
	 
		d1 *= 2;
		for (i = 0; i < 9; i++)
		{
			d1 += c.charAt(i)*(11-i);
		}
		
		d1 = 11 - (d1 % 11);
		
		if (d1 > 9) d1 = 0;
		
		if (dv.charAt(1) != d1)
		{
			v = true;
			
			return false;
		}
		if (!v) 
		{
			return true;
		}
		
		return false;
	}
	
	
	
	function pagar()
	{
		document.getElementById('cartao_numero').value = getNumeroCartao();
		
		if(document.getElementById('cartao_titular').value=="")
		{
					new Messi('Por favor, informe o nome do titular do cartão antes de prosseguir. O nome deve ser escrito da mesma forma que está escrito no cartão..', {modal: true, title: 'Verifique as seguintes informações:', titleClass: 'info', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			return false;
		}
		
		if(!mudaBandeira())
		{
					new Messi('Por favor, verifique todos os números de seu cartão de crédito novamente. Os números informados não parecem ser válidos.', {modal: true, title: 'Verifique as seguintes informações:', titleClass: 'info', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			return false;
		}
		
		if(validarCartao()==false)
			return false;
					
		var cartao_mes = document.getElementById("cartao_mes");
		cartao_mes = cartao_mes.options[cartao_mes.selectedIndex].value;
		
		if(cartao_mes==-1)
		{
			
					new Messi('Por favor, informe o mês de validade do cartão.', {modal: true, title: 'Verifique as seguintes informações:', titleClass: 'info', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			return false;
			
		}
		
		var cartao_ano = document.getElementById("cartao_ano");
		cartao_ano = cartao_ano.options[cartao_ano.selectedIndex].value;
		
		if(cartao_ano==-1)
		{
			
					new Messi('Por favor, informe o ano da validade do cartão.', {modal: true, title: 'Verifique as seguintes informações:', titleClass: 'info', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			return false;
			
		}
		
		d = new Date();
		mes_atual=d.getMonth() + 1;
		ano_atual=d.getFullYear();
		if(cartao_ano == ano_atual && cartao_mes < mes_atual)
		{
			new Messi('Seu cartão de crédito está vencido! Verifique a data de validade do cartão, ou tente novamente com outro cartão de crédito.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error', buttons: [{id: 0, label: 'FECHAR', val: 'X'}]});
			return false;
			
		}

		
		if(document.getElementById('cartao_cpf').value=="")
		{
					new Messi('Por favor, informe o CPF do titular do cartão.', {modal: true, title: 'Verifique as seguintes informações:', titleClass: 'info', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			return false;
		}
		
		if(verificarCPF(document.getElementById('cartao_cpf').value)==false)
		{
					new Messi('Número de CPF inválido! Verifique todos os dígitos e tente novamente.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});

			return false;
		}
		
		if(!validarDDD())
			return false;
					
		if(!validarTelefone())
			return false;
					
		editarEnderecoFatura();
		
	}
	
	function editarEnderecoFatura()
	{
		
		
		new Messi('<p>Verifique abaixo o endereço da entrega do seu pedido. Estes dados são necessários para que a operadora do seu cartão efetue a aprovação da compra.</p><table width="500" border="0" cellpadding="3" cellspacing="2"> <tr> <td width="171">Nome completo do Titular</td> <td width="311"><input name="pagador_nome" type="text" id="pagador_nome" size="45" onKeyUp="mudaCampoEndereco(\'nome\')"></td> </tr> <tr> <td>Endereço</td> <td><input name="pagador_endereco" type="text" id="pagador_endereco" size="45" onKeyUp="mudaCampoEndereco(\'endereco\')"></td> </tr>    <tr> <td>Nº</td> <td><input name="pagador_numero" type="text" id="pagador_numero" size="20" onKeyUp="mudaCampoEndereco(\'numero\')"></td> </tr>      <tr> <td>Bairro</td> <td><input type="text" name="pagador_bairro" id="pagador_bairro" onKeyUp="mudaCampoEndereco(\'bairro\')"></td> </tr> <tr> <td>Cidade</td> <td><input type="text" name="pagador_cidade" id="pagador_cidade" onKeyUp="mudaCampoEndereco(\'cidade\')"></td> </tr> <tr> <td>Estado</td> <td><input name="pagador_estado" type="text" id="pagador_estado" size="5" maxlength="2" onKeyUp="mudaCampoEndereco(\'estado\')"></td> </tr> <tr> <td>CEP</td> <td><input name="pagador_cep" onChange="mascarar(\'#####-###\', this)" onKeyPress="mascarar(\'#####-###\', this)" type="text" id="pagador_cep" size="10" onKeyUp="mudaCampoEndereco(\'cep\')"></td> </tr></table>', { title: 'Endereço da Entrega', titleClass: 'success', modal: true, buttons: [{id: 0, label: 'Cancelar', val: '0'}, {id: 1, label: 'SALVAR E FINALIZAR', val: 'S'}], callback: function(val) { if(val=='S') { salvarEndereco(); } }});
		
		document.getElementById('pagador_nome').value=document.getElementById('fatura_nome').value;
		document.getElementById('pagador_endereco').value=document.getElementById('fatura_endereco').value;
		document.getElementById('pagador_numero').value=document.getElementById('fatura_numero').value;
		document.getElementById('pagador_bairro').value=document.getElementById('fatura_bairro').value;
		document.getElementById('pagador_cep').value=document.getElementById('fatura_cep').value;
		document.getElementById('pagador_estado').value=document.getElementById('fatura_estado').value;
		document.getElementById('pagador_cidade').value=document.getElementById('fatura_cidade').value;

	}
	
	function mudaCampoEndereco(campo)
	{
		
		document.getElementById('fatura_'+campo).value = document.getElementById('pagador_'+campo).value;
	}
	
	function salvarEndereco()
	{
		validacao=true;
		
		if(document.getElementById('fatura_cep').value.length!=9)
		{
			
			new Messi('O campo CEP é OBRIGATÓRIO. Ele deve conter 8 dígitos numéricos, sem traços ou pontuação.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error',  buttons: [{id: 0, label: 'OK', val: '0'}], callback: function(val) { editarEnderecoFatura() }});

			return false;
			
		}
		
		
		if(document.getElementById('fatura_endereco').value.length < 5)
		{
			
			new Messi('O campo ENDEREÇO é OBRIGATÓRIO. Ele deve conter ao menos 5 dígitos alfa-numéricos. Por favor, preencha este campo antes de prosseguir.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error',  buttons: [{id: 0, label: 'OK', val: '0'}], callback: function(val) { editarEnderecoFatura() }});

			return false;
			
		}
		
		if(document.getElementById('fatura_bairro').value.length < 4)
		{
			
			new Messi('O campo BAIRRO é OBRIGATÓRIO. Ele deve conter ao menos 4 dígitos alfa-numéricos. Por favor, preencha este campo antes de prosseguir.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error',  buttons: [{id: 0, label: 'OK', val: '0'}], callback: function(val) { editarEnderecoFatura() }});

			return false;
			
		}
		
		if(document.getElementById('fatura_nome').value.length< 4)
		{
			
			new Messi('O campo NOME é OBRIGATÓRIO. Ele deve conter o nome completo do titular do cartão, sem abreviações. Por favor, preencha-o a seguir.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error',  buttons: [{id: 0, label: 'OK', val: '0'}], callback: function(val) { editarEnderecoFatura() }});

			return false;
			
		}
		
		if(document.getElementById('fatura_cidade').value.length < 2)
		{
			
			new Messi('O campo CIDADE é OBRIGATÓRIO. Ele deve conter o nome da cidade do endereço da fatura do cartão. Por favor, preencha-o a seguir.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error',  buttons: [{id: 0, label: 'OK', val: '0'}], callback: function(val) { editarEnderecoFatura() }});

			return false;
			
		}
		
		if(document.getElementById('fatura_estado').value.length != 2)
		{
			
			new Messi('O campo ESTADO é OBRIGATÓRIO. Ele deve conter a sigla do estado do endereço da fatura do cartão. Por favor, preencha-o a seguir.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error',  buttons: [{id: 0, label: 'OK', val: '0'}], callback: function(val) { editarEnderecoFatura() }});

			return false;
			
		}
		
		if(!document.getElementById('fatura_numero').value)
		{
			
			new Messi('O campo Número é OBRIGATÓRIO. Caso seu endereço não tenha número, por favor, informe S/N neste campo.', {modal: true, title: 'O seguinte erro ocorreu:', titleClass: 'anim error',  buttons: [{id: 0, label: 'OK', val: '0'}], callback: function(val) { editarEnderecoFatura() }});

			return false;
			
		}
		
		
		
		document.getElementById('div_botao_enviar').style.display="none";
		document.getElementById('carregando').style.display="block";
		document.getElementById('pagamento').submit();
		
	}
	
	
	
	function getBandeira(cardNumber)
	{
	  var regexVisa = /^4[0-9]{12}(?:[0-9]{3})?/;
	  var regexMaster = /^5[1-5][0-9]{14}/;
	  var regexAmex = /^3[47][0-9]{13}/;
	  var regexDiners = /^3(?:0[0-5]|[6][0-9])[0-9]{11}/;
	  var regexElo = /^(636368|438935|504175|451416|636297)([0-9]{10})$/;
	  var regexElo2 = /^(5067|4576|4011)([0-9]{12})$/;
	  var regexJCB = /^(35)([0-9]{14})$/;
	  var regexAura = /^(50)([0-9]{14})$/;

	  var regexHipercard = /^(60\d{11})|(60\d{14})|(60\d{17})|(3841\d{11})|(3841\d{14})|(3841\d{17})$/;
	  
	  if(!cardNumber)
	  {
		  	document.getElementById("cartao_numero1").maxLength = 19;
			 return false;
	  }
	  
	  if(regexJCB.test(cardNumber)){
		  document.getElementById("cartao_numero1").maxLength = 16;
	   return 'JCB';
	  }
	
	  if(regexVisa.test(cardNumber)){
		  document.getElementById("cartao_numero1").maxLength = 16;
	   return 'VISA';
	  }
	  if(regexMaster.test(cardNumber)){
		  document.getElementById("cartao_numero1").maxLength = 16;
	   return 'MASTERCARD';
	  }
	  if(regexAmex.test(cardNumber))
	  {
		 
		 document.getElementById("cartao_numero1").maxLength = 15;
		 

	   return 'AMEX';
	  }
	  if(regexDiners.test(cardNumber)){

	if(cardNumber.length==14 | cardNumber.length==16)
{
		 document.getElementById("cartao_numero1").maxLength = 16;
	   return 'DINERS';
 }

	  }
	  if(regexHipercard.test(cardNumber))
	{
		
		
		if(cardNumber.length==13 | cardNumber.length==16 | cardNumber.length==19) 
		{
				
				  document.getElementById("cartao_numero1").maxLength = 19;
					
			   return 'HIPERCARD';
			  }
		}
		
	  if(regexElo.test(cardNumber)){
		  document.getElementById("cartao_numero1").maxLength = 16;
		
	   return 'ELO';
	  }


	if(regexElo2.test(cardNumber)){
		  document.getElementById("cartao_numero1").maxLength = 16;

	   return 'ELO';
	  }
	  
	   if(regexAura.test(cardNumber)){
		  document.getElementById("cartao_numero1").maxLength = 16;
	   return 'AURA';
	  }
	document.getElementById("cartao_numero1").maxLength = 19;
	  return false;
}

function mudaBandeira()
{
	
	bandeira = getBandeira(getNumeroCartao());
	
	if(bandeira)
	{
		document.getElementById('bandeira_cartao').value=bandeira;

		document.getElementById('imagem_bandeira').innerHTML='<img src="image/paybras/bandeiras/'+bandeira+'.png" />';
		return true;
	}
	return false;
	
}

function movetoNext(current, nextFieldID) 
{
	if (current.value.length >= current.maxLength)
	{
		document.getElementById(nextFieldID).focus();
	}
}