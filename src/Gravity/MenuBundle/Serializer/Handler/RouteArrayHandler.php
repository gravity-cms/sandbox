<?php


namespace Gravity\MenuBundle\Serializer\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouteArrayHandler
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class RouteArrayHandler implements SubscribingHandlerInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * RouteArrayHandler constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format'    => 'json',
                'type'      => 'route_array',
                'method'    => 'serializeRouteArrayToJson'
            ]
        ];
    }

    public function serializeRouteArrayToJson(
        JsonSerializationVisitor $visitor,
        array $route,
        array $type,
        Context $context
    ) {
        if (is_array($route)) {
            list($routeName, $routeParameters) = $route;

            return $this->router->generate($routeName, $routeParameters);
        }
    }
}
