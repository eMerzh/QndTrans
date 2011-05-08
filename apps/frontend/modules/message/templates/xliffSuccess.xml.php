<?php echo '<?xml version="1.0" encoding="utf-8" ?>';?>
<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd">
<xliff version="1.0">
  <file source-language="en" target-language="<?php echo $language['code'];?>" datatype="plaintext" original="messages" date="2010-11-18T14:14:52Z" product-name="messages">
    <header/>
    <body>
    <?php foreach($translations as $key=>$translation):?>
      <trans-unit id="<?php echo $translation['message_id'];?>">
        <?php foreach($messages as $message):?>
          <?php if($message['id'] == $translation['message_id']):?>
          <source><?php echo $message['original_text'];?></source>
          <?php endif;?>
        <?php endforeach;?>
        <target><?php echo $translation['translated_text'];?></target>
      </trans-unit>
    <?php endforeach;?>
    </body>
  </file>
</xliff>