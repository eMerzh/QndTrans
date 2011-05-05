<?php

/**
 * BaseMessage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $part_id
 * @property string $original_text
 * @property Part $Part
 * @property Doctrine_Collection $Translations
 * 
 * @method integer             getPartId()        Returns the current record's "part_id" value
 * @method string              getOriginalText()  Returns the current record's "original_text" value
 * @method Part                getPart()          Returns the current record's "Part" value
 * @method Doctrine_Collection getTranslations()  Returns the current record's "Translations" collection
 * @method Message             setPartId()        Sets the current record's "part_id" value
 * @method Message             setOriginalText()  Sets the current record's "original_text" value
 * @method Message             setPart()          Sets the current record's "Part" value
 * @method Message             setTranslations()  Sets the current record's "Translations" collection
 * 
 * @package    trad
 * @subpackage model
 * @author     eMerzh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMessage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('message');
        $this->hasColumn('part_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('original_text', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Part', array(
             'local' => 'part_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Translation as Translations', array(
             'local' => 'id',
             'foreign' => 'message_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}