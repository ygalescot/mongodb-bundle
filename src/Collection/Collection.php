<?php

namespace Ygalescot\MongoDBBundle\Collection;

use MongoDB\BSON\ObjectId;
use Ygalescot\MongoDBBundle\Document\Document;

class Collection
{
    /**
     * @var string
     */
    protected $documentClass;

    /**
     * @var \MongoDB\Collection
     */
    protected $mongoDBCollection;

    /**
     * @param string $documentClass
     * @param \MongoDB\Collection $mongoDBCollection
     */
    public function __construct(string $documentClass, \MongoDB\Collection $mongoDBCollection)
    {
        $this->documentClass = $documentClass;
        $this->mongoDBCollection = $mongoDBCollection;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->mongoDBCollection->getCollectionName();
    }

    /**
     * @param Document $document
     * @param array $options
     *
     * @return ObjectId
     */
    public function insertOne(Document $document, array $options = [])
    {
        $result = $this->mongoDBCollection->insertOne($document, $options);
        return $result->getInsertedId();
    }

    public function findOne(array $filter = [], array $options = [])
    {
        return $this->mongoDBCollection->findOne($filter, $options);
    }
}