<?php 
class ImportForm extends BaseForm
{
  public function configure()
  {
    $this->widgetSchema['msg_file'] = new sfWidgetFormInputFile();
    $this->validatorSchema['msg_file'] = new sfValidatorFile(
      array(
          'required' => true,
          'mime_types' => array('text/xml','application/xml')
      )); 
    $this->widgetSchema->setNameFormat('import[%s]');
  }

  public function import($part)
  {
    $doc = new DOMDocument();
    $doc->load($this->getValue('msg_file')->getTempName());
      
    $msgs = $doc->getElementsByTagName("trans-unit");
    $i=0;
    $conn = Doctrine_Manager::connection();
    set_time_limit( 60* 3);
    $conn->beginTransaction();
    $this->problems = array();
    foreach( $msgs as $msg )
    {
      $conn->exec("SAVEPOINT SAVE_".$i);

      $source = trim($msg->getElementsByTagName( "source" )->item(0)->nodeValue);
      if($source == '') continue;
      $m = new Message();
      $m->setPartId($part->getId());
      $m->setOriginalText($source);
      try
      {
        $m->save();
      }
      catch (Exception $e)
      {
    
        $conn->exec("ROLLBACK TO SAVEPOINT SAVE_".$i);
        $this->problems[] = $source;
      }
      $i++;

    }
    $conn->commit();



    return $i;
  }
}
