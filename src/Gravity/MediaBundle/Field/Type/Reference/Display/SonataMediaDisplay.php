<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Display;

use Gravity\CmsBundle\Display\Type\AbstractDisplayDefinition;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\MediaBundle\Field\Type\Reference\MediaField;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SonataMediaDisplay
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class SonataMediaDisplay extends AbstractDisplayDefinition
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'media.sonata';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Sonata Media';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return 'Use the Sonata Media Provider to render the correct media type';
    }

    /**
     * @inheritDoc
     */
    public function getTemplate()
    {
        return 'GravityMediaBundle:Field/Display:sonata-media.html.twig';
    }

    /**
     * @inheritDoc
     */
    public function getTemplateOptions($entity, array $options)
    {
        return [
            'image'         => $entity->getMedia(),
            'image_style'   => $options['image_style'],
            'media_options' => [
                'title' => $entity->getTitle(),
                'alt'   => $entity->getAlt(),
                'class' => 'img-polaroid media-object',
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function setOptions(OptionsResolver $optionsResolver, array $options = [])
    {
        $optionsResolver->setRequired('image_style');
    }


    /**
     * @inheritDoc
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof MediaField;
    }

}
