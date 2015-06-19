<?php

namespace AndyThorne\SandboxBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\CmsBundle\Entity\FieldText;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Field\Type\Boolean\BooleanField;

/**
 * Class Page
 *
 * @package AndyThorne\SandboxBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Page extends Node
{
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
     * @var BooleanField[]
     */
    protected $signedOff;

    function __construct()
    {
        $this->urls      = new ArrayCollection();
        $this->signedOff = new ArrayCollection();
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
     * @return \Gravity\CmsBundle\Field\Type\Boolean\BooleanField[]
     */
    public function getSignedOff()
    {
        return $this->signedOff;
    }

    /**
     * @param \Gravity\CmsBundle\Field\Type\Boolean\BooleanField[] $signedOff
     */
    public function setSignedOff($signedOff)
    {
        $this->signedOff = $signedOff;
    }
}
