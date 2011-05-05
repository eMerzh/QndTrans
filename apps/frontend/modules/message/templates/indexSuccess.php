<?php foreach($messages as $message):?>
  - <?php echo $message['original_text'];?> ==> 
    <?php if(isset($message['Translations'][0])):?>
      <?php echo $message['Translations'][0]['translated_text'];?>
    <?php else:?>
      n/a
   <?php endif;?>
  <br />
<?php endforeach;?>
