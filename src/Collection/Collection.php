<?php

namespace Ygalescot\MongoDBBundle\Collection;

class Collection
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \MongoDB\Collection
     */
    private $mongoDBCollection;

    /**
     * @param string $name
     * @param \MongoDB\Collection $mongoDBCollection
     */
    public function __construct(string $name, \MongoDB\Collection $mongoDBCollection)
    {
        $this->name = $name;
        $this->mongoDBCollection = $mongoDBCollection;
    }
}