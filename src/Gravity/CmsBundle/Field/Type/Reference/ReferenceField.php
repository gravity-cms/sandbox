<?php


namespace Gravity\CmsBundle\Field\Type\Reference;

use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ReferenceField
 *
 * @package Gravity\CmsBundle\Field\Type\Reference
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ReferenceField implements FieldDefinitionInterface
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'reference';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Reference an entity';
    }

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Create a link between to an entity by reference';
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return null;
    }

    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setRequired(
            [
                'entity',
            ]
        );

        $optionsResolver->setDefaults(
            [
                'property' => null,
            ]
        );

        $optionsResolver->setAllowedTypes('entity', 'string');
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
        // TODO: Implement getConstraints() method.
    }

}
