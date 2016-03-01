<?php

namespace Gravity\CmsBundle\DependencyInjection;

use Gravity\CmsBundle\DependencyInjection\Gravity\NodeConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GravityCmsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('gravity_cms.node_types', $config['node_types']);
        $container->setParameter('gravity_cms.user_entity', $config['user_entity']);

        $this->processGravityConfiguration($config, $container);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * Build the node configurations
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function processGravityConfiguration(array $config, ContainerBuilder $container)
    {
        $configuration = new NodeConfiguration();
        $processor     = new Processor();

        $nodeConfigs = [];
        foreach ($config['node_types'] as $nodeConfig) {
            $nodeClass     = $nodeConfig['class'];
            $nodeClassRefl = new \ReflectionClass($nodeClass);

            $mappingFile =
                dirname(dirname($nodeClassRefl->getFileName())) . '/Resources/config/gravity/' .
                $nodeClassRefl->getShortName() .
                '.node.yml';

            if (!file_exists($mappingFile)) {
                throw new \RuntimeException("YAML mapping file not found for '{$nodeClass}' ({$mappingFile})");
            }

            $config = Yaml::parse(file_get_contents($mappingFile));

            $nodeConfigs[$nodeClass] = $processor->processConfiguration(
                $configuration,
                [
                    $config,
                ]
            );
        }

        $container->setParameter('gravity_cms.node_configs', $nodeConfigs);
    }
}
