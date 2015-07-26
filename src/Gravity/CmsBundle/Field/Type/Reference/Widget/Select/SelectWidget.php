<?php

namespace Gravity\CmsBundle\Field\Type\Reference\Widget\Select;

use Gravity\CmsBundle\Entity\FieldChoice;
use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Reference\ReferenceField;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SelectWidget
 *
 * @package Gravity\CmsBundle\Field\Type\Reference\Widget\Select
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SelectWidget extends AbstractFieldWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'select';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Dropdown Box';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Entity Using a Dropdown Box';
    }

    /**
     * Get the form type for the widget
     *
     * @return AbstractType|string
     */
    public function getForm()
    {
        return new SelectWidgetForm();
    }

    /**
     * Set the field options to be passed to the form
     *
     * @param FieldDefinitionInterface $fieldDefinition
     * @param string                   $field
     * @param array                    $fieldOptions
     * @param string                   $widget
     * @param array                    $widgetOptions
     *
     * @return array
     */
    protected function getFormOptions(
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $fieldOptions,
        $widget,
        array $widgetOptions
    ) {
        return [
            'class'    => $fieldOptions['entity'],
            'multiple' => false,
            'expanded' => $widgetOptions['expanded'],
        ];
    }

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldDefinitionInterface $field
     *
     * @return string
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return ($field instanceof ReferenceField);
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'expanded' => false
            ]
        );
    }
}
