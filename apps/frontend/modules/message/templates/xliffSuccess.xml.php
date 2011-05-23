<?php echo '<?xml version="1.0" encoding="utf-8" ?>';?>
<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd">
<xliff version="1.0">
  <file source-language="en" target-language="<?php echo $language['code'];?>" datatype="plaintext" original="en">
    <header/>
    <body>
    <?php foreach($messages as $key=>$message):?>
      <trans-unit id="<?php echo $message['id'];?>">
        <source><?php echo $message['original_text'];?></source>
        <target><?php echo $message['Translations'][0]['translated_text'];?></target>
      </trans-unit>
    <?php endforeach;?>
    </body>
  </file>
</xliff>
