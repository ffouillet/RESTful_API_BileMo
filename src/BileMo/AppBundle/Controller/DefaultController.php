<?php

namespace BileMo\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BileMoAppBundle:Default:index.html.twig');
    }
}
