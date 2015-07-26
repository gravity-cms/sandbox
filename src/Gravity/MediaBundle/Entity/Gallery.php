<?php


namespace Gravity\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGallery;

/**
 * Class Gallery
 *
 * @package Gravity\MediaBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Gallery extends BaseGallery
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
