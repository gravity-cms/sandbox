<?php


namespace Gravity\CmsBundle\DependencyInjection\Gravity;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class NodeConfiguration
 *
 * @package Gravity\CmsBundle\DependencyInjection\Gravity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fields');

        $rootNode->isRequired()
            ->children()
                ->arrayNode('routing')
                    ->children()
                        ->scalarNode('path')->end()
                        ->scalarNode('extendable')->end()
                    ->end()
                ->end()

                ->arrayNode('search')
                    ->children()
                        ->scalarNode('handler')->end()
                    ->end()
                ->end()

                ->arrayNode('fields')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('type')->isRequired()->end()
                        ->scalarNode('dynamic')->defaultTrue()->end()
                        ->scalarNode('label')->defaultNull()->end()
                        ->arrayNode('options')
                            ->prototype('variable')->end()
                        ->end()
                        ->arrayNode('widget')
                            ->children()
                                ->scalarNode('type')->isRequired()->end()
                                ->arrayNode('options')
                                    ->prototype('variable')->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('display')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultNull()->end()
                                ->scalarNode('label')->defaultTrue()->end()
                                ->scalarNode('label_inline')->defaultFalse()->end()
                                ->arrayNode('options')
                                    ->prototype('variable')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

}
