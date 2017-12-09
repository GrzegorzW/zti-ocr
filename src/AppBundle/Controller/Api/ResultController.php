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
     */
    public function getAction(): Response
    {
        $raw = $this->get('app.answer_repository')->getRawResults();

        $results = $this->get('app.answer_manager')->transformRaw($raw);

        return $this->response($results, 200, ['result_simple', 'challenge_simple']);
    }
}
