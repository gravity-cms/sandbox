<?php

namespace Gravity\CmsBundle\Field\Type\Boolean;

use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BooleanField
 *
 * @package Gravity\CmsBundle\Field\Type\Boolean
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class BooleanField implements FieldDefinitionInterface
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'boolean';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'A boolean field';
    }

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription()
    {
        return 'A field that will either equate to true or false';
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\CmsBundle\Entity\FieldBoolean';
    }

    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
    }

    /**
     * Return an array of constraints to be applied in each widget
     *
     * @param string $field
     * @param array  $options
     *
     * @return \Symfony\Component\Validator\Constraint[]
     */
    public function getConstraints($field, array $options)
    {
        return [];
    }

}
