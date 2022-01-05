<?php

namespace Knp\Bundle\SnappyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for the emailing bundle.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $fixOptionKeys = function ($options) {
            $fixedOptions = [];
            foreach ($options as $key => $value) {
                $fixedOptions[str_replace('_', '-', $key)] = $value;
            }

            return $fixedOptions;
        };

        $treeBuilder = new TreeBuilder('knp_snappy');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC for symfony/config < 4.2
            $rootNode = $treeBuilder->root('knp_snappy');
        }

        $rootNode
            ->children()
                ->scalarNode('temporary_folder')->end()
                ->integerNode('process_timeout')
                    ->min(1)
                    ->info('Generator process timeout in seconds.')
                ->end()
                ->arrayNode('pdf')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->scalarNode('binary')->defaultValue('wkhtmltopdf')->end()
                        ->arrayNode('options')
                            ->performNoDeepMerging()
                            ->useAttributeAsKey('name')
                            ->beforeNormalization()
                                ->always($fixOptionKeys)
                            ->end()
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('env')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('image')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->scalarNode('binary')->defaultValue('wkhtmltoimage')->end()
                        ->arrayNode('options')
                            ->performNoDeepMerging()
                            ->useAttributeAsKey('name')
                            ->beforeNormalization()
                                ->always($fixOptionKeys)
                            ->end()
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('env')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
