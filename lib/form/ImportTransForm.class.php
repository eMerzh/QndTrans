<?php 
class ImportTransForm extends BaseForm
{
  public function configure()
  {
    $this->widgetSchema['msg_file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['msg_file'] = new sfValidatorFile(
      array(
          'required' => true,
          'mime_types' => array('text/xml','application/xml')
      )); 

    $this->widgetSchema['lang'] = new sfWidgetFormDoctrineChoice(array('model' => 'Language', 'add_empty' => false));
    $this->validatorSchema['lang'] = new sfValidatorDoctrineChoice(array('model' => 'Language'));

    $this->widgetSchema['fuzzy'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['fuzzy'] = new sfValidatorBoolean(array('required' => false));



    $this->widgetSchema->setNameFormat('import[%s]');
  }

  public function import($part)
  {
    $doc = new DOMDocument();
    $doc->load($this->getValue('msg_file')->getTempName());
    $lang = $this->getValue('lang');
    $fuzzy = ($this->getValue('fuzzy') ? 'true' : 'false');
    $msgs = $doc->getElementsByTagName("trans-unit");
    $i=0;
    $conn = Doctrine_Manager::connection();
    set_time_limit( 60* 3);
    $conn->beginTransaction();
    foreach( $msgs as $msg )
    {
      $conn->exec("SAVEPOINT SAVE_".$i);

      $source = $msg->getElementsByTagName( "source" )->item(0)->nodeValue;
      $target = $msg->getElementsByTagName( "target" )->item(0)->nodeValue;
      if($source == ''|| $target =='') continue;
      try
      {
        $num = $conn->exec('update translation set translated_text = '. $conn->quote($target, 'string').', is_fuzzy = '.$fuzzy.'
          where part_id='.$part->getId().' AND  lang_id ='.$lang.' AND 
          message_id  = ( select id from message where original_text = '.$conn->quote($source, 'string').' and part_id='.$part->getId().')');

        if(! $num) $conn->exec('insert into translation (part_id, message_id, lang_id, translated_text,created_at, updated_at, is_fuzzy)
          (select '.$part->getId().' , m.id,  '.$lang.', '. $conn->quote($target, 'string') .', now(),now(), '.$fuzzy.'
            FROM message m where original_text = '. $conn->quote($source, 'string').' and part_id = '.$part->getId().'
          );');
      }
      catch (Exception $e)
      {
    
        $conn->exec("ROLLBACK TO SAVEPOINT SAVE_".$i);
        $this->problems[] = $source;
      }
      $i++;

    }
    $conn->commit();
  }
}
