<?php
/**
 * Copyright (c) 2016 Gravity CMS.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace AndyThorne\SandboxBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\CmsBundle\Entity\FieldBoolean;
use Gravity\CmsBundle\Entity\FieldText;
use Gravity\CmsBundle\Entity\Node;
use Gravity\MediaBundle\Entity\FieldMedia;
use Gravity\TagBundle\Entity\Tag;

/**
 * Class BlogPost
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class BlogPost extends Node
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
     * @var FieldMedia
     */
    protected $video;

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

    /**
     * @var FieldMedia[]
     */
    protected $galleryImages;

    function __construct()
    {
        parent::__construct();

        $this->urls = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->galleryImages = new ArrayCollection();
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

    /**
     * @return FieldMedia[]
     */
    public function getGalleryImages()
    {
        return $this->galleryImages;
    }

    /**
     * @param FieldMedia $galleryImage
     */
    public function addGalleryImage(FieldMedia $galleryImage)
    {
        $this->galleryImages[] = $galleryImage;
    }

    /**
     * @param FieldMedia $galleryImage
     */
    public function removeGalleryImage(FieldMedia $galleryImage)
    {
        $this->galleryImages->removeElement($galleryImage);
    }
}