<?php

namespace Ygalescot\MongoDBBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Document extends Annotation
{
    /**
     * @var string
     */
    public $collection;
}
