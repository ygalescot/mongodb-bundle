<?php

namespace Ygalescot\MongoDBBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ygalescot.mongodb');

        $rootNode
            ->children()
                ->scalarNode('database_name')->end()
                ->scalarNode('database_uri')->end()
                ->arrayNode('uri_options')->end()
                ->arrayNode('driver_options')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}