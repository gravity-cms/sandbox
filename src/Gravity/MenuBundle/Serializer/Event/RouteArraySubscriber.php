<?php


namespace Gravity\MenuBundle\Serializer\Event;

use Gravity\MenuBundle\Entity\MenuItem;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouteArraySubscriber
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class RouteArraySubscriber implements EventSubscriberInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * RouteArraySubscriber constructor.
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
    public static function getSubscribedEvents()
    {
        return [
            ['event' => 'serializer.post_serialize', 'method' => 'onPostSerialize'],
        ];
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        $menu    = $event->getObject();
        $visitor = $event->getVisitor();
        if ($menu instanceof MenuItem) {
            if ($menu->isRoute()) {
                $visitor->addData(
                    'url',
                    $this->router->generate(
                        $menu->getRoute(),
                        $menu->getRouteParameters()
                    ),
                    RouterInterface::ABSOLUTE_URL
                );
            } else {
                $visitor->addData('url', $menu->getUrl());
            }
        }
    }
}
