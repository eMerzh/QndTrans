<?php if ($sf_user->hasFlash('saved')): ?>
  <?php echo $sf_user->getFlash('saved') ?>
<?php endif; ?>
  <?php //include_partial('filterform', array('form' => $search_form,'lang'=>$language['id'],'part'=>$part['id'])) ?>

<div class="actions_list">
<form method="get" action="<?php echo url_for('message/index?lang='.$language['id'].'&part='.$part['id']);?>" id="trans_filter_form">
  <ul>
    <li>
      <?php echo $search_form['is_translated']->renderLabel();?>
      <?php echo $search_form['is_translated'];?>
    </li>
    <li class="translated_dep">
      <?php echo $search_form['is_fuzzy']->renderLabel();?>
      <?php echo $search_form['is_fuzzy'];?>
    </li>
    <li class="translated_dep">
      <?php echo $search_form['is_autotrans']->renderLabel();?>
      <?php echo $search_form['is_autotrans'];?>
    </li>

    <li>
      <?php echo $search_form['mess']->renderLabel();?>
      <?php echo $search_form['mess'];?>
    </li>

    <!--<li>
      <?php //echo $search_form['rec_per_page']->renderLabel();?>
      <?php //echo $search_form['rec_per_page'];?>
    </li>-->
  </ul>
  <?php echo $search_form->renderHiddenFields();?>
  <input type="submit" name="Search">


 <script type="text/javascript">
  $(document).ready(function () {  
    $("#translation_filters_is_translated").change(function (event)
    {
      if($(this).val() == '1')
      {
        $('.translated_dep').removeClass('form_disabled');
        $("#translation_filters_is_fuzzy").removeAttr("disabled"); 
        $("#translation_filters_is_autotrans").removeAttr("disabled"); 
      }
      else
      {
        $('.translated_dep').addClass('form_disabled');
        $("#translation_filters_is_fuzzy")[0].checked=false;
        $("#translation_filters_is_fuzzy").attr("disabled", true); 
        $("#translation_filters_is_autotrans")[0].checked=false;
        $("#translation_filters_is_autotrans").attr("disabled", true); 
      }
    });
    $("#translation_filters_is_translated").trigger("change");
  });
  </script>
</div>

<h1>Translation of <?php echo $part['name'];?> to <?php echo $language['name'];?></h1>

<?php echo link_to('Export to Xliff','message/xliff?part='.$part['id'].'&lang='.$language['id']);?><br />
<?php echo link_to('Untranslated Feed','message/feed?part='.$part['id'].'&lang='.$language['id']);?>

  <div class="navigation">

    <div class="pager">
      <ul class="pager_nav">
        <?php $pagerLayout->display(); ?>
      </ul>
    </div>
    <div class="pager_info">
      <?php echo format_number_choice('[0]No Results Retrieved|[1]Your query retrieved 1 record|(1,+Inf]Your query retrieved %1% records',
      array('%1%' =>  $pagerLayout->getPager()->getNumResults()),  $pagerLayout->getPager()->getNumResults()); ?>
    </div>
   <div class="clear"></div>
  </div>
      
</form>
  


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
<table class="translations">
  <?php foreach($form['Trans'] as $key=>$translation):?>
    <tbody>
    <tr>
      <th><?php echo __('Original :');?></th>
      <td class="original_message"><?php echo $form->getMessage($translation['message_id']->getValue())->getTextCharEscaped(ESC_RAW);?></td>
      <td><!--<?php echo link_to('Delete the message','part/messagedelete?id='.$translation['message_id']->getValue());?>--></td>
    </tr>
    <tr>
      <th><?php echo $language['name'];?></th>
      <td class="trans_cell">
        <?php echo $translation['translated_text'];?>
      </td>
      <td class="trans_action">
        <div class="trans_but"></div>
        <div class="o_msg" style="display:none"><?php echo $form->getMessage($translation['message_id']->getValue())->getOriginalText();?></div>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <?php echo $translation['is_fuzzy']->renderLabel();?><?php echo $translation['is_fuzzy'];?><br />
        <?php echo $translation['is_autotrans']->renderLabel();?><?php echo $translation['is_autotrans'];?>
      </td>
      <td></td>
    </tr>
    <tr class="suggestions">
      <th><?php echo __('Suggestion :');?></th>
      <td>
        <ul>
          <li class="google"></li>
        </ul>
      </td>
      <td></td>      
    </tr>
    </tbody>
    <tbody class="spacing"><tr><td colspan="3">&nbsp;</td></tr></tbody>
  <?php endforeach;?>
</table>
  <?php echo $form->renderHiddenFields();?>
  <input type="submit">
</form>
<script type="text/javascript">
google.load('language', '1');

$(document).ready(function () {
   $('.trans_but').click(function(event)
  {
    var mess = $(this).closest('tbody');
    google.language.translate(mess.find('.o_msg').html(), "en", "<?php echo $language['code'];?>", function(result) {
      if (!result.error) {
        mess.find('.suggestions .google').html(result.translation);
        mess.find('textarea').html(result.translation);
        mess.find('input[id$=\"_autotrans"]').attr('checked','checked');
      }
    });
  });
});
</script>