<?php


namespace Gravity\CmsBundle\Entity;

/**
 * Class Field
 *
 * @package Gravity\CmsBundle\Entity
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Field
{

    /**
     * @var Node
     */
    protected $entity;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $delta;

    /**
     * @var string
     */
    protected $field;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param int $delta
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
    }

    /**
     * @return Node
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Node $entity
     */
    public function setEntity(Node $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }
}
