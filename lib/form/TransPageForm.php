<?php
class TransPageForm extends BaseForm
{
  public function configure()
  {
    $subForm = new sfForm();
    $this->embedForm('Trans',$subForm);
    $ids = array();
    foreach($this->options['messages'] as $key => $messages)
    {
        $form = new TranslationForm($this->options['translations'][$messages->getId()]);
        $ids[] = $messages->getId();
        $this->embeddedForms['Trans']->embedForm($messages->getId(), $form);
    }
    $this->embedForm('Trans', $this->embeddedForms['Trans']);
    $this->widgetSchema['msg_ids'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['msg_ids']->setDefault(implode('.',$ids));
    $this->validatorSchema['msg_ids'] = new sfValidatorString(
            array('required' => true)
    );
    sfWidgetFormSchema::setDefaultFormFormatterName('list');
    $this->widgetSchema->setNameFormat('translations[%s]');
  }
  
  public function getMessage($id)
  {
    foreach($this->options['messages'] as $message)
    {
      if($message->getId() == $id)
        return $message;
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