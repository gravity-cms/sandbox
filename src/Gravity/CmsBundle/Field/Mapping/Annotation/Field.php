<?php


namespace Gravity\CmsBundle\Field\Mapping;

/**
 * Class Field
 *
 * @package Gravity\CmsBundle\Field\Mapping
 * @author Andy Thorne <contrabandvr@gmail.com>
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class Field 
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
