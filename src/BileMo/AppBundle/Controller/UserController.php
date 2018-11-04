<?php

namespace BileMo\AppBundle\Controller;

use BileMo\AppBundle\Entity\User;
use BileMo\AppBundle\Exception\ResourceValidationException;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as REST;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Swagger\Annotations as SWG;

class UserController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get paginated list of users
     *
     * @REST\Get("/users", name="show_user_list")
     *
     * @REST\QueryParam(
     *     name="attributeToOrderBy",
     *     requirements="\w+",
     *     default="username",
     *     description="Attribute to order users by (an attribute of the resource)"
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
     *     description="Max number of users per page."
     * )
     * @REST\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     *
     * @REST\View(StatusCode = 200)
     *
     * @SWG\Get(
     *     description="Get the list of users.",
     *     tags = {"Users"},
     *     @SWG\Response(
     *          response=200,
     *          description="Successful operation"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: OAuth2 authentication required. Missing or invalid Access Token.",
     *     )
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->em->getRepository('BileMoAppBundle:User')->findAllPaginated(
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('attributeToOrderBy'),
            $paramFetcher->get('order')
        );

        // Add links to pagination (with that, API get now to level 3 of Richardson Maturity Model)
        $pagerfantaFactory   = new PagerfantaFactory();

        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pager,
            new Route('show_user_list', array(), true)
        );

        return $paginatedCollection;
    }

    /**
     *
     * Get one user's details
     *
     * @REST\Get(
     *		path = "/users/{id}",
     *		name = "show_user_details",
     *		requirements = {"id"="\d+"}
     * )
     * @REST\View(StatusCode = 200)
     *
     * @SWG\Get(
     *     description="Get one user's details",
     *     tags = {"Users"},
     *     @SWG\Parameter(
     *          name="id",
     *          required= true,
     *          in="path",
     *          type="integer",
     *          description="User's unique identifier",
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
     *         description="User doesn't exist (Resource not found)",
     *     )
     * )
     */
    public function showAction(User $user)
    {
        return $user;
    }

    /**
     *
     * Create a user
     *
     * @REST\Post(
     *     path = "/users",
     *     name = "create_user"
     * )
     * @REST\View(StatusCode = 201)
     * @REST\RequestParam(
     *		name = "username",
     * 		description = "User's username.",
     *      strict = false
     * )
     * @REST\RequestParam(
     *		name = "email",
     * 		description = "User's email address.",
     *      strict = false
     * )
     * @REST\RequestParam(
     *		name = "password",
     * 		description = "User's password.",
     *      strict = false
     * )
     * @REST\RequestParam(
     *		name = "first_name",
     * 		description = "User's first name.",
     *      strict = false
     * )
     * @REST\RequestParam(
     *		name = "last_name",
     * 		description = "User's last name.",
     *      strict = false
     * )
     *
     * @SWG\Post(
     *     description="Create a user",
     *     tags = {"Users"},
     *     @SWG\Response(
     *          response=201,
     *          description="Created"
     *     ),
     *      @SWG\Response(
     *         response="400",
     *         description="Invalid json message received",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: OAuth2 authentication required. Missing or invalid Access Token.",
     *     )
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

                //We will show propertyPath as 'password' instead of 'plainPassword' to user (not to perturb him) in case there is a validation error on this field.
                $propertyPath = $validationError->getPropertyPath();

                if($propertyPath == 'plainPassword') {
                    $propertyPath = 'password';
                }

                $errorMessage .= sprintf(' Field \'%s\' : %s', $propertyPath, $validationError->getMessage());
            }

            throw new ResourceValidationException($errorMessage);
        }

        // Save new user if no errors.
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     *
     * Delete a user
     *
     * @REST\Delete(
     *		path = "/users/{id}",
     *		name = "delete_user",
     *		requirements = {"id"="\d+"}
     * )
     * @REST\View(StatusCode = 204)
     *
     * @SWG\Delete(
     *     description="Delete a user",
     *     tags = {"Users"},
     *     @SWG\Parameter(
     *          name="id",
     *          required= true,
     *          in="path",
     *          type="integer",
     *          description="User's unique identifier",
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="User deleted (successful operation)"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: OAuth2 authentication required. Missing or invalid Access Token.",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User doesn't exist (Resource not found)",
     *     )
     * )
     */
    public function deleteAction(User $user)
    {
        // Unallow "demoUser" deletion
        if ($user->getUsername() == 'demoUser') {
            throw new \Exception('Sorry but you are not allowed to delete the Demo User');
        }

        $this->em->remove($user);
        $this->em->flush();
    }
}
