<?php

namespace Gravity\CmsBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser;
use JMS\Serializer\Annotation as JMS;
/**
 * Class User
 *
 * @package Gravity\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class User extends BaseUser
{
    protected $id;

    protected $username;

    protected $usernameCanonical;

    protected $email;

    protected $emailCanonical;

    protected $enabled;

    protected $twoStepVerificationCode;
}
