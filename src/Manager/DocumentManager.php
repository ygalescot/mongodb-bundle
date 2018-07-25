<?php

namespace Ygalescot\MongoDBBundle\Manager;

use Doctrine\Common\Annotations\AnnotationReader;
use MongoDB\Client;
use Ygalescot\MongoDBBundle\Factory\CollectionRegistry;
use Ygalescot\MongoDBBundle\Collection\Collection;
use Ygalescot\MongoDBBundle\Resolver\DocumentMetadataResolver;

class DocumentManager
{
    /**
     * @var string
     */
    private $database;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var DocumentMetadataResolver
     */
    private $documentMetadataResolver;

    /**
     * @var CollectionRegistry
     */
    private $collectionFactory;

    /**
     * @param string $database
     * @param string $uri
     * @param array $uriOptions
     * @param array $driverOptions
     * @param AnnotationReader|null $annotationReader
     */
    public function __construct(
        string $database,
        string $uri = 'mongodb://127.0.0.1/',
        array $uriOptions = [],
        array $driverOptions = [],
        AnnotationReader $annotationReader = null
    ) {
        $this->database = $database;
        $this->client = new Client($uri, $uriOptions, $driverOptions);
        $this->documentMetadataResolver = new DocumentMetadataResolver($annotationReader);
    }

    /**
     * @param string $documentClass
     *
     * @return Collection
     *
     * @throws \Exception
     */
    public function getCollection(string $documentClass)
    {
        return $this->collectionRegistry->getCollection(
            $this->client,
            $this->database,
            $this->documentMetadataResolver->getCollectionName($documentClass),
            $documentClass
        );
    }
}