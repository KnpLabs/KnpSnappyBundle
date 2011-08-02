<?php

namespace Knp\Bundle\SnappyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataForProcessedConfiguration
     */
    public function testProcessedConfiguration($configs, $expectedConfig)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $this->assertEquals($expectedConfig, $config);
    }

    public function dataForProcessedConfiguration()
    {
        return array(
            array(
                array(),
                array(
                    'pdf'   => array(
                        'enabled'   => true,
                        'binary'    => 'wkhtmltopdf',
                        'options'   => array()
                    ),
                    'image' => array(
                        'enabled'   => true,
                        'binary'    => 'wkhtmltoimage',
                        'options'   => array()
                    )
                )
            ),
            array(
                array(
                    array(
                        'pdf'   => array(
                            'binary'    => '/path/to/wkhtmltopdf',
                            'options'   => array('foo' => 'bar')
                        ),
                        'image' => array(
                            'binary'    => '/path/to/wkhtmltoimage',
                            'options'   => array('baz'  => 'bat', 'baf' => 'bag')
                        )
                    ),
                    array(
                        'pdf'   => array(
                            'options'   => array('bak' => 'bap')
                        )
                    )
                ),
                array(
                    'pdf'   => array(
                        'enabled'   => true,
                        'binary'    => '/path/to/wkhtmltopdf',
                        'options'   => array('bak' => 'bap')
                    ),
                    'image' => array(
                        'enabled'   => true,
                        'binary'    => '/path/to/wkhtmltoimage',
                        'options'   => array('baz' => 'bat', 'baf' => 'bag')
                    )
                )
            ),
            array(
                array(
                    array('pdf' => array('enabled' => false))
                ),
                array(
                    'pdf'   => array(
                        'enabled'   => false,
                        'binary'    => 'wkhtmltopdf',
                        'options'   => array()
                    ),
                    'image' => array(
                        'enabled'   => true,
                        'binary'    => 'wkhtmltoimage',
                        'options'   => array()
                    )
                )
            )
        );
    }
}
