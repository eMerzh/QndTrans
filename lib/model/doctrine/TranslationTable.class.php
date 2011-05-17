<?php

/**
 * TranslationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TranslationTable extends Doctrine_Table
{
  /**
    * Returns an instance of this class.
    *
    * @return object TranslationTable
    */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Translation');
  }

  public function searchByIds($ids)
  {
    if(empty($ids)) return array();
    $q = Doctrine_Query::create()
      ->from('Translation t')
      ->wherein('id',$ids);
    return $q->execute();
  }

  public function completeTranslationsFor($part, $language)
  {
    $conn = Doctrine_Manager::connection()->getDbh();
    $part_id = $part->getId();
    $lang_id = $language->getId();
    $query = "insert into translation ( part_id, lang_id, message_id, created_at, updated_at, is_autotrans)
      ( SELECT $part_id, $lang_id, m.id, now(), now(), false
        from message m where not exists 
          (select 1 from translation t where t.lang_id = $lang_id and t.part_id = $part_id  and t.message_id = m.id)
      )";
    $conn->exec($query);
  }
}