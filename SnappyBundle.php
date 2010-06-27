<?php

namespace Bundle\SnappyBundle;

use Bundle\SnappyBundle\DependencyInjection\SnappyExtension;
use Symfony\Foundation\Bundle\Bundle as BaseBundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;

class SnappyBundle extends BaseBundle
{

    public function buildContainer(ContainerInterface $container)
    {
        Loader::registerExtension(new SnappyExtension());
    }

}
