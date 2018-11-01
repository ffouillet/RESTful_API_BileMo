<?php

namespace BileMo\AppBundle\Controller;

use BileMo\AppBundle\Entity\MobilePhone;
use BileMo\AppBundle\Representation\MobilePhones;
use Doctrine\ORM\EntityManagerInterface;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as REST;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MobilePhoneController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @REST\Get("/mobiles", name="show_mobile_phones_list")
     * @REST\QueryParam(
     *     name="attributeToOrderBy",
     *     requirements="\w+",
     *     default="",
     *     description="Sort order [by name] (asc or desc)"
     * )
     * @REST\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order [by name] (asc or desc)"
     * )
     * @REST\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of mobiles phones per page."
     * )
     * @REST\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @REST\View(StatusCode = 200)
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->em->getRepository('BileMoAppBundle:MobilePhone')->findAllPaginated(
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('attributeToOrderBy'),
            $paramFetcher->get('order')
        );

        // Add links to pagination (with that, API get now to level 3 of Richardson Maturity Model)
        $pagerfantaFactory   = new PagerfantaFactory();

        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pager,
            new Route('show_mobile_phones_list', array(), true)
        );

        return $paginatedCollection;
    }

    /**
     * @REST\Get(
     *		path = "/mobiles/{id}",
     *		name = "show_mobile_phone_details",
     *		requirements = {"id"="\d+"}
     * )
     * @REST\View(StatusCode = 200)
     */
    public function showAction(MobilePhone $mobilePhone)
    {
        return $mobilePhone;
    }
}
