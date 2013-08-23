<?php 
class Paybras {
    private $ambiente = null;
    private $meio_pagamento = null;
    private $recebedor_email = null;
    private $recebedor_api_token = null;
    private $config_name = null;
    private $dados_cartao = null;
    private $dados_pedido = null;
    private $dados_produtos = null;
    private $cartao_carddata = null;
    private $has_shipping = null;
    private $tef_redirect = null;

    // Inicializa nova instância da classe PaybrasConsultaParcelas
    public function __construct(Array $dados = null) {
        if ($dados) {
            if (isset($dados['ambiente'])) {
                $this->ambiente = $dados['ambiente'];
            }
            if (isset($dados['meio_pagamento'])) {
                $this->meio_pagamento = $dados['meio_pagamento'];
            }
            if (isset($dados['recebedor_email'])) {
                $this->recebedor_email = $dados['recebedor_email'];
            }
            if (isset($dados['recebedor_api_token'])) {
                $this->recebedor_api_token = $dados['recebedor_api_token'];
            }
            if (isset($dados['config_name'])) {
                $this->config_name = $dados['config_name'];
            }
            if (isset($dados['dados_cartao'])) {
                $this->dados_cartao = $dados['dados_cartao'];
            }
            if (isset($dados['dados_pedido'])) {
                $this->dados_pedido = $dados['dados_pedido'];
            }
            if (isset($dados['dados_produtos'])) {
                $this->dados_produtos = $dados['dados_produtos'];
            }
            if (isset($dados['cartao_carddata'])) {
                $this->cartao_carddata = $dados['cartao_carddata'];
            }
            if (isset($dados['has_shipping'])) {
                $this->has_shipping = $dados['has_shipping'];
            }
            if (isset($dados['tef_redirect'])) {
                $this->tef_redirect = $dados['tef_redirect'];
            }
        } else {
            throw new Exception("Dados de criação de transação não setados.");
        }
    }

    public static function validaData($data, $obrigatorio){
        if(empty($data) && !$obrigatorio) {
            return true;
        }

        $data=explode("/",$data);
        if (($data['0']<=31 && $data['0']!=0)&&($data['1']<=12 && $data['1']!=0)&&($data['2']>=1900 && $data['2']<=date("Y")+20)) {
            return true;
        }
        return false;
    }

    public static function validaMes($mes) {
        if($mes >= 1 && $mes <= 12){
            return true;
        }
        return false;
    }

    public static function validaAno($ano) {
        if($ano >= 00 && $ano <= date("y")+20){
            return true;
        }
        return false;
    }

    public static function validaNumeroCartao($numero, $bandeira){
        if ($bandeira == 'mastercard'){
            if (strlen($numero) != 16 || !preg_match('5[1-5]', $numero))
                return false;
        } elseif ($bandeira == 'visa'){
            if ((strlen($numero) != 13 && strlen($numero) != 16) || substr($numero, 0, 1) != '4')
                return false;
        } elseif ($bandeira == 'amex'){
            if (strlen($numero) != 15 || !preg_match('3[47]', $numero))
                return false;
        } elseif ($bandeira == 'diners'){
            if (strlen($numero) != 16 || substr($numero, 0, 4) != '6011')
                return false;
        } elseif ($bandeira == 'elo'){
            if (strlen($numero) != 16 || (
                substr($numero, 0, 6) != '636368' && 
                substr($numero, 0, 6) != '504175' && 
                substr($numero, 0, 6) != '438935' && 
                substr($numero, 0, 6) != '451416' && 
                substr($numero, 0, 6) != '636297'))
                return false;
        }

        $dig = toCharArray($numero);
        $numdig = sizeof ($dig);
        $j = 0;
        
        for ($i=($numdig-2); $i>=0; $i-=2){
            $dbl[$j] = $dig[$i] * 2;
            $j++;
        }

        $dblsz = sizeof($dbl);
        $validate =0;
        
        for ($i=0;$i<$dblsz;$i++){
            $add = toCharArray($dbl[$i]);
            for ($j=0;$j<sizeof($add);$j++){
                $validate += $add[$j];
            }
            $add = '';
        }
        
        for ($i=($numdig-1); $i>=0; $i-=2){
            $validate += $dig[$i];
        }

        if (substr($validate, -1, 1) == '0') return true;
        else return false;

        function toCharArray($input){
            $len = strlen($input);
            for ($j=0;$j<$len;$j++){
                $char[$j] = substr($input, $j, 1);
            }
            return ($char);
        }
    }

