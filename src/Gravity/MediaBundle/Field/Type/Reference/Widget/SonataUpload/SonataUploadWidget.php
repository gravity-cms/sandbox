<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Widget\SonataUpload;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Reference\ReferenceField;
use Gravity\MediaBundle\Field\Type\Media\MediaField;
use Symfony\Component\Form\AbstractType;

/**
 * Class SonataUploadWidget
 *
 * @package Gravity\MediaBundle\Field\Type\Media\Widget\SonataUpload
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SonataUploadWidget extends AbstractFieldWidgetDefinition
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
        return 'sonata.upload';
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
        return $field instanceof ReferenceField;
    }

}
