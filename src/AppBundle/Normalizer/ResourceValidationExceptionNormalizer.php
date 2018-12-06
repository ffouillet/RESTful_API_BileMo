<?php
namespace AppBundle\Normalizer;

use Symfony\Component\HttpFoundation\Response;

class ResourceValidationExceptionNormalizer extends AbstractNormalizer
{

    public function normalize(\Exception $exception)
    {
        $result['code'] = Response::HTTP_BAD_REQUEST;

        $result['body'] = [
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => $exception->getMessage()
        ];

        return $result;

    }
}