    public static function validaCodSeguranca($codseg = null, $bandeira) {
        if($bandeira == 'amex'){
            if(strlen($codseg) == 4){
                return true;
            } else {
                return false;
            }
        } else {
            if(strlen($codseg) == 3){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function validaBandeira($bandeira) {
        $bandeiras = 'amex,mastercard,visa,diners,elo,simulacao';
        $bandeiras = explode(',', $bandeiras);

        if ($bandeira){
            if (in_array($bandeira, $bandeiras)){
                return true;
            }
        }
        return false;
    }

    public static function validaTelefone($tel = null, $obrigatorio) {
        // Verifica se um número foi informado
        if(empty($tel) && !$obrigatorio) {
            return true;
        }

        $formatado = self::formataTelefone($tel);
        if(strlen($formatado) >= 10 && strlen($formatado) <= 11){
            return true;
        }
        return false;
    }

    public static function validaCEP($cep = null, $obrigatorio) {
        if(empty($cep) && !$obrigatorio) {
            return true;
        }

        $formatado = self::apenasNumeros($cep);
        if(strlen($formatado) == 8){
            return true;
        }

        return false;


    }

    public static function validaEstado($estado = null, $obrigatorio) {
        if(empty($estado) && !$obrigatorio) {
            return true;
        }

        //Valida estados Brasileiros
        $estados = "AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO";
        $estados = explode(',', $estados);
        
        if ($estado){
            if (in_array($estado, $estados)){
                return true;
            }
        }
        return false;
    }

    function validaCNPJ($cnpj = null, $obrigatorio) {
    
        if(empty($cpf) && !$obrigatorio) {
            return true;
        }

        $cnpj = str_pad(preg_replace('/[^0-9]/', '', $cnpj), 11, '0', STR_PAD_LEFT);

        if (strlen($cnpj) <> 14)
            return false;

        $soma  = 0;
        $soma += ($cnpj[0] * 5);
        $soma += ($cnpj[1] * 4);
        $soma += ($cnpj[2] * 3);
        $soma += ($cnpj[3] * 2);
        $soma += ($cnpj[4] * 9);
        $soma += ($cnpj[5] * 8);
        $soma += ($cnpj[6] * 7);
        $soma += ($cnpj[7] * 6);
        $soma += ($cnpj[8] * 5);
        $soma += ($cnpj[9] * 4);
        $soma += ($cnpj[10] * 3);
        $soma += ($cnpj[11] * 2);

        $d1 = $soma % 11;
        $d1 = $d1 < 2 ? 0 : 11 - $d1;

        $soma = 0;
        $soma += ($cnpj[0] * 6);
        $soma += ($cnpj[1] * 5);
        $soma += ($cnpj[2] * 4);
        $soma += ($cnpj[3] * 3);
        $soma += ($cnpj[4] * 2);
        $soma += ($cnpj[5] * 9);
        $soma += ($cnpj[6] * 8);
        $soma += ($cnpj[7] * 7);
        $soma += ($cnpj[8] * 6);
        $soma += ($cnpj[9] * 5);
        $soma += ($cnpj[10] * 4);
        $soma += ($cnpj[11] * 3);
        $soma += ($cnpj[12] * 2);


        $d2 = $soma % 11;
        $d2 = $d2 < 2 ? 0 : 11 - $d2;

        if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
            return true;
        } else {
            return false;
        }
    }

    public static function validaCPF($cpf = null, $obrigatorio) {
 
        // Verifica se um número foi informado
        if(empty($cpf) && !$obrigatorio) {
            return true;
        }
     
        // Elimina possivel mascara
        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
            return false;
         // Calcula os digitos verificadores para verificar se o
         // CPF é válido
         } else {   
             
            for ($t = 9; $t < 11; $t++) {
                 
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
     
            return true;
        }
    }

    public static function validaEmail($email){
        if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $email)) {
            return true;
        }else{
            return false;
        }
    }

    public static function apenasNumeros($string){
        return preg_replace("/[^0-9\s]/", "", $string);
    }

    public static function formataTelefone($string){
        $telefone = preg_replace("/[^0-9\s]/", "", $string);
        if(substr($telefone, 0,1) == 0){
            return substr($telefone, 1);
        }

        return $telefone;
    }

