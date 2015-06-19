<?php


namespace Gravity\CmsBundle\Field\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class Field
 *
 * @package Gravity\CmsBundle\Field\Validator
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @Annotation
 */
class Field extends Constraint
{
    public $message = 'The value is not a valid field';

    public $fields = [];

    public function getRequiredOptions()
    {
        return [
            'fields'
        ];
    }
}
