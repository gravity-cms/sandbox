<?php

namespace AndyThorne\SandboxBundle\Entity;

use Gravity\CmsBundle\Entity\Node;
use Gravity\MediaBundle\Entity\FieldMedia;

/**
 * Class Page
 *
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Page extends Node
{
    /**
     * @var FieldMedia
     */
    protected $leadImage;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var FieldMedia
     */
    protected $video;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return FieldMedia
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param FieldMedia $video
     */
    public function setVideo(FieldMedia $video)
    {
        $this->video = $video;
    }

    /**
     * @return FieldMedia
     */
    public function getLeadImage()
    {
        return $this->leadImage;
    }

    /**
     * @param FieldMedia $leadImage
     */
    public function setLeadImage(FieldMedia $leadImage)
    {
        $this->leadImage = $leadImage;
    }
}
