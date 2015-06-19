<?php


namespace Gravity\CmsBundle\Field\Mapping;

/**
 * Class Widget
 *
 * @package Gravity\CmsBundle\Field\Mapping
 * @author Andy Thorne <contrabandvr@gmail.com>
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class Widget 
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $options;
}
