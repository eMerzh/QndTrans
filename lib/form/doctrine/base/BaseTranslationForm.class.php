<?php

/**
 * Translation form base class.
 *
 * @method Translation getObject() Returns the current form's model object
 *
 * @package    trad
 * @subpackage form
 * @author     eMerzh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'part_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Part'), 'add_empty' => false)),
      'message_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Message'), 'add_empty' => false)),
      'lang_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => false)),
      'translated_text' => new sfWidgetFormTextarea(),
      'is_fuzzy'        => new sfWidgetFormInputCheckbox(),
      'is_autotrans'    => new sfWidgetFormInputCheckbox(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'part_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Part'))),
      'message_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Message'))),
      'lang_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Language'))),
      'translated_text' => new sfValidatorString(array('required' => false)),
      'is_fuzzy'        => new sfValidatorBoolean(array('required' => false)),
      'is_autotrans'    => new sfValidatorBoolean(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Translation';
  }

}
