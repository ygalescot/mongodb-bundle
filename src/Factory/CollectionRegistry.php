<?php

namespace Ygalescot\MongoDBBundle\Factory;

use MongoDB\Client;
use Ygalescot\MongoDBBundle\Collection\Collection;
use Ygalescot\MongoDBBundle\Resolver\DocumentMetadataResolver;

class CollectionRegistry
{
    /**
     * @var array
     */
    private $collections = [];

    /**
     * @var DocumentMetadataResolver
     */
    private $documentMetadataResolver;

    /**
     * @param DocumentMetadataResolver $documentMetadataResolver
     */
    public function __construct(DocumentMetadataResolver $documentMetadataResolver)
    {
        $this->documentMetadataResolver = $documentMetadataResolver;
    }

    /**
     * @param Client $mongoDBClient
     * @param string $database
     * @param string $collectionName
     * @param string $documentClass
     *
     * @return Collection
     */
    public function getCollection(Client $mongoDBClient, string $database, string $documentClass)
    {
        if (empty($this->collections[$documentClass])) {
            $collectionName = $this->documentMetadataResolver->getCollectionName($documentClass);
            $mongoDBCollection = $mongoDBClient->selectCollection($database, $collectionName);
            $this->collections[$collectionName] = new Collection($documentClass, $mongoDBCollection);
        }

        return $this->collections[$documentClass];
    }
}