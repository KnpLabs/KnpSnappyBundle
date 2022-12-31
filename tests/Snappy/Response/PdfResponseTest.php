<?php

namespace Knp\Bundle\SnappyBundle\Tests\Snappy\Response;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use PHPUnit\Framework\TestCase;

class PdfResponseTest extends TestCase
{
    public function testDefaultParameters(): void
    {
        $response = new PdfResponse('some_binary_output');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('some_binary_output', $response->getContent());
        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertSame('attachment; filename=output.pdf', str_replace('"', '', $response->headers->get('Content-Disposition')));
    }

    public function testSetDifferentMimeType(): void
    {
        $response = new PdfResponse('some_binary_output', 'test.pdf', 'application/octet-stream');

        $this->assertSame('application/octet-stream', $response->headers->get('Content-Type'));
    }

    public function testSetDifferentFileName(): void
    {
        $fileName = 'test.pdf';
        $response = new PdfResponse('some_binary_output', $fileName);
        $fileNameFromDispositionRegex = '/.*filename=([^"]+)/';

        $this->assertSame(1, preg_match($fileNameFromDispositionRegex, str_replace('"', '', $response->headers->get('Content-Disposition')), $matches), 1);

        $this->assertSame($fileName, $matches[1]);
    }
}