    public static function validaMensagem($mensagem){
        $erro = array();
        $retorno['sucesso'] = 1;

        if($mensagem['pedido_meio_pagamento'] == 'cartao'){
            $mensagem['cartao_numero'] ? null : $erro[] = 'Número do cartão é campo obrigatório!';
            $mensagem['cartao_parcelas'] ? null : $erro[] = 'Parcela é campo obrigatório!';
            self::validaCodSeguranca($mensagem['cartao_codigo_de_seguranca'], $mensagem['cartao_bandeira']) ? null : $erro[] = 'Código de segurança inválido!';
            self::validaBandeira($mensagem['cartao_bandeira']) ? null : $erro[] = 'Bandeira é campo obrigatório!';
            $mensagem['cartao_portador_nome'] ? null : $erro[] = 'Nome do titular do cartão é campo obrigatório!';
            self::validaMes($mensagem['cartao_validade_mes']) ? null : $erro[] = 'Mês de validade do cartão é campo obrigatório!';
            self::validaAno($mensagem['cartao_validade_ano']) ? null : $erro[] = 'Ano de validade do cartão é campo obrigatório!';

            self::validaCPF($mensagem['cartao_portador_cpf'], true) ? null : $erro[] = 'CPF do portador do cartão é inválido!';
            
            if(isset($mensagem['cartao_portador_data_de_nascimento']))
                self::validaData($mensagem['cartao_portador_data_de_nascimento'], false) ? null : $erro[] = 'Data de nascimento do portador do cartão é inválida!';
            if(isset($mensagem['cartao_portador_telefone_ddd']) && isset($mensagem['cartao_portador_telefone']))
                self::validaTelefone($mensagem['cartao_portador_telefone_ddd'].$mensagem['cartao_portador_telefone'], false) ? null : $erro[] = 'Telefone do portador do cartão informado é inválido!';

            if(!empty($erro)){
                $retorno['sucesso'] = 0;
                $i=1;
                $msg_erro = 'Foram identificados erros nos dados de cartão:<br><br>';
                foreach ($erro as $value) {
                    $msg_erro .= $i. ") " .$value. "<br>";
                    $i++;
                }
                $msg_erro .= '<br>Favor preencher os dados corretamente para prosseguir!';
                $retorno['mensagem_erro'] = $msg_erro;
                return $retorno;
            }
        }

        $mensagem['pagador_nome'] ? null : $erro[] = 'Nome do cliente é campo obrigatório!';
        self::validaEmail($mensagem['pagador_email']) ? null : $erro[] = 'E-mail informado é inválido!';

        if(!self::validaCPF($mensagem['pagador_cpf'], true)) {
            if(!self::validaCNPJ($mensagem['pagador_cpf'], true)) {
                $erro[] = 'CPF / CNPJ do cliente é inválido!';
            }
        }        

        self::validaTelefone($mensagem['pagador_telefone_ddd'].$mensagem['pagador_telefone'], true) ? null : $erro[] = 'Telefone do cliente é inválido!';
        if(isset($mensagem['pagador_celular_ddd']) && isset($mensagem['pagador_celular']))
            self::validaTelefone($mensagem['pagador_celular_ddd'].$mensagem['pagador_celular'], false) ? null : $erro[] = 'Celular do cliente é inválido!';
        $mensagem['entrega_logradouro'] ? null : $erro[] = 'Endereço de Entrega é campo obrigatório!';
        $mensagem['entrega_bairro'] ? null : $erro[] = 'Bairro do endereço de entrega é campo obrigatório!';
        self::validaCEP($mensagem['entrega_cep'], true) ? null : $erro[] = 'CEP de entrega é inválido!';
        $mensagem['entrega_cidade'] ? null : $erro[] = 'Cidade do endereço de entrega é campo obrigatório!';
        self::validaEstado($mensagem['entrega_estado'], true) ? null : $erro[] = 'Estado de entrega é inválido. Formato: XX';
        $mensagem['entrega_pais'] ? null : $erro[] = 'País do endereço de entrega é campo obrigatório!';

        if(isset($mensagem['pagador_data_nascimento']))
            self::validaData($mensagem['pagador_data_nascimento'], false) ? null : $erro[] = 'Data de nascimento inválida!';

        if(isset($mensagem['pagador_cep']))
            self::validaCEP($mensagem['pagador_cep'], false) ? null : $erro[] = 'CEP informado é inválido!';

        if(isset($mensagem['pagador_estado']))
            self::validaEstado($mensagem['pagador_estado'], false) ? null : $erro[] = 'Estado informado é inválido. Formato: XX';

        if(!empty($erro)){
            $retorno['sucesso'] = 0;
            $i=1;
            $msg_erro = 'Foram encontrados erros no seu cadastro:<br><br>';
            foreach ($erro as $value) {
                $msg_erro .= $i. ") " .$value. "<br>";
                $i++;
            }
            $msg_erro .= '<br>Favor ajustar e em seguida proceguir com sua compra!';
            $retorno['mensagem_erro'] = $msg_erro;
        }

        return $retorno;
    }

