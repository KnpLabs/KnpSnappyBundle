<?php

namespace Knp\Bundle\SnappyBundle\Annotation;

/**
 * Annotation class for @SnappyPDF().
 *
 * @Annotation
 *
 * @author Christopher Baker <christopher@hmudesign.com>
 */
class SnappyPDF extends AbstractAnnotation
{
    private $active;
    private $disposition;
    
    /**
     * Constructor.
     *
     * @param array $data An array of key/value parameters.
     */
    public function __construct(array $data)
    {
        $this->disposition = 'inline';
        $this->active = true;

        parent::__construct($data);
    }
    
    public function setDisposition($disposition)
    {
        $this->disposition = $disposition;
    }
    
    public function getDisposition()
    {
        return $this->disposition;
    }
    
    public function setActive($active)
    {
        $this->active = $active;
    }
    
    public function isActive()
    {
        return $this->active;
    }
    
    public function getAliasName()
    {
        return 'snappyPDF';
    }
}
