<?php

namespace Knp\Bundle\SnappyBundle\Tests\Snappy;

use Knp\Bundle\SnappyBundle\Snappy\Response\JpegResponse;
use PHPUnit\Framework\TestCase;

class JpegResponseTest extends TestCase
{
    public function testDefaultParameters()
    {
        $response = new JpegResponse('some_binary_output');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('some_binary_output', $response->getContent());
        $this->assertSame('image/jpg', $response->headers->get('Content-Type'));
        $this->assertSame('inline; filename="output.jpg"', $response->headers->get('Content-Disposition'));
    }

    public function testSetDifferentMimeType()
    {
        $response = new JpegResponse('some_binary_output', 'test.jpg', 'application/octet-stream');

        $this->assertSame('application/octet-stream', $response->headers->get('Content-Type'));
    }

    public function testSetDifferentFileName()
    {
        $fileName = 'test.jpg';
        $response = new JpegResponse('some_binary_output', $fileName);
        $fileNameFromDispositionRegex = '/.*filename="([^"]+)"/';

        $this->assertSame(1, preg_match($fileNameFromDispositionRegex, $response->headers->get('Content-Disposition'), $matches), 1);

        $this->assertSame($fileName, $matches[1]);
    }
}
