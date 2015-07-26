<?php

namespace Gravity\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GravityTagBundle:Default:index.html.twig', array('name' => $name));
    }
}
