<?php


namespace Gravity\MenuBundle\Menu;

/**
 * Class MenuManager
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class MenuManager
{
    /**
     * @var array
     */
    protected $menus = [];

    /**
     * MenuManager constructor.
     *
     * @param array $menus
     */
    public function __construct(array $menus)
    {
        $this->menus = $menus;
    }

    public function addMenu($name){
        if(!in_array($this->menus, $name)) {
            $this->menus[] = $name;
        }
    }

    /**
     * @return array
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * @return array
     */
    public function getMenuNames()
    {
        return array_keys($this->menus);
    }
}
