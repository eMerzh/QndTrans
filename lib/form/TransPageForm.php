<?php
class TransPageForm extends BaseForm
{
  public function configure()
  {
    $subForm = new sfForm();
    $this->embedForm('Trans',$subForm);
    $ids = array();
    foreach($this->options['translations'] as $key => $translation)
    {
        $form = new TranslationForm($translation);
        $ids[] = $translation->getId();
        $this->embeddedForms['Trans']->embedForm($translation->getId(), $form);
    }
    $this->embedForm('Trans', $this->embeddedForms['Trans']);
    $this->widgetSchema['msg_ids'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['msg_ids']->setDefault(implode('.',$ids));
    $this->validatorSchema['msg_ids'] = new sfValidatorString(
            array('required' => true)
    );

    $this->widgetSchema['req'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['req'] = new sfValidatorString(
            array('required' => false)
    );
    if(isset($this->options['request']))
      $this->widgetSchema['req']->setDefault(serialize($this->options['request']));

    sfWidgetFormSchema::setDefaultFormFormatterName('list');
    $this->widgetSchema->setNameFormat('translations[%s]');
  }
  
  public function getMessage($id)
  {
    foreach($this->options['translations'] as $translation)
    {
      if($translation->getMessageId() == $id)
        return sfOutputEscaper::escape('esc_entities',$translation['Message']) ;
    }
    return false;
  }

  public function save()
  {
    $value = $this->getValues();
    foreach($this->embeddedForms['Trans']->getEmbeddedForms() as $name => $form)
    {
      $value['Trans'][$name]['part_id'] = $this->options['part_id'];
      $value['Trans'][$name]['lang_id'] = $this->options['lang_id'];
      $form->updateObject($value['Trans'][$name]);
      $form->getObject()->save();
    }
  }
}