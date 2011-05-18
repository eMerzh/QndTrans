<h1><?php echo __('Import Messages file');?></h1>
<form action="<?php echo url_for('part/import?part='.$part->getId());?>" method="post" enctype="multipart/form-data">
    <ul>
    <li>
      <?php echo $form['msg_file']->renderLabel();?>
      <?php echo $form['msg_file'];?>
    </li>
  </ul>
   <?php echo $form->renderHiddenFields();?>
  <input type="submit" />
<form>