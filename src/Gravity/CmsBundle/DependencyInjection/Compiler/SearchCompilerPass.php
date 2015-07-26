<?php


namespace Gravity\CmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class SearchCompilerPass
 *
 * @package Gravity\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SearchCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $searchHandlerManagerDefinition = $container->findDefinition('gravity_cms.search.handler_manager');
        $searchHandlerTags              = $container->findTaggedServiceIds('gravity_cms.search_handler');

        $searchHandlers = [];
        foreach ($searchHandlerTags as $sid => $tags) {
            $searchHandlers[] = new Reference($sid);
        }

        $searchHandlerManagerDefinition->addMethodCall('setHandlers', [$searchHandlers]);
    }
}
