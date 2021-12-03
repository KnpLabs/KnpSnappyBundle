<?php

namespace Knp\Bundle\SnappyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KnpSnappyExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));

        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);

        if ($config['pdf']['enabled']) {
            $loader->load('pdf.xml');

            $container->setParameter('knp_snappy.pdf.binary', $config['pdf']['binary']);
            $container->setParameter('knp_snappy.pdf.options', $config['pdf']['options']);
            $container->setParameter('knp_snappy.pdf.env', $config['pdf']['env']);

            if (!empty($config['temporary_folder'])) {
                $container->findDefinition('knp_snappy.pdf')
                    ->addMethodCall('setTemporaryFolder', [$config['temporary_folder']]);
            }
            if (!empty($config['process_timeout'])) {
                $container->findDefinition('knp_snappy.pdf')
                    ->addMethodCall('setTimeout', [$config['process_timeout']]);
            }
        }

        if ($config['image']['enabled']) {
            $loader->load('image.xml');

            $container->setParameter('knp_snappy.image.binary', $config['image']['binary']);
            $container->setParameter('knp_snappy.image.options', $config['image']['options']);
            $container->setParameter('knp_snappy.image.env', $config['image']['env']);

            if (!empty($config['temporary_folder'])) {
                $container->findDefinition('knp_snappy.image')
                    ->addMethodCall('setTemporaryFolder', [$config['temporary_folder']]);
            }
            if (!empty($config['process_timeout'])) {
                $container->findDefinition('knp_snappy.image')
                    ->addMethodCall('setTimeout', [$config['process_timeout']]);
            }
        }
    }
}
