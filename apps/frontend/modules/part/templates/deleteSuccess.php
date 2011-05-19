<h1><?php echo __('Are you Sure?');?></h1>

<p><?php echo __('Are you really sure you want to delet the following part and all his translation ?');?></p>

  <p><?php echo __('Part :');?>  <?php echo $part['name'];?></p>
  <?php echo link_to('Confirm','part/delete?confirm=1&id='.$part->getId());?>
  <?php echo link_to('cancel','part/manage?part='.$part->getId());?>