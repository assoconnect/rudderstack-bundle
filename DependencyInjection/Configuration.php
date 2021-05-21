<?php

namespace AssoConnect\RudderstackBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('rudderstack');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('rudderstack');
        }

        $rootNode
            ->children()
                ->scalarNode('write_key')
                    ->defaultValue('')
                ->end()
                ->arrayNode('sources')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('write_key')->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('guest_id')
                    ->defaultValue('guest')
                ->end()
                ->enumNode('env')
                    ->values(['dev', 'prod'])
                    ->defaultValue('prod')
                ->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('consumer')
                            ->defaultValue('socket')
                        ->end()
                        ->scalarNode('data_plane_url')
                            ->defaultValue(null)
                        ->end()
                        ->booleanNode('debug')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('ssl')
                            ->defaultFalse()
                        ->end()
                        ->integerNode('max_queue_size')
                            ->defaultValue(10000)
                        ->end()
                        ->integerNode('batch_size')
                            ->defaultValue(100)
                        ->end()
                        ->floatNode('timeout')
                            ->defaultValue(0.5)
                        ->end()
                        ->scalarNode('filename')
                            ->defaultValue(null)
                        ->end()
                    ->end()
                ->end()
            ->end()
            ;

        return $treeBuilder;
    }
}
