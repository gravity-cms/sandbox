<?php


namespace Gravity\CmsBundle\Routing\Type;

/**
 * Class RouteTypePool
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class RouteTypePool
{
    /**
     * @var RouteTypeInterface[]
     */
    protected $routeTypes = [];

    /**
     * @return RouteTypeInterface[]
     */
    public function getRouteTypes()
    {
        return $this->routeTypes;
    }

    /**
     * @param string $type
     *
     * @return RouteTypeInterface
     */
    public function getRouteType($type)
    {
        return $this->routeTypes[$type];
    }

    /**
     * @param RouteTypeInterface[] $routeTypes
     */
    public function setRouteTypes($routeTypes)
    {
        $this->routeTypes = $routeTypes;
    }

    /**
     * @param string             $name
     * @param RouteTypeInterface $routeType
     */
    public function addRouteType($name, RouteTypeInterface $routeType)
    {
        $this->routeTypes[$name] = $routeType;
    }

}
