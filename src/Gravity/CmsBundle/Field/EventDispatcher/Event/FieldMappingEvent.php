<?php


namespace Gravity\CmsBundle\Field\EventDispatcher\Event;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FieldMappingEvent
 *
 * @package Gravity\CmsBundle\Field\EventDispatcher\Event
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldMappingEvent extends Event
{
    /**
     * @var array
     */
    private $mapping;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var FieldDefinitionInterface
     */
    private $fieldDefinition;

    /**
     * @var ClassMetadata
     */
    private $metadata;

    /**
     * @var string
     */
    private $field;

    /**
     * @var array
     */
    private $fieldConfig;

    /**
     * @param EntityManager            $entityManager
     * @param FieldDefinitionInterface $fieldDefinition
     * @param ClassMetadata            $metadata
     * @param string                   $field
     * @param array                    $fieldConfig
     * @param array                    $mapping
     */
    function __construct(
        EntityManager $entityManager,
        FieldDefinitionInterface $fieldDefinition,
        ClassMetadata $metadata,
        $field,
        array $fieldConfig,
        array $mapping
    ) {
        $this->entityManager   = $entityManager;
        $this->fieldDefinition = $fieldDefinition;
        $this->metadata        = $metadata;
        $this->field           = $field;
        $this->fieldConfig    = $fieldConfig;
        $this->mapping         = $mapping;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return FieldDefinitionInterface
     */
    public function getFieldDefinition()
    {
        return $this->fieldDefinition;
    }

    /**
     * @return ClassMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return array
     */
    public function getFieldConfig()
    {
        return $this->fieldConfig;
    }

    /**
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * @param array $mapping
     */
    public function setMapping($mapping)
    {
        $this->mapping = $mapping;
    }

}
