<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia;

use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\MediaBundle\Field\Type\Reference\Widget\SonataMedia\SonataMediaWidget;

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
        return [
            'class' => $fieldOptions['entity'],
            'label' => $field,
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
