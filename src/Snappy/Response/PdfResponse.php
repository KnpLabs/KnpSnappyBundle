<?php

namespace Knp\Bundle\SnappyBundle\Snappy\Response;

class PdfResponse extends SnappyResponse
{
    public function __construct($content, $fileName = 'output.pdf', $contentType = 'application/pdf', $contentDisposition = 'attachment', $status = 200, $headers = [], $fileNameFallBack = '')
    {
        parent::__construct($content, $fileName, $contentType, $contentDisposition, $status, $headers, $fileNameFallBack);
    }
}
