<?php

namespace Ygalescot\MongoDBBundle\Factory;

use MongoDB\Client;
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
     * @param Client $client
     * @param string $database
     * @param string $documentClass
     * @param array $options
     *
     * @return \MongoDB\Collection
     * @throws \Exception
     */
    public function getCollection(Client $client, string $database, string $documentClass, array $options = [])
    {
        if (empty($this->collections[$documentClass])) {
            $collectionName = $this->documentMetadataResolver->getCollectionName($documentClass);
            $this->collections[$documentClass] = $client->selectCollection($database, $collectionName, $options);
        }

        return $this->collections[$documentClass];
    }
}