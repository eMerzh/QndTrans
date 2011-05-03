<ul>
  <?php foreach($parts as $part):?>
    <li><?php echo link_to($part['name'],'item/index?part='.$part['id'],'class=part_name');?>
  <?php endforeach;?>
</ul>