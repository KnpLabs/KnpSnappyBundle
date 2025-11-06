<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire();

    $services->set(Knp\Snappy\Image::class)
        ->args([
            "%knp_snappy.image.binary%",
            "%knp_snappy.image.options%",
            "%knp_snappy.image.env%",
            ]
        )
        ->call('setLogger', [service('logger')])
        ->tag('monolog.setLogger', ['channel' => 'snappy'])
        ->public()
        ->alias('knp_snappy.image', Knp\Snappy\Image::class)
        ;
};