<?php

namespace Ygalescot\MongoDBBundle\Document;

use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Persistable;
use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;

abstract class Document implements Persistable
{
    /**
     * @var ObjectID
     */
    protected $_id;

    public function __construct()
    {
        $this->_id = new ObjectID();
    }

    /**
     * @return ObjectID
     */
    public function getObjectId()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id->__toString();
    }

    /**
     * @return array
     */
    public function bsonSerialize()
    {
        $properties = [];
        foreach (get_object_vars($this) as $property => $value) {
            $properties[$property] = $value;
        }

        return $properties;
    }

    /**
     * @param array $data
     */
    public function bsonUnserialize(array $data)
    {
        foreach ($data as $property => $value) {
            if (!property_exists(static::class, $property)) {
                continue;
            }
            if ($value instanceof BSONArray) {
                $value = (array)$value;
            } elseif ($value instanceof BSONDocument) {
                $value = $this->bsonUnserialize($value);
            }

            $this->{$property} = $value;
        }
    }
}
