<?php

namespace Knp\Bundle\SnappyBundle\Snappy\Response;

use Symfony\Component\HttpFoundation\Response as Base;

class Response extends Base
{
    public function __construct($content, $status = 200, $fileName = 'output.pdf', $contentType = 'application/pdf', $contentDisposition = 'attachment', $headers = array())
    {
        $contentDispositionDirectives = ['inline', 'attachment'];
        if (!in_array($contentDisposition, $contentDispositionDirectives)) {
            throw new \InvalidArgumentException(sprintf('Expected one of directives "%s", %s given.', implode(', ', $contentDispositionDirectives), $contentDisposition));
        }

        parent::__construct($content, $status, $headers);
        $this->headers->add(array('Content-Type' => $contentType));
        $this->headers->add(array('Content-Disposition' => $this->headers->makeDisposition($contentDisposition, $fileName)));
    }
}
