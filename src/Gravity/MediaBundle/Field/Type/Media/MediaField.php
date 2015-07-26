<?php


namespace Gravity\MediaBundle\Field\Type\Media;

use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MediaField
 *
 * @package Gravity\MediaBundle\Field\Type\Media
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MediaField implements FieldDefinitionInterface
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
        // TODO: Implement getEntityClass() method.
    }

    /**
     * @inheritDoc
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        // TODO: Implement setOptions() method.
    }

    /**
     * @inheritDoc
     */
    public function getConstraints($field, array $options)
    {
        // TODO: Implement getConstraints() method.
    }

}
