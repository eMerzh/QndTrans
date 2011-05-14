<h1><?php echo __('Are you Sure?');?></h1>

<p>
  <?php echo __('Are you really sure you want to delet the following message for every language?');?>

  <?php echo __('Message :');?> <div class="quote_message">
    <?php echo $message->getOriginalText();?>
  </div>
  <?php echo link_to('Confirm','part/messagedelete?confirm=1&id='.$message->getId());?>
  <?php echo link_to('cancel','part/chooselang?part='.$message->getPartId());?>
</p>