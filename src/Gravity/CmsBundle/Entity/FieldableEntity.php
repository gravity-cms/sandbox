<?php


namespace Gravity\CmsBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FieldableEntity
 *
 * @package Gravity\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldableEntity
{
    /**
     * @var int
     */
    protected $id;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
}
