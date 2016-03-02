<?php

namespace Gravity\AdminBundle\DependencyInjection\Compiler;

use Sonata\AdminBundle\DependencyInjection\Configuration;
use Symfony\Bundle\AsseticBundle\DependencyInjection\DirectoryResourceDefinition;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ThemeCompilerPass
 *
 * @package Gravity\AdminBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ThemeCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $configs      = $container->getExtensionConfig('sonata_admin');
        $sonataConfig = new Configuration();
        $processor    = new Processor();
        $config       = $processor->processConfiguration($sonataConfig, $configs);

        $themes = $container->findTaggedServiceIds('gravity_admin.theme');

        $assetManagerDefinition = $container->findDefinition('assetic.asset_manager');
        $engines                = $container->getParameter('templating.engines');
        $themeManagerDefinition = $container->getDefinition('gravity_admin.theme_manager');
        $themeManagerReference  = new Reference('gravity_admin.theme_manager');

        // the admin javascripts
        $javascripts = [];
        foreach ($javascripts as $file) {
            if (strpos($file, '@') !== 0) {
                throw new \Exception("Assets must be referenced by bundles name (e.g. @AcmeDemoBundle)");
            }
        }
        $stylesheets = [];
        foreach ($stylesheets as $file) {
            if (strpos($file, '@') !== 0) {
                throw new \Exception("Assets must be referenced by bundles name (e.g. @AcmeDemoBundle)");
            }
        }

        foreach ($javascripts as $jsAsset) {
            list($alias, $destination) = explode('/', $jsAsset, 1);
            $alias = str_replace('@', '', $alias);
            $assetManagerDefinition->addMethodCall(
                'setFormula',
                [
                    'gravity_admin_' . str_replace(['/', '@', '.js'], ['_', '', ''], $jsAsset), [
                    $jsAsset,
                    ['?uglifyjs2'],
                    [
                        'output' => 'js/admin/' . $alias . '/' . $destination
                    ],
                ]
                ]
            );
        }

        $cssRoot = '/css';
        foreach ($stylesheets as $file) {
            // skip _*.scss files
            if (strpos($file, '_') === 0) {
                continue;
            }
            list($alias, $destination) = explode('/', $file, 1);
            $alias     = str_replace('@', '', $alias);
            $assetId   = 'gravity_module_' . $alias . '_' . str_replace(
                    ['/', '-', '.scss', '.css'],
                    ['_', '_', '', ''],
                    $destination
                );
            $assetPath = '/cms/admin/' . $alias . '/' . $destination;
            $assetPath = str_replace('.scss', '.css', $assetPath);

//            $assetMap[$assetNamespace . $destination] = $assetPath;
//            $cssFiles[]                               = $file;

            $assetManagerDefinition->addMethodCall(
                'setFormula',
                [
                    $assetId,
                    [
                        $file,
                        ['compass'],
                        [
                            'output' => $cssRoot . $assetPath
                        ],
                    ]
                ]
            );
        }

        foreach ($themes as $sid => $tags) {
            $themeDefinition = $container->getDefinition($sid);
            $meta            = new \ReflectionClass($themeDefinition->getClass());
            $path            = pathinfo($meta->getFileName(), PATHINFO_DIRNAME);

            foreach ($tags as $tag) {

                $alias = $tag['alias'];
                $themeManagerDefinition->addMethodCall('addTheme', [new Reference($sid)]);

                $loader            = $container->findDefinition('twig.loader.theme_loader');
                $templateFolder    = $path . '/Resources/views';
                $templateNamespace = 'theme_' . $alias;
                if (file_exists($templateFolder)) {
                    $loader->addMethodCall('addPath', [$templateFolder, $templateNamespace]);
                }

                // register theme with assetic
                foreach ($engines as $engine) {
                    $resourceDefinitionId = 'assetic.' . $engine . '_directory_resource.theme_' . $alias;
                    $container->setDefinition(
                        $resourceDefinitionId,
                        new DirectoryResourceDefinition(
                            'theme_' . $alias, $engine, [
                            $container->getParameter('kernel.root_dir') . '/Resources/theme_' . $alias . '/views',
                            $path . '/Resources/views',
                        ]
                        )
                    );
                    $assetManagerDefinition->addMethodCall(
                        'addResource',
                        [new Reference($resourceDefinitionId), $engine]
                    );
                }

                // add the theme manager into the asset factory
                $assetFactoryDefinition = $container->findDefinition('assetic.asset_factory');
                $assetFactoryDefinition->addMethodCall('setThemeManager', [$themeManagerReference]);

                // tell asstic where the theme assets are
                $jsAssets = @glob($path . '/Resources/assets/js/*.js');
                if (count($jsAssets)) {
                    foreach ($jsAssets as $jsAsset) {
                        $destination = str_replace($path . '/Resources/assets/js/', '', $jsAsset);
                        $assetManagerDefinition->addMethodCall(
                            'setFormula',
                            [
                                'gravity_theme_' . $alias . '_' .
                                str_replace(['/', '.js'], ['_', ''], $destination), [
                                $jsAsset,
                                ['?uglifyjs2'],
                                [
                                    'output' => 'js/theme/' . $alias . '/' . $destination
                                ],
                            ]
                            ]
                        );
                    }
                }

                $maps = [
                    '.jpg'  => 'jpegoptim',
                    '.jpeg' => 'jpegoptim',
                    '.png'  => 'optipng',
                    '.gif'  => null,
                ];
                foreach ($maps as $ext => $app) {
                    // image assets
                    $imgAssets = @glob($path . '/Resources/assets/img/*' . $ext);
                    if (count($imgAssets)) {
                        if ($app) {
                            $app = ['?' . $app];
                        } else {
                            $app = [];
                        }

                        foreach ($imgAssets as $imgAsset) {
                            $destination = str_replace($path . '/Resources/assets/img/', '', $imgAsset);
                            $assetManagerDefinition->addMethodCall(
                                'setFormula',
                                [
                                    'gravity_theme_' . $alias . '_' .
                                    str_replace(['/', $ext], ['_', ''], $destination), [
                                    $imgAsset,
                                    $app,
                                    [
                                        'output' => 'img/theme/' . $alias . '/' . $destination
                                    ],
                                ]
                                ]
                            );
                        }
                    }
                }
            }
        }

    }
} 
