/**
 * @author Andresa - paybras@consultoriadaweb.com.br
 * @copyright Consultoria da Web
 * @site http://www.consultoriadaweb.com.br
 **/
 
 meuobjeto=false;

function is_int(value){
  if((parseInt(value)) && !isNaN(value)){
      return true;
  } else {
      return false;
  }
}


function verificarCPF(c)
{
	c = c.replace(/[\.-]/g, "");
	
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
		
		
		if(document.getElementById('cpf').value=="")
		{
			alert('O CPF informado parece ser inválido. Por favor, verifique atentamente todos os números antes de prosseguir.');
			return false;
		}
		
		
		
	   document.getElementById('div_botao_enviar').style.display="none";
	   document.getElementById('carregando').style.display="block";
	   document.getElementById('pagamento').submit();
	}
	

		 
function mascarar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)

  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }

}
