<?php


namespace Gravity\CmsBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Node
 *
 * @package Gravity\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Node
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $customPath;

    /**
     * @var bool
     */
    protected $published = false;

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
     * @var \DateTime
     */
    protected $createdOn;

    /**
     * @var UserInterface
     */
    protected $createdBy;

    /**
     * @var \DateTime|null
     */
    protected $editedOn;

    /**
     * @var UserInterface
     */
    protected $editedBy;

    /**
     * @var \DateTime|null
     */
    protected $deletedOn;

    /**
     * @var UserInterface
     */
    protected $deletedBy;

    /**
     * @var Route
     */
    protected $route;

    function __construct()
    {
        $this->createdBy = new \DateTime();
    }

    function __toString()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getCustomPath()
    {
        return $this->customPath;
    }

    /**
     * @param string $customPath
     */
    public function setCustomPath($customPath)
    {
        $this->customPath = $customPath;
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
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return UserInterface
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return \DateTime|null
     */
    public function getEditedOn()
    {
        return $this->editedOn;
    }

    /**
     * @param \DateTime|null $editedOn
     */
    public function setEditedOn($editedOn)
    {
        $this->editedOn = $editedOn;
    }

    /**
     * @return UserInterface
     */
    public function getEditedBy()
    {
        return $this->editedBy;
    }

    /**
     * @param UserInterface $editedBy
     */
    public function setEditedBy($editedBy)
    {
        $this->editedBy = $editedBy;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeletedOn()
    {
        return $this->deletedOn;
    }

    /**
     * @param \DateTime|null $deletedOn
     */
    public function setDeletedOn($deletedOn)
    {
        $this->deletedOn = $deletedOn;
    }

    /**
     * @return UserInterface
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * @param UserInterface $deletedBy
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param Route $route
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }
}
