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
    $this->useFields(array());
//     unset($this[$this->getCSRFFieldName()]);

    $recPerPages = array("1"=>"1", "2"=>"2", "5"=>"5", "10"=>"10", "25"=>"25", "50"=>"50",);
    $yes_no = array(''=>'',1=>'yes',0=>'no');
    $this->widgetSchema['rec_per_page'] = new sfWidgetFormChoice(array('choices' => $recPerPages), array('class'=>'rec_per_page'));
    $this->setDefault('rec_per_page', strval(sfConfig::get('app_recPerPage',10))); 

    $this->widgetSchema['is_fuzzy'] = new sfWidgetFormInputCheckbox();
    $this->widgetSchema['is_autotrans'] = new sfWidgetFormInputCheckbox();
    $this->widgetSchema['is_translated'] = new sfWidgetFormChoice(array('choices' => $yes_no));
    $this->widgetSchema['current_page'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['mess'] = new sfWidgetFormInput();

    $this->widgetSchema->setLabels(array(
      'rec_per_page' => 'Records per page: ',
      'mess'=>'Original Message',
    ));

    $this->validatorSchema['is_fuzzy'] =  new sfValidatorBoolean(array('required' => false, 'empty_value'=>''));
    $this->validatorSchema['is_autotrans'] =  new sfValidatorBoolean(array('required' => false, 'empty_value'=>''));
    $this->validatorSchema['is_translated'] =  new sfValidatorChoice(array('required' => false, 'choices'=> array('', 1, 0), 'empty_value'=>''));
    $this->validatorSchema['rec_per_page'] = new sfValidatorChoice(array('required' => false, 'choices'=>array_keys($recPerPages), 'empty_value'=>'5'));
    $this->validatorSchema['mess'] = new sfValidatorString(array('required' => false));
    $this->validatorSchema['current_page'] = new sfValidatorInteger(array('required'=>false,'empty_value'=>1));

  }

  public function addIsAutotransColumnQuery($query, $field, $val)
  {
    if($val ==='') return $query;
    $query->andWhere('t.is_autotrans = ?', $val);
    return $query ;
  }

  public function addIsFuzzyColumnQuery($query, $field, $val)
  {
    if($val ==='') return $query;
    $query->andWhere('t.is_fuzzy = ?', $val);
    return $query ;
  }

  public function addIsTranslatedColumnQuery($query, $field, $val)
  {
    if($val ==='') return $query;

    if($val === '1')
      $query->andWhere("t.translated_text != '' ");
  
    elseif($val === '0')
      $query->andWhere("t.translated_text = '' ");

    return $query ;
  }

  public function addMessColumnQuery($query, $field, $val)
  {
    if($val ==='') return $query;

    $query->andWhere("to_tsvector(m.original_text) @@ plainto_tsquery(?)",$val);
    return $query ;
  }

  public function doBuildQuery(array $values)
  {  
    $query = Doctrine_Query::create()
      ->From('Translation t')
      ->innerJoin('t.Message m')
      ->where('t.lang_id = ? and m.part_id = ?', array($this->options['lang']->getId(),$this->options['part']->getId()));
    $this->options['query'] = $query;
    $query = parent::doBuildQuery($values);
    return $query;
  }
}
