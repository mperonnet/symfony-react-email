<?php

namespace Mperonnet\ReactEmail\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('react_email');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('template_directory')
                    ->info('The directory where React Email templates are stored')
                    ->defaultValue('%kernel.project_dir%/emails')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('node_path')
                    ->info('Path to the Node.js executable (will attempt to find automatically if not specified)')
                    ->defaultNull()
                ->end()
                ->scalarNode('tsx_path')
                    ->info('Path to the TSX executable')
                    ->defaultValue('%kernel.project_dir%/node_modules/tsx/dist/cli.mjs')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}