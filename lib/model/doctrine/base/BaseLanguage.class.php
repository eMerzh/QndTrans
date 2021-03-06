<?php

/**
 * BaseLanguage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $code
 * @property Doctrine_Collection $Translations
 * 
 * @method string              getName()         Returns the current record's "name" value
 * @method string              getCode()         Returns the current record's "code" value
 * @method Doctrine_Collection getTranslations() Returns the current record's "Translations" collection
 * @method Language            setName()         Sets the current record's "name" value
 * @method Language            setCode()         Sets the current record's "code" value
 * @method Language            setTranslations() Sets the current record's "Translations" collection
 * 
 * @package    trad
 * @subpackage model
 * @author     eMerzh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLanguage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('language');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('code', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Translation as Translations', array(
             'local' => 'id',
             'foreign' => 'lang_id'));
    }
}