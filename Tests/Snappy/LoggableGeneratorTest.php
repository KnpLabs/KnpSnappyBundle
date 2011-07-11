<?php

namespace Knp\Bundle\SnappyBundle\Tests\Snappy;

use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;

class LoggableGeneratorTests extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $internal = $this->getMock('Knp\Snappy\GeneratorInterface');
        $internal
            ->expects($this->once())
            ->method('generate')
            ->with(
                $this->equalTo('the_input_file'),
                $this->equalTo('the_output_file'),
                $this->equalTo(array('foo' => 'bar')),
                $this->equalTo(true)
            )
        ;

        $logger = $this->getMock('Symfony\Component\HttpKernel\Log\LoggerInterface');
        $logger
            ->expects($this->once())
            ->method('debug')
            ->with($this->equalTo('Generate from file (the_input_file) to file (the_output_file).'))
        ;

        $generator = new LoggableGenerator($internal, $logger);
        $generator->generate('the_input_file', 'the_output_file', array('foo' => 'bar'), true);
    }

    public function testGenerateFromHtml()
    {
        $internal = $this->getMock('Knp\Snappy\GeneratorInterface');
        $internal
            ->expects($this->once())
            ->method('generateFromHtml')
            ->with(
                $this->equalTo('<html>foo</html>'),
                $this->equalTo('the_output_file'),
                $this->equalTo(array('foo' => 'bar')),
                $this->equalTo(true)
            )
        ;

        $logger = $this->getMock('Symfony\Component\HttpKernel\Log\LoggerInterface');
        $logger
            ->expects($this->once())
            ->method('debug')
            ->with($this->equalTo('Generate from HTML (<html>foo</html>) to file (the_output_file).'))
        ;

        $generator = new LoggableGenerator($internal, $logger);
        $generator->generateFromHtml('<html>foo</html>', 'the_output_file', array('foo' => 'bar'), true);
    }

    public function testOutput()
    {
        $internal = $this->getMock('Knp\Snappy\GeneratorInterface');
        $internal
            ->expects($this->once())
            ->method('getOutput')
            ->with(
                $this->equalTo('the_input_file'),
                $this->equalTo(array('foo' => 'bar'))
            )
        ;

        $logger = $this->getMock('Symfony\Component\HttpKernel\Log\LoggerInterface');
        $logger
            ->expects($this->once())
            ->method('debug')
            ->with($this->equalTo('Output from file (the_input_file).'))
        ;

        $generator = new LoggableGenerator($internal, $logger);
        $generator->getOutput('the_input_file', array('foo' => 'bar'), true);
    }

    public function testOutputFromHtml()
    {
        $internal = $this->getMock('Knp\Snappy\GeneratorInterface');
        $internal
            ->expects($this->once())
            ->method('getOutputFromHtml')
            ->with(
                $this->equalTo('<html>foo</html>'),
                $this->equalTo(array('foo' => 'bar'))
            )
        ;

        $logger = $this->getMock('Symfony\Component\HttpKernel\Log\LoggerInterface');
        $logger
            ->expects($this->once())
            ->method('debug')
            ->with($this->equalTo('Output from HTML (<html>foo</html>).'))
        ;

        $generator = new LoggableGenerator($internal, $logger);
        $generator->getOutputFromHtml('<html>foo</html>', array('foo' => 'bar'), true);
    }
}
