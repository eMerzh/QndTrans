<?php if(count($langs) != 0):?>

<a href="#" id="toggle_lang">Toggle empty languages</a> <br />
<?php echo link_to(__('Add new message'),'part/addMessage?part='.$part_id);?>

<ul class="lang_list">
  <?php foreach($langs as $lang):?>
    <li class="lang_with_<?php echo $lang['num_trans'];?>">
      <?php echo  link_to($lang['name'],'message/index?part='.$part_id.'&lang='.$lang['id'],'class=part_name');?> <?php echo $lang['num_trans'];?>+<?php echo $lang['num_fuzzy'];?>/<?php echo $message_number;?>
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