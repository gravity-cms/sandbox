<?php


namespace Gravity\MediaBundle\Field\Type\Reference;

use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Reference\ReferenceField;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MediaField
 *
 * @package Gravity\MediaBundle\Field\Type\Media
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MediaField extends ReferenceField
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'media';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Media';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return 'A media reference';
    }

    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return 'Gravity\MediaBundle\Entity\FieldMedia';
    }

    /**
     * @inheritDoc
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        parent::setOptions($optionsResolver);

        $optionsResolver->setRequired(['provider']);
        $optionsResolver->setDefault('provider_context', 'default');
    }
}
