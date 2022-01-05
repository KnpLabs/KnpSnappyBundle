<?php

namespace Knp\Bundle\SnappyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class KnpSnappyBundle extends BaseBundle
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return strtr(__DIR__, '\\', '/');
    }
}
