<?php


namespace Gravity\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGalleryHasMedia;

/**
 * Class GalleryHasMedia
 *
 * @package Gravity\MediaBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GalleryHasMedia extends BaseGalleryHasMedia
{
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
