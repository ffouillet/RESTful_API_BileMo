<?php

namespace BileMo\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get as Get;
use FOS\RestBundle\Controller\Annotations\View as View;


class MobilePhoneController extends Controller
{
    /**
     * @Get("/mobiles", name="mobile_phones_list")
     * @View
     */
    public function listAction()
    {
        $mobilePhones = $this->getDoctrine()->getRepository('BileMoAppBundle:MobilePhone')->findAll();

        return $mobilePhones;
    }
}
