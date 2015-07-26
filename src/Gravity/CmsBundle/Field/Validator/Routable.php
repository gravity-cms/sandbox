<?php


namespace Gravity\CmsBundle\Field\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class Routable
 *
 * @package Gravity\CmsBundle\Field\Validator
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class Routable extends Constraint
{
    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'routable';
    }
}
