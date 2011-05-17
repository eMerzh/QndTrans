<?php

/**
 * LanguageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LanguageTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object LanguageTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Language');
  }

  public function getLangsForPart($part)
  {
    $q = Doctrine_Query::create()
    ->select("l.*,
(select count(*) from translation t where part_id = ".$part." and lang_id = l.id and (translated_text !='' AND not is_fuzzy) ) as num_trans,
(select count(*) from translation t where part_id = ".$part." and lang_id = l.id and (translated_text !='' AND is_fuzzy) ) as num_fuzzy")
    ->from('Language l')
    ->where("l.code != 'en' "); ///IIIK
    return $q->execute();
  }
  

}