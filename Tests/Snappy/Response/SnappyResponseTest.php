<?php

namespace Knp\Bundle\SnappyBundle\Tests\Snappy;

use Knp\Bundle\SnappyBundle\Snappy\Response\SnappyResponse;
use PHPUnit\Framework\TestCase;

class SnappyResponseTest extends TestCase
{
    public function testExceptionMessage()
    {
        try {
            new SnappyResponse('', 'test.jpg', 'image/jpg', 'foo');
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Expected one of the following directives: "inline", "attachment", but "foo" given.', $e->getMessage());
        }
    }
}
