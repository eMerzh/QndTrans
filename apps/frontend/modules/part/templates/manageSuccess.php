<h1><?php echo __('Manage Strings');?></h1>
<table class="manage"> 
  <tbody>
    <?php foreach($msgs as $msg):?>
    <tr>
      <td><input type="checkbox" value="<?php echo $msg['id'];?>"></td>
      <td><?php echo $msg['original_text'];?></td>
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
  <tfoot>
</table>
  <script type="text/javascript">
  $(document).ready(function () {  
    $('#toggle_checks').change(function (event)
    { 
      $('.manage input').attr('checked', $(this).is(':checked'));
    });

    $('#delete_all').click(function (event)
    { 
      event.preventDefault();
      var ids = [];
      $('.manage input:checked').each(function()
      {
        ids.push($(this).val());
      });

      if(ids.length)
        window.location.href ='<?php echo url_for('message/delete?part_id='.$part->getId());?>/ids/'+ids.join("."); 
    });
  });
  </script>

<?php echo image_tag('folder-new.png');?> <?php echo link_to(__('Import Messages'),'part/import?part='.$part->getId());?>
<?php echo image_tag('folder-new.png');?> <?php echo link_to(__('Import Translation'),'part/importtrans?part='.$part->getId());?>
