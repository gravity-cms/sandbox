<?php


namespace Gravity\CmsBundle\Entity;

use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Node
 *
 * @package Gravity\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Node extends FieldableEntity
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $published = true;

    /**
     * @var \DateTime|null
     */
    protected $publishedFrom;

    /**
     * @var \DateTime|null
     */
    protected $publishedTo;

    /**
     * @var UserInterface
     */
    protected $publishedBy;

    /**
     * @var Route
     */
    protected $route;

    function __construct()
    {
        $this->createdOn = new \DateTime();
    }

    function __toString()
    {
        return $this->title;
    }

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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return \DateTime|null
     */
    public function getPublishedFrom()
    {
        return $this->publishedFrom;
    }

    /**
     * @param \DateTime|null $publishedFrom
     */
    public function setPublishedFrom($publishedFrom)
    {
        $this->publishedFrom = $publishedFrom;
    }

    /**
     * @return \DateTime|null
     */
    public function getPublishedTo()
    {
        return $this->publishedTo;
    }

    /**
     * @param \DateTime|null $publishedTo
     */
    public function setPublishedTo($publishedTo)
    {
        $this->publishedTo = $publishedTo;
    }

    /**
     * @return UserInterface
     */
    public function getPublishedBy()
    {
        return $this->publishedBy;
    }

    /**
     * @param UserInterface $publishedBy
     */
    public function setPublishedBy($publishedBy)
    {
        $this->publishedBy = $publishedBy;
    }

    /**
     * @param Route $route
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }
}
