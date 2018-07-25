<?php

namespace Ygalescot\MongoDBBundle\Resolver;


use Doctrine\Common\Annotations\AnnotationReader;
use Ygalescot\MongoDBBundle\Annotation\Document;

class DocumentMetadataResolver
{
    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @param AnnotationReader|null $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader = null)
    {
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
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
        $annotation = $this->readAnnotationFor($documentClass);

        if (empty($annotation->collection) || !is_string($annotation->collection)) {
            throw new \Exception(
                sprintf(
                    'Cannot get collection name from "%s" annotation in document "%s".',
                    get_class($annotation),
                    $documentClass
                )
            );
        }

        return $annotation->collection;
    }

    /**
     * @param string $documentClass
     *
     * @return Document
     *
     * @throws \Exception
     */
    private function readAnnotationFor(string $documentClass)
    {
        if (!class_exists($documentClass)) {
            throw new \Exception(sprintf('Document "%s" does not exist.', $documentClass));
        }

        $reflectionClass = new \ReflectionClass($documentClass);
        $documentClassAnnotation = $this->annotationReader->getClassAnnotation($reflectionClass, Document::class);

        if (!$documentClassAnnotation) {
            throw new \Exception(sprintf('Could not read annotation from "%s"', $documentClass));
        }

        return $documentClassAnnotation;
    }
}