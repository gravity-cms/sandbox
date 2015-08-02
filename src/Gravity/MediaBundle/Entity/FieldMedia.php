<?php


namespace Gravity\MediaBundle\Entity;

use Gravity\CmsBundle\Entity\Field;

/**
 * Class FieldMedia
 *
 * @package Gravity\MediaBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldMedia extends Field
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alt;

    /**
     * @var Media
     */
    protected $media;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param Media $media
     */
    public function setMedia(Media $media)
    {
        $this->media = $media;
    }
}
