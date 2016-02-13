<?php


namespace Gravity\MediaBundle\Serializer\EventDispatcher;

use Gravity\CmsBundle\Serializer\NodeExclusionStrategy;
use Gravity\MediaBundle\Entity\Media;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Sonata\MediaBundle\Provider\Pool;

/**
 * Class MediaEventSubscriber
 *
 * @package Gravity\MediaBundle\Serializer\EventDispatcher
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MediaEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var Pool
     */
    protected $mediaPool;

    /**
     * MediaEventSubscriber constructor.
     *
     * @param Pool $mediaPool
     */
    public function __construct(Pool $mediaPool)
    {
        $this->mediaPool = $mediaPool;
    }


    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::POST_SERIALIZE, 'method' => 'onPostSerialize'
            ],
        ];
    }

    /**
     * Serialize images styles if the provider is an image type
     *
     * @param ObjectEvent $event
     */
    public function onPostSerialize(ObjectEvent $event)
    {
        $visitor = $event->getVisitor();
        $object  = $event->getObject();
        $context = $event->getContext();
        if ($object instanceof Media) {
            $styles = [];

            $provider = $this->mediaPool->getProvider($object->getProviderName());
            $formats = $this->mediaPool->getFormatNamesByContext($object->getContext());
            if(is_array($formats)) {
                foreach ($formats as $formatName => $format) {
                    $styles[$formatName] = $provider->generatePublicUrl($object, $formatName);
                }
            }

            $visitor->addData('src',    $provider->generatePublicUrl($object, 'reference'));
            $visitor->addData('styles', $styles);
        }
    }
}
