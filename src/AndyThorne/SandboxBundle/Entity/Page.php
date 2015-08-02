<?php

namespace AndyThorne\SandboxBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\CmsBundle\Entity\FieldBoolean;
use Gravity\CmsBundle\Entity\FieldText;
use Gravity\CmsBundle\Entity\Node;
use Gravity\MediaBundle\Entity\FieldMedia;
use Gravity\TagBundle\Entity\Tag;

/**
 * Class Page
 *
 * @package AndyThorne\SandboxBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Page extends Node
{
    /**
     * @var Tag
     */
    protected $category;

    /**
     * @var Tag[]
     */
    protected $tags;

    /**
     * @var FieldMedia
     */
    protected $leadImage;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var FieldText[]
     */
    protected $urls;
    /**
     * @var int
     */
    protected $rating;

    /**
     * @var array
     */
    protected $team;

    /**
     * @var FieldBoolean
     */
    protected $signedOff;

    /**
     * @var Page
     */
    protected $parent;

    function __construct()
    {
        parent::__construct();
        $this->urls = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return Tag
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Tag $category
     */
    public function setCategory(Tag $category)
    {
        $this->category = $category;
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
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return array
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param array $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return \Gravity\CmsBundle\Entity\FieldText[]
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param FieldText $url
     */
    public function addUrl(FieldText $url)
    {
        $this->urls[] = $url;
    }

    /**
     * @param FieldText $url
     */
    public function removeUrl(FieldText $url)
    {
        $this->urls->removeElement($url);
    }

    /**
     * @return FieldBoolean
     */
    public function getSignedOff()
    {
        return $this->signedOff;
    }

    /**
     * @param FieldBoolean $signedOff
     */
    public function setSignedOff(FieldBoolean $signedOff)
    {
        $this->signedOff = $signedOff;
    }

    /**
     * @return Page
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Page $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
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
