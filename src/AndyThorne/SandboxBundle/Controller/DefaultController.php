<?php

namespace AndyThorne\SandboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AndyThorneSandboxBundle:Default:index.html.twig', array('name' => $name));
    }
}
