<?php

namespace Knp\Bundle\SnappyBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
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
        return [
            [
                [],
                [
                    'pdf'   => [
                        'enabled'   => true,
                        'binary'    => 'wkhtmltopdf',
                        'options'   => [],
                        'env'       => [],
                    ],
                    'image' => [
                        'enabled'   => true,
                        'binary'    => 'wkhtmltoimage',
                        'options'   => [],
                        'env'       => [],
                    ],
                ],
            ],
            [
                [
                    [
                        'pdf'   => [
                            'binary'    => '/path/to/wkhtmltopdf',
                            'options'   => ['foo' => 'bar'],
                            'env'       => [],
                        ],
                        'image' => [
                            'binary'    => '/path/to/wkhtmltoimage',
                            'options'   => ['baz'  => 'bat', 'baf' => 'bag'],
                            'env'       => [],
                        ],
                    ],
                    [
                        'pdf'   => [
                            'options'   => ['bak' => 'bap'],
                            'env'       => [],
                        ],
                    ],
                ],
                [
                    'pdf'   => [
                        'enabled'   => true,
                        'binary'    => '/path/to/wkhtmltopdf',
                        'options'   => ['bak' => 'bap'],
                        'env'       => [],
                    ],
                    'image' => [
                        'enabled'   => true,
                        'binary'    => '/path/to/wkhtmltoimage',
                        'options'   => ['baz' => 'bat', 'baf' => 'bag'],
                        'env'       => [],
                    ],
                ],
            ],
            [
                [
                    ['pdf' => ['enabled' => false]],
                ],
                [
                    'pdf'   => [
                        'enabled'   => false,
                        'binary'    => 'wkhtmltopdf',
                        'options'   => [],
                        'env'       => [],
                    ],
                    'image' => [
                        'enabled'   => true,
                        'binary'    => 'wkhtmltoimage',
                        'options'   => [],
                        'env'       => [],
                    ],
                ],
            ],
            [
                [
                    [
                        'pdf'   => [
                            'options'   => [
                                'foo-bar'   => 'baz',
                            ],
                            'env'       => [],
                        ],
                        'image' => [
                            'options'   => [
                                'bag-baf'   => 'bak',
                            ],
                            'env'       => [],
                        ],
                    ],
                ],
                [
                    'pdf'   => [
                        'enabled'   => true,
                        'binary'    => 'wkhtmltopdf',
                        'options'   => [
                            'foo-bar'   => 'baz',
                        ],
                        'env'       => [],
                    ],
                    'image' => [
                        'enabled'   => true,
                        'binary'    => 'wkhtmltoimage',
                        'options'   => [
                            'bag-baf'   => 'bak',
                        ],
                        'env'       => [],
                    ],
                ],
            ],
            [
                [
                    [
                        'process_timeout' => 120,
                    ],
                ],
                [
                    'process_timeout' => 120,
                    'pdf'             => [
                        'enabled'   => true,
                        'binary'    => 'wkhtmltopdf',
                        'options'   => [],
                        'env'       => [],
                    ],
                    'image' => [
                        'enabled'   => true,
                        'binary'    => 'wkhtmltoimage',
                        'options'   => [],
                        'env'       => [],
                    ],
                ],
            ],
        ];
    }
}
