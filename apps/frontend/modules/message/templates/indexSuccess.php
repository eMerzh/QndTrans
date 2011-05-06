
<form method="post" action="<?php url_for('message/index');?>">
<ul>
  <?php foreach($form['Trans'] as $key=>$translation):?>
    <li>
      <h1><?php echo $form->getMessage($translation['message_id']->getValue())->getOriginalText();?></h1>
      <?php echo $translation;?>
    </li>
  <?php endforeach;?>
</ul>
  <?php echo $form->renderHiddenFields();?>
  <input type="submit">
</form>