<?php

namespace Syagr\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('syagr_media');

        $rootNode
            ->children()
                ->arrayNode('context')
                    ->isRequired()
                    ->prototype('array')
                        ->children()
                            ->arrayNode('providers')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('providers')
                    ->isRequired()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('filesystem')->end()
                            ->arrayNode('allowed_mime_types')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('allowed_files_extensions')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
