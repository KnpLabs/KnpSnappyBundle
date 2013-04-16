<?php

namespace Knp\Bundle\SnappyBundle\Annotation;

/**
 * Annotation class for @SnappyPDF().
 *
 * @Annotation
 *
 * @author Christopher Baker <christopher@hmudesign.com>
 */
abstract class AbstractAnnotation
{
    /**
     * Constructor.
     *
     * @param array $data An array of key/value parameters.
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.$key;
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf("Unknown property '%s' on annotation '%s'.", $key, get_class($this)));
            }
            $this->$method($value);
        }
    }
    
    abstract public function getAliasName();
}
