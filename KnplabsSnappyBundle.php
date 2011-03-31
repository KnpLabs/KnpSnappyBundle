<?php

namespace Knplabs\Bundle\SnappyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class KnplabsSnappyBundle extends BaseBundle
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
