<?php

namespace Gravity\AdminBundle;


abstract class AbstractTheme implements ThemeInterface
{
    const TYPE_FRONTEND = 0;
    const TYPE_ADMIN    = 1;

    public function isAdminTheme()
    {
        return $this->getType() === self::TYPE_ADMIN;
    }
} 
