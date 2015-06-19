<?php


namespace Gravity\CmsBundle\Field;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FieldManager
 *
 * @package Gravity\CmsBundle\Field
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldManager
{
    /**
     * @var FieldDefinitionInterface[]
     */
    protected $fieldDefinitions = [];

    /**
     * @var FieldWidgetDefinitionInterface[]
     */
    protected $fieldWidgetDefinitions = [];

    /**
     * @var array
     */
    protected $entityFieldMappings = [];

    /**
     * @return FieldDefinitionInterface[]
     */
    public function getFieldDefinitions()
    {
        return $this->fieldDefinitions;
    }

    /**
     * @param string $type
     *
     * @return FieldDefinitionInterface
     */
    public function getFieldDefinition($type)
    {
        return $this->fieldDefinitions[$type];
    }

    /**
     * @param array $fieldDefinitions
     */
    public function setFieldDefinitions($fieldDefinitions)
    {
        $this->fieldDefinitions = $fieldDefinitions;
    }

    /**
     * @param FieldDefinitionInterface $fieldDefinition
     */
    public function addFieldDefinition(FieldDefinitionInterface $fieldDefinition)
    {
        $this->fieldDefinitions[$fieldDefinition->getName()] = $fieldDefinition;
    }

    /**
     * @return FieldWidgetDefinitionInterface[]
     */
    public function getFieldWidgetDefinitions()
    {
        return $this->fieldWidgetDefinitions;
    }

    /**
     * @param string $name
     *
     * @return FieldWidgetDefinitionInterface
     */
    public function getFieldWidgetDefinition($name)
    {
        return $this->fieldWidgetDefinitions[$name];
    }

    /**
     * @param FieldWidgetDefinitionInterface[] $fieldWidgetDefinitions
     */
    public function setFieldWidgetDefinitions($fieldWidgetDefinitions)
    {
        $this->fieldWidgetDefinitions = $fieldWidgetDefinitions;
    }

    /**
     * @param FieldWidgetDefinitionInterface $fieldWidgetDefinition
     */
    public function addFieldWidgetDefinition(FieldWidgetDefinitionInterface $fieldWidgetDefinition)
    {
        $this->fieldWidgetDefinitions[$fieldWidgetDefinition->getName()] = $fieldWidgetDefinition;
    }

    /**
     * @return array
     */
    public function getEntityFieldMappings()
    {
        return $this->entityFieldMappings;
    }

    /**
     * @param $class
     *
     * @return array
     */
    public function getEntityFieldMapping($class)
    {
        return $this->entityFieldMappings[$class];
    }

    /**
     * @param array $entityFieldMappings
     */
    public function setEntityFieldMappings(array $entityFieldMappings)
    {
        $this->entityFieldMappings = $entityFieldMappings;
    }

    /**
     * Get an options resolver for all fields
     *
     * @return OptionsResolver
     *
     * @deprecated
     */
    public function createFieldOptionsResolver()
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(
            [
                'limit' => -1,
                'required' => false,
                'label' => null,
            ]
        );

        return $resolver;
    }

    /**
     * Get an options resolver for all fields widgets
     *
     * @return OptionsResolver
     *
     * @deprecated
     */
    public function createFieldWidgetOptionsResolver()
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(
            [
                'default' => null,
            ]
        );

        return $resolver;
    }

}
