<?php


namespace Gravity\CmsBundle\DependencyInjection\Compiler;

use Gravity\CmsBundle\Field\FieldDisplayDefinitionInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DisplayCompilerPass
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class DisplayCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $displayManagerDefinition = $container->findDefinition('gravity_cms.display_manager');
        $displayHandlerServices   = $container->findTaggedServiceIds('gravity_cms.display.handler');
        $fieldDisplayTags         = $container->findTaggedServiceIds('gravity_cms.field.display');

        $nodeFieldConfigs = $container->getParameter('gravity_cms.node_configs');

        $displayHandlerReferences = [];
        foreach ($displayHandlerServices as $sId => $tags) {
            $displayHandlerReferences[] = new Reference($sId);
        }

        $displayConfigs = [];
        foreach ($nodeFieldConfigs as $class => $config) {
            $displayConfigs[$class] = $config['display'];
        }

        $fieldDisplayDefinitions = [];
        foreach ($fieldDisplayTags as $sid => $tags) {
            $fieldDisplayDefinitions[] = new Reference($sid);
        }

        $displayManagerDefinition->setArguments([$displayHandlerReferences, $fieldDisplayDefinitions, $displayConfigs]);
    }
}
