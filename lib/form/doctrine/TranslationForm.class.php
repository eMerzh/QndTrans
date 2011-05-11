<?php

/**
 * Translation form.
 *
 * @package    trad
 * @subpackage form
 * @author     eMerzh
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TranslationForm extends BaseTranslationForm
{
  public function configure()
  {
    $this->useFields(array('id','translated_text','is_fuzzy','is_autotrans','message_id'));
    $this->widgetSchema['message_id'] = new sfWidgetFormInputHidden();
  }
}
