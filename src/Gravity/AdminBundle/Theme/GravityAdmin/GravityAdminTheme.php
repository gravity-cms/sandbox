<?php

namespace Gravity\AdminBundle\Theme\GravityAdmin;

use Gravity\AdminBundle\AbstractTheme;

/**
 * Class GravityAdminTheme
 *
 * @package Gravity\AdminBundle\Theme\GravityAdmin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GravityAdminTheme extends AbstractTheme
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'gravity_admin';
    }

    public function getLabel()
    {
        return 'Gravity Theme';
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::TYPE_ADMIN;
    }
} 
