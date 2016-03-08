<?php


namespace Gravity\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class MenuCompilerPass
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class MenuCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $definedMenus          = $container->getParameter('gravity_menu.menus');
        $menuManagerDefinition = $container->findDefinition('gravity_menu.menu_manager');

        $menuManagerDefinition->setArguments([$definedMenus]);

        foreach($definedMenus as $name => $options){
            $menuBuilder = new Definition('\Gravity\MenuBundle\Menu\MenuBuilder');

        }
    }
}
