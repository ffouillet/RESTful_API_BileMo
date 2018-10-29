<?php

namespace Fx\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FxUserBundle:Default:index.html.twig');
    }
}
