<?php

namespace Knp\Bundle\SnappyBundle\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel implements CompilerPassInterface
{
    private $configurationFilename;

    /**
     * Defines the configuration filename.
     *
     * @param string $filename
     */
    public function setConfigurationFilename($filename)
    {
        $this->configurationFilename = $filename;
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->configurationFilename);
    }

    protected function prepareContainer(ContainerBuilder $container)
    {
        parent::prepareContainer($container);

        $container->addCompilerPass($this);
    }

    public function process(ContainerBuilder $container)
    {
        if ($container->has('knp_snappy.pdf')) {
            $container->findDefinition('knp_snappy.pdf')->setPublic(true);
        }
        if ($container->has('knp_snappy.image')) {
            $container->findDefinition('knp_snappy.image')->setPublic(true);
        }
    }
}
