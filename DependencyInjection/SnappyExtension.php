<?php

namespace Bundle\SnappyBundle\DependencyInjection;

use Symfony\Components\DependencyInjection\Loader\LoaderExtension;
use Symfony\Components\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Components\DependencyInjection\BuilderConfiguration;

class SnappyExtension extends LoaderExtension
{

    public function imageLoad($config)
    {
        $configuration = new BuilderConfiguration();

        $loader = new XmlFileLoader(__DIR__.'/../Resources/config');
        $configuration->merge($loader->load('image.xml'));

        return $configuration;
    }

    public function pdfLoad($config)
    {
        $configuration = new BuilderConfiguration();

        $loader = new XmlFileLoader(__DIR__.'/../Resources/config');
        $configuration->merge($loader->load('pdf.xml'));

        return $configuration;
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return null;
    }

    public function getNamespace()
    {
        return 'http://www.symfony-project.org/schema/dic/symfony';
    }

    public function getAlias()
    {
        return 'snappy';
    }

}
