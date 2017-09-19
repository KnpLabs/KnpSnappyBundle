<?php

namespace Knp\Bundle\SnappyBundle\Snappy\Response;

class JpegResponse extends SnappyResponse
{
    public function __construct($content, $fileName = 'output.jpg', $contentType = 'image/jpg', $contentDisposition = 'inline', $status = 200, $headers = [])
    {
        parent::__construct($content, $fileName, $contentType, $contentDisposition, $status, $headers);
    }
}
