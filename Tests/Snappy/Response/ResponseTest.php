<?php

namespace Knp\Bundle\SnappyBundle\Tests\Snappy;

use Knp\Bundle\SnappyBundle\Snappy\Response\Response as SnappyResponse;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultParameters()
    {
        $response = new SnappyResponse('some_binary_output');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('some_binary_output', $response->getContent());
        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertSame('attachment; filename="output.pdf"', $response->headers->get('Content-Disposition'));
    }

    public function testSetDifferentMimeType()
    {
        $response = new SnappyResponse('some_binary_output', 200, 'test.pdf', 'application/octet-stream');

        $this->assertSame('application/octet-stream', $response->headers->get('Content-Type'));
    }

    public function testSetDifferentFileName()
    {
        $fileName = 'test.pdf';
        $response = new SnappyResponse('some_binary_output', 200, $fileName);
        $fileNameFromDispositionRegex = '/.*filename="([^"]+)"/';

        $this->assertSame(1, preg_match($fileNameFromDispositionRegex, $response->headers->get('Content-Disposition'), $matches), 1);

        $this->assertSame($fileName, $matches[1]);
    }
}
