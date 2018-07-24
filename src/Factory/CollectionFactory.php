<?php

namespace Ygalescot\MongoDBBundle\Factory;

use MongoDB\Client;
use Ygalescot\MongoDBBundle\Collection\Collection;

class CollectionFactory
{
    /**
     * @var array
     */
    private $collections = [];

    /**
     * @param Client $mongoDBClient
     * @param string $database
     * @param string $collectionName
     *
     * @return Collection
     */
    public function getCollection(Client $mongoDBClient, string $database, string $collectionName)
    {
        if (empty($this->collections[$collectionName])) {
            $mongoDBCollection = $mongoDBClient->selectCollection($database, $collectionName);
            $this->collections[$collectionName] = new Collection($collectionName, $mongoDBCollection);
        }

        return $this->collections[$collectionName];
    }
}