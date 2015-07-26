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
 * Class FieldCompilerPass
 *
 * @package Gravity\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCompilerPass implements CompilerPassInterface
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
        $fieldManagerDefinition     = $container->findDefinition('gravity_cms.field_manager');
        $dashboardGroups            = $container->getParameter('sonata.admin.configuration.dashboard_groups');
        $nodeRouteManagerDefinition = $container->findDefinition('gravity_cms.routing.node_route_manager');

        // build a set of instances of the field definitions so we can pre-process resolve all the field's options
        $fieldDefinitions       = [];
        $fieldWidgetDefinitions = [];

        // field definitions
        $fieldTags = $container->findTaggedServiceIds('gravity_cms.field');
        foreach ($fieldTags as $sid => $tags) {
            $fieldManagerDefinition->addMethodCall(
                'addFieldDefinition',
                [
                    new Reference($sid)
                ]
            );

            $fieldDefinitionDefinition = $container->findDefinition($sid);
            $fieldDefinitionClass      = $fieldDefinitionDefinition->getClass();
            /** @var FieldDefinitionInterface $fieldDefinition */
            $fieldDefinition                               = new $fieldDefinitionClass();
            $fieldDefinitions[$fieldDefinition->getName()] = $fieldDefinition;
        }

        // field widget definitions
        $fieldWidgetTags = $container->findTaggedServiceIds('gravity_cms.field.widget');
        foreach ($fieldWidgetTags as $sid => $tags) {
            $fieldManagerDefinition->addMethodCall(
                'addFieldWidgetDefinition',
                [
                    new Reference($sid)
                ]
            );

            $fieldWidgetDefinitionDefinition = $container->findDefinition($sid);
            $fieldWidgetDefinitionClass      = $fieldWidgetDefinitionDefinition->getClass();
            /** @var FieldWidgetDefinitionInterface $fieldWidgetDefinition */
            $fieldWidgetDefinition                                     = new $fieldWidgetDefinitionClass();
            $fieldWidgetDefinitions[$fieldWidgetDefinition->getName()] = $fieldWidgetDefinition;
        }

        $nodeTypes = $container->getParameter('gravity_cms.node_types');

        $configuration = new NodeConfiguration();
        $processor     = new Processor();

        $fieldMappings = [];

        foreach ($nodeTypes as $nodeConfig) {

            $nodeClass     = $nodeConfig['class'];
            $nodeClassRefl = new \ReflectionClass($nodeClass);

            $fieldMappings[$nodeClass] = [];

            // generate a sonata admin service for the node
            $adminServiceName       = 'gravity_cms.admin.' . strtolower($nodeClassRefl->getShortName());
            $adminServiceDefinition = $container->register($adminServiceName, $nodeConfig['admin']['class']);
            $adminServiceDefinition->setArguments(
                [
                    null,
                    $nodeClass,
                    null,
                ]
            );

            $adminServiceDefinition->addTag(
                'sonata.admin',
                [
                    'manager_type' => 'orm',
                    'group'        => $nodeConfig['admin']['category'] ?: 'Content',
                    'label'        => $nodeConfig['admin']['label'] ?: $nodeClassRefl->getShortName(),
                ]
            );

            $adminServiceDefinition->addMethodCall('setFieldManager', [new Reference('gravity_cms.field_manager')]);
            $adminServiceDefinition->addMethodCall('setTokenStorage', [new Reference('security.token_storage')]);

            $mappingFile =
                dirname(dirname($nodeClassRefl->getFileName())) . '/Resources/config/gravity/' .
                $nodeClassRefl->getShortName() .
                '.node.yml';

            if (!file_exists($mappingFile)) {
                throw new RuntimeException("YAML mapping file not found for '{$nodeClass}' ({$mappingFile})");
            }

            $config = Yaml::parse(file_get_contents($mappingFile));

            $nodeFieldConfig = $processor->processConfiguration(
                $configuration,
                [
                    $config,
                ]
            );

            foreach ($nodeFieldConfig['fields'] as $name => $options) {
                $options['options'] = $this->resolveFieldOptions(
                    $fieldDefinitions[$options['type']],
                    $options['options']
                );

                $options['widget']['options']     = $this->resolveFieldWidgetOptions(
                    $fieldWidgetDefinitions[$options['widget']['type']],
                    $options['widget']['options']
                );
                $fieldMappings[$nodeClass][$name] = $options;
            }

            // add in the routing mappings
            $nodeRouteManagerDefinition->addMethodCall(
                'addNodeMapping',
                [
                    $nodeClass,
                    $nodeFieldConfig['routing']
                ]
            );

            // create a dashboard group
            $dashboardGroups['gravity_cms.admin.group.content']['items'][] = $adminServiceName;
        }

        $fieldManagerDefinition->addMethodCall(
            'setEntityFieldMappings',
            [
                $fieldMappings
            ]
        );
        $container->setParameter('gravity_cms.field_mappings', $fieldMappings);
//        $container->setParameter('sonata.admin.configuration.dashboard_groups', $dashboardGroups);
    }

    protected function resolveFieldOptions(FieldDefinitionInterface $fieldDefinition, array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(
            [
                'searchable' => true,
                'limit'      => -1,
                'required'   => false,
                'label'      => null,
            ]
        );
        $fieldDefinition->setOptions($resolver, $options);

        return $resolver->resolve($options);
    }

    protected function resolveFieldWidgetOptions(FieldWidgetDefinitionInterface $fieldWidgetDefinition, array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(
            [
                'default' => null,
            ]
        );
        $fieldWidgetDefinition->setOptions($resolver, $options);

        return $resolver->resolve($options);
    }

}
