<h1><?php echo __('Project lists');?></h1>

<ul class="projects">
  <?php foreach($parts as $part):?>
    <li>
      <?php echo link_to($part['name'],'part/chooselang?part='.$part['id'],'class=part_name');?> <span class="msg_num">(<span class="num"><?php echo $part['num_messages'];?></span> messages)</span>
      <?php echo link_to(image_tag('list-add.png'),'part/addMessage?part='.$part['id']);?>
    </li>
  <?php endforeach;?>
</ul>

<?php echo image_tag('list-add.png');?> <?php echo link_to(__('Add part'),'part/add');?>
