<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Widget\SonataMedia;

use Gravity\CmsBundle\Field\AbstractFieldWidgetDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\MediaBundle\Field\Type\Reference\MediaField;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
    public function getForm()
    {
        return new SonataMediaWidgetForm();
//        return 'sonata_media_type';
    }

//    /**
//     * @inheritDoc
//     */
//    protected function getFormOptions(
//        FieldDefinitionInterface $fieldDefinition,
//        $field,
//        array $fieldOptions,
//        $widget,
//        array $widgetOptions
//    ) {
//        return [
//            'provider' => $fieldOptions['provider'],
//            'context'  => 'default'
//        ];
//    }

    /**
     * @inheritDoc
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'provider' => null,
            ]
        );
    }


    /**
     * @inheritDoc
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof MediaField;
    }

}
