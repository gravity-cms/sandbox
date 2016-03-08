<?php


namespace Gravity\MenuBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class MenuItem
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class MenuItem
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $menu;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var MenuItem
     */
    protected $parent;

    /**
     * @var MenuItem[]
     */
    protected $children;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array|null
     */
    protected $route;

    /**
     * @var array
     */
    protected $options = [
        'target' => null,
        'follow' => true,
    ];

    /**
     * MenuItem constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    function __toString()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param string $menu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return MenuItem
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param MenuItem $parent
     */
    public function setParent(MenuItem $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Remove the parent reference
     */
    public function removeParent()
    {
        $this->parent = null;
    }

    /**
     * @return MenuItem[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param MenuItem[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @param MenuItem $child
     */
    public function addChild(MenuItem $child)
    {
        $this->children[] = $child;
    }

    /**
     * @param MenuItem $child
     */
    public function removeChild(MenuItem $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url   = $url;
        $this->route = null;
    }

    /**
     * @return array|null
     */
    public function getRoute()
    {
        return $this->route ? $this->route[0] : null;
    }

    /**
     * @return array|null
     */
    public function getRouteParameters()
    {
        return $this->route ? $this->route[1] : null;
    }

    /**
     * @param string $name
     * @param array  $options
     */
    public function setRoute($name, array $options = [])
    {
        $this->route = [$name, $options];
        $this->url   = null;
    }

    /**
     * @return bool
     */
    public function isRoute()
    {
        return $this->url === null && is_array($this->route);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param string $target
     */
    public function setTarget($target)
    {
        $this->options['target'] = $target == '_self' ? null : $target;
    }

    /**
     * @return string|null
     */
    public function getTarget()
    {
        return $this->options['target'];
    }


    /**
     * @param bool $follow
     */
    public function setFollow($follow)
    {
        $this->options['follow'] = $follow;
    }

    /**
     * @return bool
     */
    public function isFollow()
    {
        return $this->options['follow'];
    }

}
