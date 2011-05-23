<?php echo '<?xml version="1.0" encoding="utf-8" ?>';?>
<feed xmlns="http://www.w3.org/2005/Atom">
  <title>Un translated string of <?php echo $part['name'];?> in <?php echo $language['name'];?></title>
  <link href="<?php echo url_for('@homepage',true);?>" />
  <link href="<?php echo url_for('message/feed?part='.$part['id'].'&lang='.$language['id'], true) ?>" rel="self"/>
  <updated><?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ');?></updated>
  <author>
    <name>QndTrans</name>
  </author>
  <id><?php echo sha1(url_for('message/feed?part='.$part['id'].'&lang='.$language['id'], true)) ?></id>
    <?php foreach($messages as $key=>$message):?>
      <entry>
        <title><?php echo $message['original_text'];?></title>
        <link href="<?php echo url_for('message/index?part='.$part['id'].'&lang='.$language['id'], true) ?>" />
        <id><?php echo sha1($message->getId().'.'.$language['id']) ?></id>
        <updated><?php echo gmstrftime('%Y-%m-%dT%H:%M:%SZ', $message->getCreatedAt('U')); ?></updated>
        <summary><?php echo $message['Translations'][0]['translated_text'];?></summary>
      </entry>
  <?php endforeach;?>
  
</feed>