Módulo Opencart
===============

Instruções
----------

É altamente recomendável a realização de backup de todo o seu site antes da instalação deste módulo. O Paybras não se responsabiliza por quaisquer danos decorrentes da má utilização ou instalação deste módulo.

Requerimentos
-------------

* Opencart versão 1.5.6 e 1.5.5 (não foram realizados testes em outras versões);
* PHP 5.2.0 ou superior
* VQMod 2.4.1 Opencart
* Tradução do Opencart para o Português

Instalação
----------

* Instalação do VQMOD (http://code.google.com/p/vqmod/wiki/Install_OpenCart);
* Descompactar os arquivos referentes a este módulo e inserir os arquivos dentro da pasta raiz do seu opencart;
* Executar o update da base de dados através da url http://seu-site.com.br/paybras_db_install.php
* Configuração dos módulos paybras:
  * Entrar na interface administrativa do seu opencart;
  * Acessar o Menu extensões -> formas de pagamento;
  * Acessar cada um dos módulos referentes ao Paybras (Paybras - Boleto Bancário, Paybras - Cartão de Crédito e Paybras - TEF);
  * Inserir os dados requeridos para cada um dos módulos

Customização
------------

É possível efetuar modificações visuais através da alteração dos seguintes arquivos: 

* catalog/view/theme/default/template/payment/paybras_boleto.tpl
* catalog/view/theme/default/template/payment/paybras_cartao.tpl
* catalog/view/theme/default/template/payment/paybras_tef.tpl

