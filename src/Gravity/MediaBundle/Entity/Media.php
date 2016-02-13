<?php


namespace Gravity\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia;

/**
 * Class Media
 *
 * @package Gravity\MediaBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Media extends BaseMedia
{
    /**
     * @var int
     *
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var float
     */
    protected $length;

    /**
     * @var string
     */
    protected $copyright;

    /**
     * @var string
     */
    protected $authorName;

    /**
     * @var string
     *
     * TODO: this is a hack as you cannot set the context api the sonata media api
     */
    protected $context = 'default';

    /**
     * @var int
     */
    protected $cdnStatus;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $binaryContent;

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var int
     */
    protected $size;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
