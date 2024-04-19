<?php

namespace Knp\Bundle\SnappyBundle\Tests\Snappy\Response;

use Knp\Bundle\SnappyBundle\Snappy\Response\JpegResponse;
use PHPUnit\Framework\TestCase;

class JpegResponseTest extends TestCase
{
    public function testDefaultParameters(): void
    {
        $response = new JpegResponse('some_binary_output');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('some_binary_output', $response->getContent());
        $this->assertSame('image/jpg', $response->headers->get('Content-Type'));
        $this->assertSame('inline; filename=output.jpg', str_replace('"', '', $response->headers->get('Content-Disposition')));
    }

    public function testSetDifferentMimeType(): void
    {
        $response = new JpegResponse('some_binary_output', 'test.jpg', 'application/octet-stream');

        $this->assertSame('application/octet-stream', $response->headers->get('Content-Type'));
    }

    public function testSetDifferentFileName(): void
    {
        $fileName = 'test.jpg';
        $response = new JpegResponse('some_binary_output', $fileName);
        $fileNameFromDispositionRegex = '/.*filename=([^"]+)/';

        $this->assertSame(1, preg_match($fileNameFromDispositionRegex, str_replace('"', '', $response->headers->get('Content-Disposition')), $matches), 1);

        $this->assertSame($fileName, $matches[1]);
    }

    public function testSpecialCharacters(): void
    {
        $response = new JpegResponse('', 'Ä.jpg', 'image/jpg', fileNameFallBack: 'thefilenamefallback.jpg');
        $this->assertSame('inline; filename=thefilenamefallback.jpg; filename*=utf-8\'\'%C3%84.jpg', str_replace('"', '', $response->headers->get('Content-Disposition')));
    }
}
