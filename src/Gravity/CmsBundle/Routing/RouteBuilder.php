<?php


namespace Gravity\CmsBundle\Routing;

use Cocur\Slugify\SlugifyInterface;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Field\FieldManager;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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
            if($version > 0 && $partsCount == $i){
                $part .= " {$version}";
            }
            $sluggedPaths[] = $this->slugger->slugify($part);
        }

        return '/' . implode('/', $sluggedPaths);
    }

    /**
     * @param Node $node
     *
     * @return string
     */
    public function build(Node $node)
    {
        $class        = get_class($node);
        $routeMapping = $this->nodeRouteManager->getNodeMapping($class);
        $router       = $this->nodeRouteManager->getRouter();
        $i            = 0;
        $path         = null;
        $customPath = $node->getCustomPath();

        if ($customPath) {
            $urlVars = [];
        } else {
            $route   = $this->nodeRouteManager->getRoute($routeMapping['route']);
            $urlVars = $route->getPathVariables();
        }

        $urlVarCount = count($urlVars) - 1;

        while (true) {
            $params = [];
            foreach ($urlVars as $vi => $var) {
                $method = new \ReflectionMethod($class, "get{$var}");
                $value  = $method->invoke($node);
                //
                if ($i > 0 && $urlVarCount == $vi) {
                    $value .= " {$i}";
                }

                $params[$var] = $this->slugger->slugify($value);
            }

            // [HACK] fix the context in dev mode
            // @see http://stackoverflow.com/questions/21758545/symfony-generate-prod-url-in-dev-environment
            if ($customPath) {
                $path = $this->slugify($customPath, $i);
            } else {
                $base = $router->getContext()->getBaseUrl();

                $router->getContext()->setBaseUrl('');
                $path = $router->generate($routeMapping['route'], $params);
                $router->getContext()->setBaseUrl($base);
            }

            ++$i;

            try {
                $match = $router->match($path);

                // if we've fallen back to the original route, stop searching for an existing route, or if we've found
                // the node's route
                if (isset($match['node'])) {
                    if ($match['node'] != $node->getId()) {
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

        if($customPath && $customPath !== $path) {
            $node->setCustomPath($path);
        }

        return $path;
    }
}
