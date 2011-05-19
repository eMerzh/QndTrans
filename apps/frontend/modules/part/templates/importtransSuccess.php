<h1><?php echo __('Import Messages file');?></h1>
<form action="<?php echo url_for('part/importtrans?part='.$part->getId());?>" method="post" enctype="multipart/form-data">
    <table>
    <tr>
      <td><?php echo $form['msg_file']->renderLabel();?></td>
      <td><?php echo $form['msg_file'];?></td>
    </tr>
    <tr>
      <td><?php echo $form['lang']->renderLabel();?></td>
      <td><?php echo $form['lang'];?></td>
    </tr>
    <tr>
      <td><?php echo $form['fuzzy']->renderLabel();?></td>
      <td><?php echo $form['fuzzy'];?></td>
    </tr>
  </table>
   <?php echo $form->renderHiddenFields();?>
  <input type="submit" />
<form>