<?php

namespace BileMo\AppBundle\Controller;

use BileMo\AppBundle\Entity\User;
use BileMo\AppBundle\Exception\ResourceValidationException;
use BileMo\AppBundle\Representation\Users;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as REST;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @REST\Get("/users", name="show_user_list")
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
     *     description="Max number of users per page."
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
        $pager = $this->em->getRepository('BileMoAppBundle:User')->findAllPaginated(
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('attributeToOrderBy'),
            $paramFetcher->get('order')
        );

        return new Users($pager);
    }

    /**
     * @REST\Get(
     *		path = "/users/{id}",
     *		name = "show_user_details",
     *		requirements = {"id"="\d+"}
     * )
     * @REST\View(StatusCode = 200)
     */
    public function showAction(User $user)
    {
        return $user;
    }

    /**
     * @REST\Post(
     *     path = "/users",
     *     name = "create_user"
     * )
     * @REST\View(StatusCode = 201)
     * @REST\RequestParam(git
     *		name = "username",
     * 		description = "User's username."
     * )
     * @REST\RequestParam(
     *		name = "email",
     * 		description = "User's email address."
     * )
     * @REST\RequestParam(
     *		name = "password",
     * 		description = "User's password."
     * )
     * @REST\RequestParam(
     *		name = "first_name",
     * 		description = "User's first name."
     * )
     * @REST\RequestParam(
     *		name = "last_name",
     * 		description = "User's last name."
     * )
     */
    public function createAction(ParamFetcherInterface $paramFetcher, ValidatorInterface $validator){

        $user = new User();

        // Get values from paramFetcher.
        // I decided not to use ParamConverter because of plainPassword and password.
        $user->setUsername($paramFetcher->get('username'));
        $user->setEmail($paramFetcher->get('email'));
        $user->setPlainPassword($paramFetcher->get('password'));
        $user->setFirstName($paramFetcher->get('first_name'));
        $user->setLastName($paramFetcher->get('last_name'));

        // Validate user.
        $userValidationErrors = $validator->validate($user);

        if(sizeof($userValidationErrors) > 0) {
            $errorMessage = "Unable to add the resource, the JSON sent contains invalid datas. Here are the errors you need to correct :";

            foreach($userValidationErrors as $validationError) {
                $errorMessage .= sprintf('Field %s : %s', $validationError->getPropertyPath(), $validationError->getMessage());
            }

            throw new ResourceValidationException($errorMessage);
        }

        // Save new user if no errors.
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @REST\Delete(
     *		path = "/users/{id}",
     *		name = "delete_user",
     *		requirements = {"id"="\d+"}
     * )
     * @REST\View(StatusCode = 204)
     */
    public function deleteAction(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}
