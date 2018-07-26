<?php

namespace Ygalescot\MongoDBBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class YgalescotMongoDBExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . 'Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $bundleConfig = $config['ygalescot_mongodb'];

        $annotationReaderDefinition = $container->hasDefinition('annotation_reader') ? $container->getDefinition('annotation_reader') : null;

        $documentManagerDefinition = $container->getDefinition('ygalescot_mongodb.document_manager');
        $documentManagerDefinition->setArguments([
            $bundleConfig['database_name'],
            $bundleConfig['database_uri'],
            $bundleConfig['uri_options'],
            $bundleConfig['driver_options'],
            $annotationReaderDefinition
        ]);
    }
}