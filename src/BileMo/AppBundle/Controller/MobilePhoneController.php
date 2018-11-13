<?php

namespace BileMo\AppBundle\Controller;

use BileMo\AppBundle\Entity\MobilePhone;
use Doctrine\ORM\EntityManagerInterface;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as REST;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swagger\Annotations as SWG;

class MobilePhoneController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     *
     * Get paginated list of BileMo's Mobile phones
     *
     * @REST\Get("/mobiles", name="show_mobile_phones_list")
     * @REST\QueryParam(
     *     name="attributeToOrderBy",
     *     requirements="\w+",
     *     default="name",
     *     description="Attribute to order mobile phones by (an attribute of the resource)"
     * )
     * @REST\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
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
     *
     * @SWG\Get(
     *     description="Get paginated list of BileMo's Mobile phones",
     *     tags = {"Mobile Phones"},
     *     @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: OAuth2 authentication required. Missing or invalid Access Token.",
     *     )
     * )
     *
     * @Cache(maxage="30", public=true)
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
     *
     * Get one BileMo's Mobile phone details
     *
     * @REST\Get(
     *		path = "/mobiles/{id}",
     *		name = "show_mobile_phone_details",
     *		requirements = {"id"="\d+"}
     * )
     * @REST\View(StatusCode = 200)
     *
     * @SWG\Get(
     *     description="Get one BileMo's Mobile phone details",
     *     tags = {"Mobile Phones"},
     *     @SWG\Parameter(
     *          name="id",
     *          required= true,
     *          in="path",
     *          type="integer",
     *          description="Mobile phone's unique identifier",
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: OAuth2 authentication required. Missing or invalid Access Token.",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Mobile Phone doesn't exist (Resource not found)",
     *     )
     * )
     *
     * @Cache(lastModified="mobilePhone.getUpdatedAt()")
     */
    public function showAction(MobilePhone $mobilePhone)
    {
        return $mobilePhone;
    }
}
