<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

class ResultController extends ApiController
{
    /**
     * @ApiDoc(
     *   section = "result",
     *   description = "Get results",
     *   views = {"default"},
     *   authentication = false,
     *   resource = true,
     *   statusCodes = {
     *     200 = "Success",
     *     401 = "Authentication required",
     *     403 = "Unauthorized"
     *   },
     *   output = {
     *     "class" = "AppBundle\Model\ChallengesResults",
     *     "groups"={"result_simple", "challenge_simple"}
     *   }
     * )
     *
     * @Rest\Get("/results")
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    public function getAction(): Response
    {
        $redis = $this->get('app.redis_client');

        $cacheKey = '/api/v1/results';
        $cached = $redis->get($cacheKey);

        if ($cached) {
            $response = new Response($cached, 200);
            $response->setTtl(300);

            return $response;
        }

        $raw = $this->get('app.answer_repository')->getRawResults();
        $results = $this->get('app.answer_manager')->transformRaw($raw);

        $response = $this->response($results, 200, ['result_simple', 'challenge_simple']);

        $redis->set($cacheKey, $response->getContent(), 300);

        return $response->setTtl(300);
    }
}
