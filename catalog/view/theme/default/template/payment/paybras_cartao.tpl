<h2><?php echo $text_type_payment; ?></h2>
<div class="content" id="payment">
  <table class="form">
    <tr><td colspan='2'>
      <table class='card_type'>
        <tr>
          <?php foreach ($cards as $card) { ?>
              <td class='card'>
                <label  class="<?php echo $card['value']; ?>" title="<?php echo $card['value']; ?>">
                  <input type='radio' name='cartao_bandeira' id='cc_<?php echo $card['value']; ?>' value='<?php echo $card['value']; ?>'/>
                </label>
              </td>
          <?php } ?>
          <input type='hidden' name='cc_type' id='card_value'/>
        </tr>
      </table>
    </td></tr>
    <tr>
      <td><?php echo $entry_cc_number; ?></td>
      <td><input type="text" name="cc_number" value="" onchange='setCard()'/></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_expire_date; ?></td>
      <td><select name="cc_expire_date_month">
          <?php foreach ($months as $month) { ?>
          <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
          <?php } ?>
        </select>
        /
        <select name="cc_expire_date_year">
          <?php foreach ($year_expire as $year) { ?>
          <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_cvv2; ?></td>
      <td><input type="text" name="cc_cvv2" id='codigo_seguranca' class='cc_cvv2' value="" size="3" /></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_parcelas; ?></td>
      <td><select name="cartao_parcelas">
        <?php foreach ($parcelas as $key => $value) { 
          if($key == '1') {?>
            <option selected value="<?php echo $key;?>"><?php echo $value['parcela']. " x R$ " .number_format($value['valor_parcela'],2,',','.'); ?></option>
          <?php } elseif($key != 'sucesso') { ?>
            <option value="<?php echo $key;?>"><?php echo $value['parcela']. " x R$ " .number_format($value['valor_parcela'],2,',','.'); ?></option>
          <?php }
        } ?>
      </select></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_owner; ?></td>
      <td><input type="text" name="cc_owner" value=""/></td>
    </tr>
    <tr>
      <td><?php echo $entry_cc_owner_cpf; ?></td>
      <td><input type="text" name="cc_owner_cpf" value=""/></td>
    </tr>
    <?php if($paybras_cartao_carddata == 'Y') {?>
      <tr>
        <td><?php echo $entry_cc_owner_nasc; ?></td>
        <td><input type="text" name="cc_owner_nasc" value=""/></td>
      </tr>
      <tr>
        <td><?php echo $entry_cc_owner_phone; ?></td>
        <td>
          <input type="text" name="cc_owner_ddd" value="" size="1" />
          <input type="text" name="cc_owner_phone" value=""/>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>

<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
  $.ajax({
    url: 'index.php?route=payment/paybras_cartao/send',
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
      if(json['sucesso']) {
        location = json['url'];
      } else {
        $('#payment').before('<div class="warning">' + json["mensagem_erro"] + '</div>');
      }
    },
    error: function(data) {
      console.log(data);
    }
  });
});

$("input[name='cartao_bandeira'] ").bind('click', function(){
  $("input[name='cc_type'] ").val($("input[name='cartao_bandeira'] ").val());
});

function setCard(){
  var cardNo = $("input[name='cc_number'] ").val();
  //Seta Bandeiras
  $("#codigo_seguranca").removeClass('cc_cvv2');
  $("#codigo_seguranca").removeClass('cc_cvv2_4');
  $("#codigo_seguranca").removeClass('cc_cvv2_3');
  if ((/^(34|37)/).test(cardNo) && cardNo.length <= 15) {
    $("#cc_amex").attr("checked",true);
    $("#codigo_seguranca").addClass('cc_cvv2_4');
    $("input[name='cc_type'] ").val('amex');
  } else if ((/^(4)/).test(cardNo) && cardNo.length <= 16) {
    $("#cc_visa").attr("checked",true);
    $("#codigo_seguranca").addClass('cc_cvv2_3');
    $("input[name='cc_type'] ").val('visa');
  } else if ((/^(5[1-5])/).test(cardNo) && (cardNo.length <= 19)) {
    $("#cc_mastercard").attr("checked",true);
    $("#codigo_seguranca").addClass('cc_cvv2_3');
    $("input[name='cc_type'] ").val('mastercard');
  } else if ((/^(30[0-5]|3[68])/).test(cardNo) && cardNo.length <= 16) {
    $("#cc_diners").attr("checked",true);
    $("#codigo_seguranca").addClass('cc_cvv2_3');
    $("input[name='cc_type'] ").val('diners');
  } else if ((/^(636368|504175|438935|451416|636297)/).test(cardNo) && cardNo.length == 16){
    $("#cc_elo").attr("checked",true);
    $("#codigo_seguranca").addClass('cc_cvv2_3');
    $("input[name='cc_type'] ").val('elo');
  } else {
    return false;
  }
  $(".cc_cvv2_3").mask("999",{placeholder:""});
  $(".cc_cvv2_4").mask("9999",{placeholder:""});
}

$("input[name='cc_owner_cpf'] ").mask("999.999.999-99");
$("input[name='cc_owner_nasc'] ").mask("99/99/9999",{placeholder:"_"});
$("input[name='cc_owner_phone'] ").mask("9999-9999?9",{placeholder:""});
$("input[name='cc_owner_ddd'] ").mask("99",{placeholder:""});
$("input[name='cc_number'] ").mask("9999999999999?999999",{placeholder:""});
$(".cc_cvv2").mask("999?9",{placeholder:""});

//--></script> 