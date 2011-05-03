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
      'item_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => false)),
      'lang_id'         => new sfWidgetFormInputText(),
      'translated_text' => new sfWidgetFormTextarea(),
      'is_fuzzy'        => new sfWidgetFormInputCheckbox(),
      'is_autotrans'    => new sfWidgetFormInputCheckbox(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'item_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'))),
      'lang_id'         => new sfValidatorInteger(),
      'translated_text' => new sfValidatorString(),
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
