<?php

namespace Gravity\CmsBundle\Field\Type\Boolean\Widget\Checkbox;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Boolean\BooleanField;
use Symfony\Component\Form\AbstractType;

/**
 * Class CheckboxWidget
 *
 * @package Gravity\CmsBundle\Field\Type\Boolean\Widget\Checkbox
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CheckboxWidget extends AbstractFieldWidgetDefinition
{
    /**
     * Get the identifier name of the field widget. This must be a unique name and contain only alphanumeric,
     * underscores (_) and period (.) characters in the format field.widget.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'boolean.checkbox';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Checkbox';
    }

    /**
     * Get the description of the field widget
     *
     * @return string
     */
    public function getDescription()
    {
        return 'A HTML checkbox for a boolean field';
    }

    /**
     * Get the form type for this widget
     *
     * @return AbstractType
     */
    public function getForm()
    {
        return new CheckboxWidgetForm();
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
        return $field instanceof BooleanField;
    }

}
