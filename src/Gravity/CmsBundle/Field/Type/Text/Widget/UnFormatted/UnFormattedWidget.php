<?php

namespace Gravity\CmsBundle\Field\Type\Text\Widget\UnFormatted;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UnFormattedWidget
 *
 * @package Gravity\CoreBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class UnFormattedWidget extends AbstractFieldWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text.unformatted';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'UnFormatted Text Editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Unformatted text box';
    }

    public function getForm()
    {
        return new UnFormattedWidgetForm();
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
        return ($field->getName() === 'text');
    }

    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'type'      => 'text',
                'multiline' => false,
            ]
        );
    }

}
