<?php


namespace Gravity\MediaBundle\Field\Type\Reference\Widget\GravityMedia;

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
    public function getForm()
    {
        return 'gravity_media_type';
    }

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
}
