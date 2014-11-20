<?php

namespace Knp\Bundle\SnappyBundle\Tests;

use Symfony\Component\Filesystem\Filesystem;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    private $kernel;
    private $filesystem;

    public function setUp()
    {
        $this->kernel = new TestKernel(uniqid(), false);

        $this->filesystem = new Filesystem();
        $this->filesystem->mkdir($this->kernel->getCacheDir());
    }

    public function tearDown()
    {
        $this->filesystem->remove($this->kernel->getCacheDir());
    }

    public function testServicesAreBothAvailableOutOfTheBox()
    {
        $this->kernel->setConfigurationFilename(__DIR__.'/fixtures/config/out_of_the_box.yml');
        $this->kernel->boot();

        $container = $this->kernel->getContainer();

        $this->assertTrue($container->has('knp_snappy.pdf'), 'The pdf service is available.');

        $pdf = $container->get('knp_snappy.pdf');

        $this->assertInstanceof('Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator', $pdf);
        $this->assertInstanceof('Knp\Snappy\Pdf', $pdf->getInternalGenerator());
        $this->assertEquals('wkhtmltopdf', $pdf->getInternalGenerator()->getBinary());

        $this->assertTrue($container->has('knp_snappy.image'), 'The image service is available.');

        $image = $container->get('knp_snappy.image');

        $this->assertInstanceof('Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator', $image);
        $this->assertInstanceof('Knp\Snappy\Image', $image->getInternalGenerator());
        $this->assertEquals('wkhtmltoimage', $image->getInternalGenerator()->getBinary());
    }

    public function testChangeBinaries()
    {
        $this->kernel->setConfigurationFilename(__DIR__.'/fixtures/config/change_binaries.yml');
        $this->kernel->boot();

        $container = $this->kernel->getContainer();

        $this->assertTrue($container->has('knp_snappy.pdf'));

        $pdf = $container->get('knp_snappy.pdf');

        $this->assertEquals('/custom/binary/for/wkhtmltopdf', $pdf->getInternalGenerator()->getBinary());

        $this->assertTrue($container->has('knp_snappy.image'));

        $image = $container->get('knp_snappy.image');

        $this->assertEquals('/custom/binary/for/wkhtmltoimage', $image->getInternalGenerator()->getBinary());
    }

    public function testChangeTemporaryFolder()
    {
        $this->kernel->setConfigurationFilename(__DIR__.'/fixtures/config/change_temporary_folder.yml');
        $this->kernel->boot();

        $container = $this->kernel->getContainer();

        $pdf = $container->get('knp_snappy.pdf');
        $this->assertEquals('/path/to/the/tmp', $pdf->getInternalGenerator()->getTemporaryFolder());

        $image = $container->get('knp_snappy.image');
        $this->assertEquals('/path/to/the/tmp', $image->getInternalGenerator()->getTemporaryFolder());
    }

    public function testDisablePdf()
    {
        $this->kernel->setConfigurationFilename(__DIR__.'/fixtures/config/disable_pdf.yml');
        $this->kernel->boot();

        $container = $this->kernel->getContainer();

        $this->assertFalse($container->has('knp_snappy.pdf'), 'The pdf service is NOT available.');
        $this->assertTrue($container->has('knp_snappy.image'), 'The image service is available.');
    }

    public function testDisableImage()
    {
        $this->kernel->setConfigurationFilename(__DIR__.'/fixtures/config/disable_image.yml');
        $this->kernel->boot();

        $container = $this->kernel->getContainer();

        $this->assertTrue($container->has('knp_snappy.pdf'), 'The pdf service is available.');
        $this->assertFalse($container->has('knp_snappy.image'), 'The image service is NOT available.');
    }
}