    public static function curl($url,$data){
        $ch = curl_init($url);
        $data_string = json_encode($data);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        return curl_exec($ch);
    }

    public static function getMsgNaoAutorizacao($codigo){
        switch ($codigo) {
            case '1':
                $comment = 'Transação não foi autorizada pelo emissor. Entre em contato com o banco emissor do cartão.';
                break;
            case '2':
                $comment = 'Transação bloqueada pelo emissor. Entre em contato com banco emissor do cartão.';
                break;
            case '3':
                $comment = 'Transação não foi autorizada pelo emissor. Entre em contato com o banco emissor para verificar o saldo de seu cartão.';
                break;
            case '4':
                $comment = 'Transação não foi autorizada pois o cartão encontra-se bloqueado ou não é habilitado na função crédito. Entre em contato com o banco emissor para desbloqueá-lo.';
                break;
            case '6':
                $comment = 'Dados do cartão inválidos ou cartão encontra-se vencido. Tente novamente.';
                break;
            case '7':
                $comment = 'Transação falhou. Tente novamente.';
                break;
            case '8':
                $comment = 'Não foi possível processar a transação.';
                break;
            case '9':
                $comment = 'Transação não autorizada.';
                break;
            case '12':
                $comment = 'Transação falhou.';
                break;
            default:
                $comment = 'Transação não autorizada pelo emissor.';
                break;
        }

        return $comment;
    }

    public static function getStatusOpencart($codigo, $cod_operadora = null){
        if($cod_operadora != null){
            $retorno['status_comment'] = self::getMsgNaoAutorizacao($cod_operadora);
        }

        switch ($codigo) {
            case '1':
                $retorno['status_code'] = 1;
                if($cod_operadora == null)
                    $retorno['status_comment'] = 'Aguardando o pagamento ou processamento da transação';
                break;
            case '2':
                $retorno['status_code'] = 2;
                if($cod_operadora == null)
                    $retorno['status_comment'] = 'Transação encontra-se em análise interna';
                break;
            case '3':
                $retorno['status_code'] = 10;
                if($cod_operadora == null)
                    $retorno['status_comment'] = 'Transação não autorizada pelo emissor';
                break;
            case '4':
                $retorno['status_code'] = 15;
                if($cod_operadora == null)
                    $retorno['status_comment'] = 'Transação Aprovada pelo emissor';
                break;
            case '5':
                $retorno['status_code'] = 7;
                if($cod_operadora == null)
                    $retorno['status_comment'] = 'Transação recusada';
                break;
            case '6':
                $retorno['status_code'] = 12;
                if($cod_operadora == null)
                    $retorno['status_comment'] = 'Transação devolvida';
                break;
            default:
                return false;
                break;
        }

        return $retorno;
    }

