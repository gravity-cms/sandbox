<?php


namespace Gravity\CmsBundle\Field\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Gravity\CmsBundle\Field\FieldManager;

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
     * @param FieldManager $fieldManager
     * @param array        $entityMappings
     */
    function __construct(FieldManager $fieldManager, array $entityMappings, $userEntity)
    {
        $this->fieldManager   = $fieldManager;
        $this->entityMappings = $entityMappings;
        $this->userEntity     = $userEntity;
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

            $optionsResolver = $this->fieldManager->createFieldOptionsResolver();
            $fieldDefinition->setOptions($optionsResolver, $fieldConfig['options']);
            $resolvedOptions = $optionsResolver->resolve($fieldConfig['options']);

            if ($fieldConfig['dynamic']) {
                $metadata->mapManyToMany(
                    [
                        'targetEntity' => $fieldDefinition->getEntityClass(),
                        'inversedBy'   => 'entity',
                        'fieldName'    => $field,
                        'cascade'      => ['persist'],
                        'joinTable'    => [
                            'name' => strtolower($namingStrategy->classToTableName($metadata->getName())) . '_field_' .
                                      $namingStrategy->propertyToColumnName($field),
                        ],
                        'orderBy' => [
                            'delta' => 'ASC',
                        ],
                    ]
                );
            }
        }

//        $namingStrategy = $entityManager
//            ->getConfiguration()
//            ->getNamingStrategy();
//        $metadata->mapManyToMany(
//            [
//                'targetEntity' => UploadedDocument::CLASS,
//                'fieldName'    => 'uploadedDocuments',
//                'cascade'      => ['persist'],
//                'joinTable'    => [
//                    'name'               => strtolower($namingStrategy->classToTableName($metadata->getName())) .
//                                            '_document',
//                    'joinColumns'        => [
//                        [
//                            'name'                 => $namingStrategy->joinKeyColumnName($metadata->getName()),
//                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
//                            'onDelete'             => 'CASCADE',
//                            'onUpdate'             => 'CASCADE',
//                        ],
//                    ],
//                    'inverseJoinColumns' => [
//                        [
//                            'name'                 => 'document_id',
//                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
//                            'onDelete'             => 'CASCADE',
//                            'onUpdate'             => 'CASCADE',
//                        ],
//                    ]
//                ]
//            ]
//        );
    }
}
