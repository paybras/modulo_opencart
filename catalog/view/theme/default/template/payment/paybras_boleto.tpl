<h2><?php echo $text_type_payment; ?></h2>
<div class="content" id="payment">
  <table class="form">
    <tr>
      <td>
        <p>Sua compra será confirmado somente após o pagamento do boleto. O boleto não é enviado pelo correio, imprima-o e pague-o no banco ou pelo internet banking. </p>
      </td>
    </tr>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
  window.open('', 'popup', 'width=800, height=600, scrollbars=1');
  $.ajax({
    url: 'index.php?route=payment/paybras_boleto/send',
    type: 'post',
    data: $('#payment :input'),
    dataType: 'json',   
    beforeSend: function() {
      $('.warning').remove();
      $('#button-confirm').attr('disabled', true);
      $('#payment').before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
    },
    complete: function() {
      $('#button-confirm').attr('disabled', false);
      $('.attention').remove();
    },        
    success: function(json) {
      console.log(json);
      if(json['sucesso']) {
        window.open(json['url_pagamento'], 'popup', 'width=800, height=600, scrollbars=1');
        location = json['url_success'];
      } else {
        $('#payment').before('<div class="warning">' + json["mensagem_erro"] + '</div>');
      }
    },
    error: function(data) {
      console.log(data);
    }
  });
});
//--></script> 
