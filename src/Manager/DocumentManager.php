<?php

namespace Ygalescot\MongoDBBundle\Manager;

use Doctrine\Common\Annotations\AnnotationReader;
use MongoDB\Client;
use Ygalescot\MongoDBBundle\Annotation\Document;
use Ygalescot\MongoDBBundle\Factory\CollectionFactory;
use Ygalescot\MongoDBBundle\Collection\Collection;

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
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * DocumentManager constructor.
     *
     * @param string $database
     * @param string $uri
     * @param array $uriOptions
     * @param array $driverOptions
     * @param AnnotationReader $annotationReader
     */
    public function __construct(
        string $database,
        string $uri = 'mongodb://127.0.0.1/',
        array $uriOptions = [],
        array $driverOptions = [],
        AnnotationReader $annotationReader
    ) {
        $this->database = $database;
        $this->client = new Client($uri, $uriOptions, $driverOptions);
        $this->annotationReader = $annotationReader ?: new AnnotationReader();
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
        return $this->collectionFactory->getCollection($this->client, $this->database, $this->getCollectionName($documentClass));
    }

    /**
     * @param string $documentClass
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getCollectionName(string $documentClass)
    {
        if (!class_exists($documentClass)) {
            throw new \Exception(sprintf('Document "%s" does not exist.', $documentClass));
        }

        $reflectionClass = new \ReflectionClass($documentClass);
        $documentClassAnnotation = $this->annotationReader->getClassAnnotation($reflectionClass, Document::class);

        if (empty($documentClassAnnotation->collection) || !is_string($documentClassAnnotation->collection)) {
            throw new \Exception(
                sprintf(
                    'Annotation "%s" in document "%s" has an empty "collection" attribute.',
                    $documentClassAnnotation,
                    $documentClass
                )
            );
        }

        return $documentClassAnnotation->collection;
    }
}