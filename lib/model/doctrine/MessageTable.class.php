<?php

/**
 * MessageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MessageTable extends Doctrine_Table
{
  /**
  * Returns an instance of this class.
  *
  * @return object MessageTable
  */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Message');
  }

  public function getCountForPart($part_id)
  {
    $q = Doctrine_Query::create()
      ->from('Message')
      ->where('part_id = ?',$part_id);
    return $q->count();
  }

  public function getMessagesForTranslation($part, $lang)
  {
    $q = Doctrine_Query::create()
    ->from('Message m')
    ->where('m.part_id = ?', $part)
    ->andWhere('m.lang_id = ?',$lang);
  return $q/*->execute()*/;
  }
  public function getForPart($part)
  {
    $q = Doctrine_Query::create()
    ->from('Message m')
    ->where('m.part_id = ?', $part);
  return $q->execute();
  }


  public function deleteIn($ids)
  {
    if(empty($ids)) return false;
    $q = Doctrine_Query::create()
    
    ->delete('Message m')
    ->whereIn('m.id', $ids);
  return $q->execute();
  }
}