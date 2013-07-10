<?php

namespace Knp\Bundle\SnappyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Configuration for the emailing bundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $fixOptionKeys = function ($options) {
            $fixedOptions = array();
            foreach ($options as $key => $value) {
                $fixedOptions[str_replace('_', '-', $key)] = $value;
            }

            return $fixedOptions;
        };

        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('knp_snappy');
        $rootNode
            ->children()
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
