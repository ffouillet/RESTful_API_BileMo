<?php
namespace AppBundle\Normalizer;

use Symfony\Component\HttpFoundation\Response;

class AuthenticationCredentialsNotFoundExceptionNormalizer extends AbstractNormalizer
{

    public function normalize(\Exception $exception)
    {
        $result['code'] = Response::HTTP_UNAUTHORIZED;

        $result['body'] = [
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => 'You are not authorized to see this resource because you are not authenticated (OAuth2 authentication required). AccessToken or RefreshToken missing.'
        ];

        return $result;

    }
}
