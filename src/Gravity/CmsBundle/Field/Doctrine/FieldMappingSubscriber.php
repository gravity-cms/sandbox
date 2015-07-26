<?php


namespace Gravity\CmsBundle\Field\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Gravity\CmsBundle\Field\EventDispatcher\Event\FieldMappingEvent;
use Gravity\CmsBundle\Field\EventDispatcher\Events as GravityEvents;
use Gravity\CmsBundle\Field\FieldManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class FieldMappingSubscriber
 *
 * @package Gravity\CmsBundle\Field\Doctrine
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldMappingSubscriber implements EventSubscriber
{
    /**
     * @var array
     */
    protected $entityMappings;

    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @var string
     */
    protected $userEntity;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param FieldManager             $fieldManager
     * @param array                    $entityMappings
     * @param string                   $userEntity
     */
    function __construct(
        EventDispatcherInterface $eventDispatcher,
        FieldManager $fieldManager,
        array $entityMappings,
        $userEntity
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->fieldManager    = $fieldManager;
        $this->entityMappings  = $entityMappings;
        $this->userEntity      = $userEntity;
    }


    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        // the $metadata is the whole mapping info for this class
        /** @var \Doctrine\ORM\Mapping\ClassMetadata $metadata */
        $metadata = $eventArgs->getClassMetadata();
        $reflection = $metadata->getReflectionClass();

        if (!isset($this->entityMappings[$metadata->getName()])) {
            return;
        }

        // map all the user fields automatically if they aren't defined
        if (!$metadata->hasAssociation('createdBy')) {
            $metadata->mapManyToOne(
                [
                    'fieldName'    => 'createdBy',
                    'targetEntity' => $this->userEntity,
                ]
            );
        }

        if (!$metadata->hasAssociation('editedBy')) {
            $metadata->mapManyToOne(
                [
                    'fieldName'    => 'editedBy',
                    'targetEntity' => $this->userEntity,
                ]
            );
        }

        if (!$metadata->hasAssociation('deletedBy')) {
            $metadata->mapManyToOne(
                [
                    'fieldName'    => 'deletedBy',
                    'targetEntity' => $this->userEntity,
                ]
            );
        }

        $entityManager  = $eventArgs->getEntityManager();
        $namingStrategy = $entityManager
            ->getConfiguration()
            ->getNamingStrategy();

        foreach ($this->entityMappings[$metadata->getName()] as $field => $fieldConfig) {
            $fieldDefinition = $this->fieldManager->getFieldDefinition($fieldConfig['type']);

            if ($fieldConfig['dynamic']) {
                if($fieldConfig['options']['limit'] > 1) {
                    $mapping = [
                        'targetEntity' => $fieldDefinition->getEntityClass(),
                        'fieldName'    => $field,
                        'cascade'      => ['persist'],
                        'joinTable'    => [
                            'name' => strtolower($namingStrategy->classToTableName($metadata->getName())) . '_field_' .
                                      $namingStrategy->propertyToColumnName($field),
                        ],
                        'orderBy'      => [
                            'delta' => 'ASC',
                        ],
                        'unique'       => false,
                    ];
                } else {
                    $mapping = [
                        'targetEntity' => $fieldDefinition->getEntityClass(),
                        'fieldName'    => $field,
                        'cascade'      => ['persist'],
                        'unique'       => false,
                    ];
                }

                $event = new FieldMappingEvent(
                    $entityManager,
                    $fieldDefinition,
                    $metadata,
                    $field,
                    $fieldConfig,
                    $mapping
                );
                $this->eventDispatcher->dispatch(GravityEvents::FIELD_MAPPING, $event);

                if($fieldConfig['options']['limit'] > 1) {
                    $metadata->mapManyToMany($event->getMapping());
                } else {
                    $metadata->mapManyToOne($event->getMapping());
                }
            }
        }
    }
}
