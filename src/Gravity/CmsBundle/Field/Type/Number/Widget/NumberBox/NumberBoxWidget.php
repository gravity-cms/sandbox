<?php

namespace Gravity\CmsBundle\Field\Type\Number\Widget\NumberBox;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NumberBoxWidget
 *
 * @package Gravity\CmsBundle\Field\Type\Number\Widget\NumberBox
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NumberBoxWidget extends AbstractFieldWidgetDefinition
{
    /**
     * Get the identifier name of the field widget. This must be a unique name and contain only alphanumeric,
     * underscores (_) and period (.) characters in the format field.widget.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'number.number_box';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Number Box';
    }

    /**
     * Get the description of the field widget
     *
     * @return string
     */
    public function getDescription()
    {
        return 'A numeric input box';
    }

    /**
     * Get the form type for the widget
     *
     * @return AbstractType|string
     */
    public function getForm()
    {
        return new NumberBoxWidgetForm();
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
        return $field->getName() === 'number';
    }

    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'step' => 1,
                'min'  => null,
                'max'  => null,
            ]
        );
    }

}
