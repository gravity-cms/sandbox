<?php


namespace Gravity\MenuBundle\Menu;

use Doctrine\ORM\EntityManager;
use Gravity\MenuBundle\Entity\MenuItem;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

/**
 * Class MenuBuilder
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class MenuBuilder
{
    private $factory;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager    $entityManager
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(EntityManager $entityManager, FactoryInterface $factory)
    {
        $this->factory       = $factory;
        $this->entityManager = $entityManager;
    }

    public function createGravityMenu(array $options)
    {
        $menu = $this->factory->createItem($options['type']);
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        $repository = $this->entityManager->getRepository('GravityMenuBundle:MenuItem');
        $menuItems  = $repository->findBy(
            [
                'menu'   => $options['type'],
                'parent' => null,
            ]
        );

        foreach ($menuItems as $menuItem) {
            $this->addChildNodes($menu, $menuItem);
        }

        return $menu;
    }

    private function addChildNodes(ItemInterface $menu, MenuItem $menuItem)
    {
        $child = $menu->addChild($menuItem->getName(), $this->createMenuOptions($menuItem));
        foreach ($menuItem->getChildren() as $childItem) {
            $this->addChildNodes($child, $childItem);
        }
    }

    /**
     * @param MenuItem $menuItem
     *
     * @return array
     */
    private function createMenuOptions(MenuItem $menuItem)
    {
        $options = [];
        if ($menuItem->isRoute()) {
            $options['route']           = $menuItem->getRoute();
            $options['routeParameters'] = $menuItem->getRouteParameters();
        } else {
            $options['uri'] = $menuItem->getUrl();
        }

        return $options;
    }
}