    public function montaDadosEnvio(){
        //URL
        if ($this->ambiente == 'live') {
            $url = 'https://paybras.com/payment/api/criaTransacao';
        } elseif ($this->ambiente == 'sandbox') {
            $url = 'https://sandbox.paybras.com/payment/api/criaTransacao';     
        } elseif ($this->ambiente == 'local') {
            $url = 'http://localhost/paybras/payment/api/criaTransacao';
        }
        
        //Dados da loja
        $data['recebedor_email'] = $this->recebedor_email;
        $data['recebedor_api_token'] = $this->recebedor_api_token;

        //Dados do Cliente
        $data['pagador_nome'] = $this->dados_pedido['payment_firstname']. " " .$this->dados_pedido['payment_lastname'];
        $data['pagador_email'] = $this->dados_pedido['email'];
        $data['pagador_cpf'] = $this->dados_pedido['payment_tax_id'];
        $data['pagador_rg'] = $this->dados_pedido['payment_company_id'];
        $data['pagador_telefone_ddd'] = $this->dados_pedido['ddd'];
        $data['pagador_telefone'] = $this->dados_pedido['telephone'];

        //Dados de Endereço do cliente
        $data['pagador_logradouro'] = $this->dados_pedido['payment_address_1'];
        $data['pagador_numero'] = $this->dados_pedido['payment_numero'];
        $data['pagador_complemento'] = $this->dados_pedido['payment_complemento'];
        $data['pagador_bairro'] = $this->dados_pedido['payment_address_2'];
        $data['pagador_cep'] = $this->dados_pedido['payment_postcode'];
        $data['pagador_cidade'] = $this->dados_pedido['payment_city'];
        $data['pagador_estado'] = $this->dados_pedido['payment_zone_code'];
        $data['pagador_pais'] = $this->dados_pedido['payment_iso_code_3'];
        $data['pagador_ip'] = $_SERVER['REMOTE_ADDR'];

        //Dados de Entrega
        if($this->has_shipping) {
            $data['entrega_nome'] = $this->dados_pedido['shipping_firstname']. " " .$this->dados_pedido['shipping_lastname'];
            $data['entrega_logradouro'] = $this->dados_pedido['shipping_address_1'];
            $data['entrega_numero'] = $this->dados_pedido['shipping_numero'];
            $data['entrega_complemento'] = $this->dados_pedido['shipping_complemento'];
            $data['entrega_bairro'] = $this->dados_pedido['shipping_address_2'];
            $data['entrega_cep'] = $this->dados_pedido['shipping_postcode'];
            $data['entrega_cidade'] = $this->dados_pedido['shipping_city'];
            $data['entrega_estado'] = $this->dados_pedido['shipping_zone_code'];
            $data['entrega_pais'] = $this->dados_pedido['shipping_iso_code_3'];
        } else {
            $data['entrega_nome'] = $this->dados_pedido['payment_firstname']. " " .$this->dados_pedido['payment_lastname'];
            $data['entrega_logradouro'] = $this->dados_pedido['payment_address_1'];
            $data['entrega_numero'] = $this->dados_pedido['payment_numero'];
            $data['entrega_complemento'] = $this->dados_pedido['payment_complemento'];
            $data['entrega_bairro'] = $this->dados_pedido['payment_address_2'];
            $data['entrega_cep'] = $this->dados_pedido['payment_postcode'];
            $data['entrega_cidade'] = $this->dados_pedido['payment_city'];
            $data['entrega_estado'] = $this->dados_pedido['payment_zone_code'];
            $data['entrega_pais'] = $this->dados_pedido['payment_iso_code_3'];
        }

        //Dados do Pagamento
        $data['pedido_id'] = $this->dados_pedido['order_id'];
        $data['pedido_valor_total_original'] = $this->dados_pedido['total'];
        $data['pedido_descricao'] = $this->config_name;
        $data['pedido_meio_pagamento'] = $this->meio_pagamento;
        $data['pedido_moeda'] = $this->dados_pedido['currency_code'];
        $data['pedido_url_redirecionamento'] = $this->tef_redirect;
        
        //Dados de Produtos
        $i=0;
        foreach ($this->dados_produtos as $produto) { 
            $data['produtos'][$i]['produto_codigo'] = $produto['product_id'];
            $data['produtos'][$i]['produto_nome'] = $produto['name'];
            $data['produtos'][$i]['produto_qtd'] = $produto['quantity'];
            $data['produtos'][$i]['produto_valor'] = $produto['price'];
            $data['produtos'][$i]['produto_peso'] = $produto['weight'];
            $i++;
        }

        //Dados do Cartão
        if($this->meio_pagamento == 'cartao'){
            $data['cartao_numero'] = $this->dados_cartao['cc_number'];
            $data['cartao_parcelas'] = $this->dados_cartao['cartao_parcelas'];
            $data['cartao_codigo_de_seguranca'] = $this->dados_cartao['cc_cvv2'];
            $data['cartao_validade_mes'] = $this->dados_cartao['cc_expire_date_month'];
            $data['cartao_validade_ano'] = $this->dados_cartao['cc_expire_date_year'];
            $data['cartao_bandeira'] = $this->dados_cartao['cc_type'];
            $data['cartao_portador_nome'] = $this->dados_cartao['cc_owner'];
            $data['cartao_portador_cpf'] = $this->dados_cartao['cc_owner_cpf'];
            if($this->cartao_carddata == 'Y') {
                $data['cartao_portador_data_de_nascimento'] = $this->dados_cartao['cc_owner_nasc'];
                $data['cartao_portador_telefone_ddd'] = $this->dados_cartao['cc_owner_ddd'];
                $data['cartao_portador_telefone'] = $this->dados_cartao['cc_owner_phone'];
            }
        }

        $retorno['dados_envio'] = $data;
        $retorno['dados_conexao'] = $url;
        return $retorno;
    }
}
?>