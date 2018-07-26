<?php

namespace Ygalescot\MongoDBBundle\Manager;

use Doctrine\Common\Annotations\AnnotationReader;
use MongoDB\Client;
use Ygalescot\MongoDBBundle\Factory\CollectionRegistry;
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
    private $collectionRegistry;

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
        $this->collectionRegistry = new CollectionRegistry($this->documentMetadataResolver);
    }

    /**
     * @param string $documentClass
     * @param array $options
     *
     * @return \MongoDB\Collection
     * @throws \Exception
     */
    public function getCollection(string $documentClass, array $options = [])
    {
        return $this->collectionRegistry->getCollection($this->client, $this->database, $documentClass, $options);
    }
}