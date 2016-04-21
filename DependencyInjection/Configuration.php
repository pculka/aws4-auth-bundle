<?php

namespace PC\Aws4AuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\NodeInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pc_aws4_auth', 'array');

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('user_class')->defaultValue('User')->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}