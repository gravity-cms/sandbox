<?php


namespace Gravity\CmsBundle\Routing;

use Cocur\Slugify\SlugifyInterface;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Field\FieldManager;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteBuilder
 *
 * @package Gravity\CmsBundle\Routing
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RouteBuilder
{
    /**
     * @var NodeRouteManager
     */
    protected $nodeRouteManager;

    /**
     * @var SlugifyInterface
     */
    protected $slugger;

    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @param NodeRouteManager $nodeRouteManager
     * @param SlugifyInterface $slugify
     * @param FieldManager     $fieldManager
     */
    function __construct(NodeRouteManager $nodeRouteManager, SlugifyInterface $slugify, FieldManager $fieldManager)
    {
        $this->nodeRouteManager = $nodeRouteManager;
        $this->slugger          = $slugify;
        $this->fieldManager     = $fieldManager;
    }

    /**
     * @return SlugifyInterface
     */
    public function getSlugger()
    {
        return $this->slugger;
    }

    /**
     * Slugify an unclean path into a safe path
     *
     * @param string $path
     *
     * @param int    $version
     *
     * @return string
     */
    public function slugify($path, $version = 0)
    {
        $sluggedPaths = [];
        $parts        = explode('/', trim($path, '/'));
        $partsCount   = count($parts) - 1;

        foreach ($parts as $i => $part) {
            if ($version > 0 && $partsCount == $i) {
                $part .= " {$version}";
            }
            $sluggedPaths[] = $this->slugger->slugify($part);
        }

        return '/' . implode('/', $sluggedPaths);
    }

    /**
     * @param Node $node
     * @param bool $nonConflict
     *
     * @return Route
     */
    public function build(Node $node, $nonConflict = true)
    {
        $class        = get_class($node);
        $routeMapping = $this->nodeRouteManager->getNodeMapping($class);
        $router       = $this->nodeRouteManager->getRouter();
        $i            = 0;
        $path         = null;
        $fullPath     = $node->getPath();

        $route = new Route();
        $route->setVariablePattern("");

        if ($fullPath) {
            $urlVars = [];
            $route->setStaticPrefix($fullPath);
        } else {
            $route->setStaticPrefix($routeMapping['path']);
            $compiledRoute = $route->compile();
            $urlVars       = $compiledRoute->getPathVariables();
        }

        $routeName = 'node_route';
        $route->setName($routeName);

        $routeCollection = new RouteCollection();
        $routeCollection->add($routeName, $route);
        $urlGenerator = new UrlGenerator($routeCollection, new RequestContext(''));

        $urlVarCount = count($urlVars) - 1;

        while (true) {
            $params = [];
            foreach ($urlVars as $vi => $var) {
                $method = new \ReflectionMethod($class, "get{$var}");
                $value  = (string) $method->invoke($node);
                //
                if ($i > 0 && $urlVarCount == $vi) {
                    $value .= " {$i}";
                }

                $params[$var] = $this->slugger->slugify($value);
            }

            if ($fullPath) {
                $path = $this->slugify($fullPath, $i);
            } else {
                $path = $urlGenerator->generate($routeName, $params);
            }

            // if we don't care about conflicts, skip
            if(!$nonConflict){
                break;
            }

            ++$i;

            try {
                $match = $router->match($path);

                // if we've fallen back to the original route, stop searching for an existing route, or if we've found
                // the node's route
                if (isset($match['nodeId'])) {
                    if ($match['nodeId'] != $node->getId()) {
                        continue;
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
            catch (ResourceNotFoundException $e) {
                break;
            }
        }

        $route = new Route();
        $route->setDefaults(
            [
                '_format'     => 'html',
                '_controller' => 'Gravity\CmsBundle\Controller\NodeController::viewAction',
                'nodeId'      => $node->getId(),
                'type'        => $class,
            ]
        );
        $route->setOptions([
            'add_format_pattern' => true
        ]);
        $route->setName($this->buildRouteName($path));
        $route->setStaticPrefix($path);
        $route->setPath($path);

        $node->setPath($path);

        return $route;
    }

    public function buildRouteName($path)
    {
        $newPathName = str_replace(['/', '-', '.'], '_', trim($path, '/'));

        return 'gravity_node_' . $newPathName;
    }

    public function buildPath()
    {

    }
}
