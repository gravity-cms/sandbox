<?php


namespace Gravity\CmsBundle\Routing;

use Symfony\Component\Routing\RouteCompiler;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class NodeRouteManager
 *
 * @package Gravity\CmsBundle\Routing
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeRouteManager
{
    /**
     * @var array
     */
    protected $nodeMappings;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter()
    {
        return $this->router;
    }

    public function getRoute($name)
    {
        $route = $this->router->match($name);

        $compiler = new RouteCompiler();

        return $compiler->compile($route);
    }

    /**
     * @return array
     */
    public function getNodeMappings()
    {
        return $this->nodeMappings;
    }

    /**
     * @param array $nodeMappings
     */
    public function setNodeMappings($nodeMappings)
    {
        foreach ($nodeMappings as $class => $nodeMapping) {
            $this->addNodeMapping($class, $nodeMapping);
        }
    }

    /**
     * @param $class
     * @param $mapping
     */
    public function addNodeMapping($class, $mapping)
    {
        $this->nodeMappings[$class] = $mapping;
    }

    /**
     * @param $class
     *
     * @return mixed
     */
    public function getNodeMapping($class)
    {
        return $this->nodeMappings[$class];
    }
}
