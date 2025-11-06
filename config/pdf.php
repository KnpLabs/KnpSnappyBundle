<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire();

    $services->set(Knp\Snappy\Pdf::class)
        ->args([
            "%knp_snappy.pdf.binary%",
            "%knp_snappy.pdf.options%",
            "%knp_snappy.pdf.env%",
            ]
        )
        ->call('setLogger', [service('logger')])
        ->tag('monolog.setLogger', ['channel' => 'snappy'])
        ->public()
        ->alias('knp_snappy.pdf', Knp\Snappy\Pdf::class)
        ;
};