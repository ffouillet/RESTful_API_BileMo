<?php

namespace BileMo\AppBundle\Controller;

use BileMo\AppBundle\Representation\MobilePhones;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get as Get;
use FOS\RestBundle\Controller\Annotations\QueryParam as QueryParam;
use FOS\RestBundle\Controller\Annotations\View as View;


class MobilePhoneController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Get("/mobiles", name="mobile_phones_list")
     * @QueryParam(
     *     name="attributeToOrderBy",
     *     requirements="\w+",
     *     default="",
     *     description="Sort order [by name] (asc or desc)"
     * )
     * @QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order [by name] (asc or desc)"
     * )
     * @QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of mobiles phones per page."
     * )
     * @QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @View
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->em->getRepository('BileMoAppBundle:MobilePhone')->findAllPaginated(
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('attributeToOrderBy'),
            $paramFetcher->get('order')
        );

        return new MobilePhones($pager);
    }
}
