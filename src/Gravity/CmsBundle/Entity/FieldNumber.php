<?php


namespace Gravity\CmsBundle\Entity;

/**
 * Class FieldNumber
 *
 * @package Gravity\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldNumber extends Field
{
    /**
     * @var string
     */
    protected $number;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }
}
