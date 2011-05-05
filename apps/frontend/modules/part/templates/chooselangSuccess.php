<?php if(count($langs) != 0):?>
<ul>
  <?php foreach($langs as $lang):?>
    <li>
      <?php echo  link_to($lang['name'],'message/index?part='.$part_id.'&lang='.$lang['id'],'class=part_name');?> <?php echo $lang['num_trans'];?>+<?php echo $lang['num_fuzzy'];?>/<?php echo $message_number;?>
    </li>
  <?php endforeach;?>
</ul>
<?php else:?>
  No Translations yet in this project.
<?php endif;?>