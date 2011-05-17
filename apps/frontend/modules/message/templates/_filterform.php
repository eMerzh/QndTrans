<div class="actions_list">
<form method="get" action="<?php echo url_for('message/index?lang='.$lang.'&part='.$part);?>" id="trans_filter_form">
  <ul>
    <li>
      <?php echo $form['is_fuzzy']->renderLabel();?>
      <?php echo $form['is_fuzzy'];?>
    </li>
    <li>
      <?php echo $form['is_autotrans']->renderLabel();?>
      <?php echo $form['is_autotrans'];?>
    </li>
    <li>
      <?php echo $form['is_translated']->renderLabel();?>
      <?php echo $form['is_translated'];?>
    </li>
    <li>
      <?php echo $form['mess']->renderLabel();?>
      <?php echo $form['mess'];?>
    </li>
  </ul>
  <input type="submit">

      <?php echo $form['rec_per_page']->renderLabel();?>
      <?php echo $form['rec_per_page'];?>
</form>

</div>

