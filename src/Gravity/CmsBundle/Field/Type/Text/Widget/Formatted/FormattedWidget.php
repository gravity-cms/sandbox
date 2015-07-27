<?php


namespace Gravity\CmsBundle\Field\Type\Text\Widget\Formatted;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Text\TextField;
use Gravity\CmsBundle\Field\Type\Text\Widget\Formatted\Asset\FormattedWidgetAssetLibrary;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FormattedWidget
 *
 * @package Gravity\CmsBundle\Field\Type\Text\Widget\Formatted
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidget extends AbstractFieldWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text.formatted';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Formatted Text Editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'WYSIWYG editor for formatted text';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return 'gravity_field_text_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getAssetLibraries()
    {
        return [
            new FormattedWidgetAssetLibrary(),
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
        return $field->getName() === 'text';
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
                'editor' => 'default'
            ]
        );
    }
}
