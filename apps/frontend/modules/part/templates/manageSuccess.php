<h1><?php echo __('Manage Strings');?></h1>

<ul class="actions_list">
<li><?php echo image_tag('list-add.png');?> <?php echo link_to(__('Add new message'),'part/addMessage?part='.$part->getId());?></li>
<li><?php echo image_tag('folder-new.png');?> <?php echo link_to(__('Import Messages'),'part/import?part='.$part->getId());?></li>
<li><?php echo image_tag('import-trans.png');?> <?php echo link_to(__('Import Translation'),'part/importtrans?part='.$part->getId());?></li>
<li><?php echo image_tag('edit-delete.png');?> <?php echo link_to(__('Delete Part'),'part/delete?id='.$part->getId());?></li>
</ul>

<table class="manage"> 
  <thead>
    <tr>
    <th></th>
    <th><?php echo __('Strings');?></th>
    <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($msgs as $msg):?>
    <tr>
      <td><input type="checkbox" value="<?php echo $msg['id'];?>"></td>
      <td class="original_message"><?php echo $msg->getTextCharEscaped(ESC_RAW);;?></td>
      <td><?php echo link_to(image_tag('edit-delete.png'),'message/delete?id='.$msg['id']);?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot>
    <tr>
      <td><input type="checkbox" id="toggle_checks"></td>
      <td><a href="#" id="delete_all"><?php echo __('Delete checked');?></a></td>
      <td></td>
    </tr>
  </tfoot>
</table>
  <script type="text/javascript">
  $(document).ready(function () {  
    $('#toggle_checks').change(function (event)
    { 
      $('.manage tbody input').attr('checked', $(this).is(':checked'));
    });

    $('#delete_all').click(function (event)
    { 
      event.preventDefault();
      var ids = [];
      $('.manage tbody input:checked').each(function()
      {
        ids.push($(this).val());
      });

      if(ids.length)
        window.location.href ='<?php echo url_for('message/delete?part_id='.$part->getId());?>/ids/'+ids.join("."); 
    });
  });
  </script>