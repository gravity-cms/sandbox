<?php


namespace Gravity\CmsBundle\Field\Type\Reference\EventDispatcher;

use Gravity\CmsBundle\Field\EventDispatcher\Event\FieldMappingEvent;
use Gravity\CmsBundle\Field\EventDispatcher\Events;
use Gravity\CmsBundle\Field\Type\Reference\ReferenceField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ReferenceFieldEventMappingSubscriber
 *
 * @package Gravity\CmsBundle\Field\Type\Reference\EventDispatcher
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ReferenceFieldEventMappingSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::FIELD_MAPPING => 'referenceFieldMapping',
        ];
    }

    /**
     * Modify the event mapping
     *
     * @param FieldMappingEvent $event
     */
    public function referenceFieldMapping(FieldMappingEvent $event)
    {
        $fieldDefinition = $event->getFieldDefinition();

        if ($fieldDefinition instanceof ReferenceField) {
            $mapping      = $event->getMapping();
            $fieldOptions = $event->getFieldConfig();

            if(!$fieldDefinition->getEntityClass()) {
                $mapping['targetEntity'] = $fieldOptions['options']['entity'];
                $mapping['orderBy']      = [];
            }

            $event->setMapping($mapping);
        }
    }
}
