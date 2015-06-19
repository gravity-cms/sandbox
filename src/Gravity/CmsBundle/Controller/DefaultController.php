<?php

namespace Gravity\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GravityCmsBundle:Default:index.html.twig', array('name' => $name));
    }
}
