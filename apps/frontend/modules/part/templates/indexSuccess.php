<ul>
  <?php foreach($parts as $part):?>
    <li>
      <?php echo link_to($part['name'],'part/chooselang?part='.$part['id'],'class=part_name');?> (<?php echo $part['num_messages'];?> messages)
    </li>
  <?php endforeach;?>
</ul>