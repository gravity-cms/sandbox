<?php


namespace Gravity\CmsBundle\DependencyInjection\Compiler;

use Gravity\CmsBundle\DependencyInjection\Gravity\NodeConfiguration;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\FieldWidgetDefinitionInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Yaml;

/**
 * Class RoutingCompilerPass
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class RoutingCompilerPass implements CompilerPassInterface
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
        $routingTypePool     = $container->findDefinition('gravity_cms.routing.type_pool');

        $routeTypes = [];
        foreach($container->findTaggedServiceIds('gravity_cms.route_type') as $serviceId => $tags)
        {
            foreach($tags as $tag) {
                $routeTypes[$tag['label']] = new Reference($serviceId);
            }
        }

        $routingTypePool->addMethodCall('setRouteTypes', [$routeTypes]);
    }
}
