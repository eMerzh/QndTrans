<h1>Translation of <?php echo $part['name'];?> to <?php echo $language['name'];?></h1>
<form method="post" action="<?php url_for('message/index');?>">
<ul>
  <?php foreach($form['Trans'] as $key=>$translation):?>
    <li>
      <h2><?php echo $form->getMessage($translation['message_id']->getValue())->getOriginalText();?></h2>
      <?php get_class($form->getMessage($translation['message_id']->getValue())) ?>
      <?php echo $translation;?>
    </li>
  <?php endforeach;?>
</ul>
  <?php echo $form->renderHiddenFields();?>
  <input type="submit">
</form>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAAYLSKVpK83ZqpxzjnjLuW3BTrReK3P99mKBTfLTiMIdvPR6kVWRT4gViM2g7g5ZnSZewMvjLnp8hUGA"></script>
<script type="text/javascript">
google.load('language', '1');

$(document).ready(function () {
  
  $('h2').click(function(event)
  {
    mess = $(this).parent();
    trans_area = mess.find('textarea');
    trans_area.attr('disabled','disabled');
    google.language.translate($(this).html(), "en", "<?php echo $language['code'];?>", function(result) {
      if (!result.error) {
        trans_area.html(result.translation);
        console.log();
        trans_area.removeAttr('disabled');
        mess.find('input[id$=\"_autotrans"]').attr('checked','checked');
      }
    });
  });
});
</script>