<?php

/**
 * Translation filter form.
 *
 * @package    trad
 * @subpackage filter
 * @author     eMerzh
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TranslationFormFilter extends BaseTranslationFormFilter
{
  public function configure()
  {
    $this->useFields(array('is_fuzzy','is_autotrans'/*,'translated_text'*/));
    $recPerPages = array("1"=>"1", "2"=>"2", "5"=>"5", "10"=>"10", "25"=>"25", "50"=>"50",);
    $this->widgetSchema['rec_per_page'] = new sfWidgetFormChoice(array('choices' => $recPerPages), array('class'=>'rec_per_page'));
    $this->setDefault('rec_per_page', strval(sfConfig::get('app_recPerPage',10))); 
    $this->widgetSchema->setLabels(array('rec_per_page' => 'Records per page: ',));
    $this->validatorSchema['rec_per_page'] = new sfValidatorChoice(array('required' => false, 'choices'=>$recPerPages, 'empty_value'=>strval(sfConfig::get('app_recPerPage'))));
    $this->widgetSchema['is_fuzzy'] = new sfWidgetFormChoice(array('choices' => array(''=>'','yes','no')));
    $this->widgetSchema['is_autotrans'] = new sfWidgetFormChoice(array('choices' => array(''=>'','yes','no')));
    $this->widgetSchema['is_translated'] = new sfWidgetFormChoice(array('choices' => array(''=>'','yes','no')));
    $this->validatorSchema['rec_per_page'] = new sfValidatorChoice(array('required' => false, 'choices'=>array(''=>'','yes','no'), 'empty_value'=>''));

  }
}
