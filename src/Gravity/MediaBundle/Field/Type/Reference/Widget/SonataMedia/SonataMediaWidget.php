<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Widget\SonataMedia;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\MediaBundle\Field\Type\Reference\MediaField;

/**
 * Class SonataMediaWidget
 *
 * @package Gravity\MediaBundle\Field\Type\Reference\Widget\SonataMedia
 * @author  Andy Thorne <contrabandvr@gmail.com>s
 */
class SonataMediaWidget extends AbstractFieldWidgetDefinition
{
    /**
     * @inheritDoc
     */
    public function getForm()
    {
        return 'sonata_media_type';
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
            'provider' => 'sonata.media.provider.image',
            'context'  => 'default'
        ];
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'sonata.media';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Sonata Upload';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return 'Media via default Sonata Form';
    }

    /**
     * @inheritDoc
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof MediaField;
    }

}
