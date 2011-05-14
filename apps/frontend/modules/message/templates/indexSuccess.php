<?php if ($sf_user->hasFlash('saved')): ?>
  <?php echo $sf_user->getFlash('saved') ?>
<?php endif; ?>
<form method="get" action="<?php echo url_for('message/index?lang='.$language['id'].'&part='.$part['id']);?>" id="trans_filter_form">
  <?php echo $search_form;?>
  <input type="submit">
</form>
      <?php echo format_number_choice('[0]No Results Retrieved|[1]Your query retrieved 1 record|(1,+Inf]Your query retrieved %1% records', array('%1%' =>  $pagerLayout->getPager()->getNumResults()),  $pagerLayout->getPager()->getNumResults()) ?>
  <div class="pager">
    <ul class="pager_nav">
      <?php $pagerLayout->display(); ?>
    </ul>
  </div>
<h1>Translation of <?php echo $part['name'];?> to <?php echo $language['name'];?></h1>


  <script type="text/javascript">
  $(document).ready(function () {  
    $(".pager a").click(function (event,data)
    {
      var button;
      if (event.which == null)
       /* IE case */
        button = (event.button < 2) ? "LEFT" : ((event.button == 4) ? "MIDDLE" : "RIGHT");
      else
        /* All others */
       button= (event.which < 2) ? "LEFT" :
                 ((event.which == 2) ? "MIDDLE" : "RIGHT");
      
      if(button == "MIDDLE"){ /*just do nothing */ return true;}
      else event.preventDefault();


      $('#translation_filters_current_page').val($(this).closest('li').attr('data-page'));
      $('#trans_filter_form').closest('form').submit();
    });
  });
  </script>
<form method="post" action="<?php echo url_for('message/acceptTranslations?lang='.$language['id'].'&part='.$part['id']);?>">
<ul>
  <?php foreach($form['Trans'] as $key=>$translation):?>
    <li>
      <h2><?php echo $form->getMessage($translation['message_id']->getValue())->getOriginalText();?></h2>
      <div class="butt" style="background-color:red;width:10px; height:10px;float:left;"></div>
      <?php echo $translation;?>
      <?php echo link_to('Delete the message','part/messagedelete?id='.$translation['message_id']->getValue());?>
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