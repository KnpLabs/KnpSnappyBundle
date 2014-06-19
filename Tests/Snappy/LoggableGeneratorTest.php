<?php

namespace Knp\Bundle\SnappyBundle\Tests\Snappy;

use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;

class LoggableGeneratorTest extends \PHPUnit_Framework_TestCase
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

    public function testOutputFromHtmlWithHtmlArray()
    {
        $internal = $this->getMock('Knp\Snappy\GeneratorInterface');
        $internal
            ->expects($this->once())
            ->method('getOutputFromHtml')
            ->with(
                $this->equalTo(array('<html>foo</html>')),
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
        $generator->getOutputFromHtml(array('<html>foo</html>'), array('foo' => 'bar'), true);
    }

    public function testSetOption()
    {
        $internal = $this->getMock('Knp\Snappy\Image');
        $internal
            ->expects($this->at(0))
            ->method('setOption')
            ->with(
                $this->equalTo('foo'),
                $this->equalTo('bar')
            )
        ;
        $internal
            ->expects($this->at(1))
            ->method('setOption')
            ->with(
                $this->equalTo('foo'),
                $this->equalTo(array('bar'=>'baz'))
            )
        ;

        $logger = $this->getMock('Symfony\Component\HttpKernel\Log\LoggerInterface');
        $logger
            ->expects($this->at(0))
            ->method('debug')
            ->with($this->equalTo('Set option foo = \'bar\'.'))
        ;
        $logger
            ->expects($this->at(1))
            ->method('debug')
            ->with($this->equalTo(
'Set option foo = array (
  \'bar\' => \'baz\',
).'
            ))
        ;

        $generator = new LoggableGenerator($internal, $logger);
        $generator->setOption('foo', 'bar');
        $generator->setOption('foo', array('bar'=>'baz'));
    }
}
