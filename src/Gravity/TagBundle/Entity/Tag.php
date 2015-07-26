<?php


namespace Gravity\TagBundle\Entity;

use Gravity\CmsBundle\Entity\FieldableEntity;

/**
 * Class Tag
 *
 * @package Gravity\TagBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Tag extends FieldableEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @inheritDoc
     */
    function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = strtolower($name);
    }
}
