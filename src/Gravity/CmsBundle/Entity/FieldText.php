<?php


namespace Gravity\CmsBundle\Entity;

/**
 * Class FieldText
 *
 * @package Gravity\CmsBundle\Entity
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FieldText extends Field
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $format = 'fulltext';

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
}
