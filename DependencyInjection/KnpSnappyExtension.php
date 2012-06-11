<?php

namespace Knp\Bundle\SnappyBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class KnpSnappyExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);

        if ($config['pdf']['enabled']) {
            $loader->load('pdf.xml');
            $container->setParameter('knp_snappy.pdf.binary', $config['pdf']['binary']);
            $container->setParameter('knp_snappy.pdf.options', $config['pdf']['options']);
        }

        if ($config['image']['enabled']) {
            $loader->load('image.xml');
            $container->setParameter('knp_snappy.image.binary', $config['image']['binary']);
            $container->setParameter('knp_snappy.image.options', $config['image']['options']);
        }
    }
}
