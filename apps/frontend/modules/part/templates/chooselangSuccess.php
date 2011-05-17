<?php if ($sf_user->hasFlash('error')): ?>
  <div class="flash_error"><?php echo $sf_user->getFlash('error') ?></div>
<?php endif; ?>

<?php if(count($langs) != 0):?>

<ul class="actions_list">
<li><?php echo image_tag('list-add.png');?> <?php echo link_to(__('Add new message'),'part/addMessage?part='.$part_id);?></li>
<li><?php echo image_tag('toggle.png');?> <a href="#" id="toggle_lang">Toggle empty languages</a></li>
</ul>

<ul class="lang_list">
  <?php foreach($langs as $lang):?>
    <li class="lang_with_<?php echo $lang['num_trans']+$lang['num_fuzzy'];?>">
       <div class="progress-container">
        <div class="trans" style="width: <?php echo ($lang['num_trans']/$message_number)*100;?>%;"></div>
        <div class="fuzzy" style="width: <?php echo ($lang['num_fuzzy']/$message_number)*100;?>%;margin-left:<?php echo ($lang['num_trans']/$message_number)*100;?>%;"></div>
       </div>
      <?php echo  link_to($lang['name'],'message/index?part='.$part_id.'&lang='.$lang['id'],'class=part_name');?>
      <span class="msg_num"><span class="num"><?php echo $lang['num_trans'];?></span>+<?php echo $lang['num_fuzzy'];?> / <span class="num"><?php echo $message_number;?></span> <?php echo __('Messages');?></span>
    </li>
  <?php endforeach;?>
</ul>

  <script type="text/javascript">
  $(document).ready(function () {  
    $(".lang_list li.lang_with_0").hide();
    $('#toggle_lang').click(function (event)
    { 
      event.preventDefault();
      $(".lang_list li.lang_with_0").toggle();
    });
  });
  </script>

<?php else:?>
  No Translations yet in this project.
<?php endif;?>