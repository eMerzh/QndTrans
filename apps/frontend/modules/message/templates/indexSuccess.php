<?php if ($sf_user->hasFlash('saved')): ?>
  <?php echo $sf_user->getFlash('saved') ?>
<?php endif; ?>
<form method="post" action="<?php url_for('message/index?lang='.$language['id'].'&part='.$part['id']);?>">
  <?php echo $search_form;?>
  <input type="submit">
</form>
<h1>Translation of <?php echo $part['name'];?> to <?php echo $language['name'];?></h1>

  <div class="pager">
    <ul class="pager_nav">
      <?php //$pagerLayout->display(); ?>
    </ul>
  </div>

<form method="post" action="<?php echo url_for('message/acceptTranslations?lang='.$language['id'].'&part='.$part['id']);?>">
<ul>
  <?php foreach($form['Trans'] as $key=>$translation):?>
    <li>
      <h2><?php echo $form->getMessage($translation['message_id']->getValue())->getOriginalText();?></h2>
      <div class="butt" style="background-color:red;width:10px; height:10px;float:left;"></div>
      <?php echo $translation;?>
    </li>
  <?php endforeach;?>
</ul>
  <?php echo $form->renderHiddenFields();?>
  <input type="submit">
</form>
<script type="text/javascript">
google.load('language', '1');

$(document).ready(function () {
  
  $('.butt').click(function(event)
  {
    mess = $(this).parent();
    trans_area = mess.find('textarea');
    trans_area.attr('disabled','disabled');
    google.language.translate(mess.find('h2').html(), "en", "<?php echo $language['code'];?>", function(result) {
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