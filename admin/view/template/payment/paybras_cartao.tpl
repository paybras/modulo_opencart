<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_title; ?></td>
            <td><input type="text" name="paybras_cartao_title" value="<?php echo $paybras_cartao_title; ?>" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><input type="text" name="paybras_cartao_email" value="<?php echo $paybras_cartao_email; ?>" />
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_token; ?></td>
            <td><input type="text" name="paybras_cartao_token" value="<?php echo $paybras_cartao_token; ?>" />
              <?php if ($error_token) { ?>
              <span class="error"><?php echo $error_token; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_ambience; ?></td>
            <td><select name="paybras_cartao_ambience">
                <?php if ($paybras_cartao_ambience == 'sandbox') { ?>
                <option value="sandbox" selected="selected"><?php echo $text_sandbox; ?></option>
                <?php } else { ?>
                <option value="sandbox"><?php echo $text_sandbox; ?></option>
                <?php } ?>
                <?php if ($paybras_cartao_ambience == 'local') { ?>
                <option value="local" selected="selected"><?php echo $text_local; ?></option>
                <?php } else { ?>
                <option value="local"><?php echo $text_local; ?></option>
                <?php } ?>
                <?php if ($paybras_cartao_ambience == 'live') { ?>
                <option value="live" selected="selected"><?php echo $text_live; ?></option>
                <?php } else { ?>
                <option value="live"><?php echo $text_live; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_carddata; ?></td>
            <td><select name="paybras_cartao_carddata">
                <?php if ($paybras_cartao_carddata == 'Y') { ?>
                <option value="Y" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="Y"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if ($paybras_cartao_carddata == 'N') { ?>
                <option value="N" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="N"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="paybras_cartao_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $paybras_cartao_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_total; ?></td>
            <td><input type="text" name="paybras_cartao_total" value="<?php echo $paybras_cartao_total; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="paybras_cartao_status">
                <?php if ($paybras_cartao_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="paybras_cartao_sort_order" value="<?php echo $paybras_cartao_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 