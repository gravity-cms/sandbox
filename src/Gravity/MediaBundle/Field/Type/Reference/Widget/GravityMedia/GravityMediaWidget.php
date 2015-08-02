<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia;

use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\MediaBundle\Field\Type\Reference\Widget\SonataMedia\SonataMediaWidget;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GravityMediaWidget
 *
 * @package Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GravityMediaWidget extends SonataMediaWidget
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'gravity.media';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Upload Form';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return 'Upload a file';
    }

    /**
     * @inheritDoc
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefault('image_preview', 'admin');
    }

    /**
     * @inheritDoc
     */
    public function getForm()
    {
        return new GravityMediaWidgetForm();
    }

    /**
     * @inheritDoc
     */
    protected function getFormOptions(
        FieldDefinitionInterface $fieldDefinition,
        $field,
        array $fieldOptions,
        $widget,
        array $widgetOptions
    ) {
        return parent::getFormOptions($fieldDefinition, $field, $fieldOptions, $widget, $widgetOptions) + [
            'field'          => $fieldDefinition,
            'field_options'  => $fieldOptions,
            'widget_options' => $widgetOptions,
            'data_class'     => $fieldDefinition->getEntityClass(),
        ];
    }


    /**
     * @inheritDoc
     */
    public function getAssetLibraries()
    {
        return [
            new GravityMediaWidgetAssetLibrary(),
        ];
    }


}
