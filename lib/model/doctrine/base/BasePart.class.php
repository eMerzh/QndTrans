<?php

/**
 * BasePart
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $Items
 * 
 * @method string              getName()  Returns the current record's "name" value
 * @method Doctrine_Collection getItems() Returns the current record's "Items" collection
 * @method Part                setName()  Sets the current record's "name" value
 * @method Part                setItems() Sets the current record's "Items" collection
 * 
 * @package    trad
 * @subpackage model
 * @author     eMerzh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePart extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('part');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Item as Items', array(
             'local' => 'id',
             'foreign' => 'part_id'));
    }
}