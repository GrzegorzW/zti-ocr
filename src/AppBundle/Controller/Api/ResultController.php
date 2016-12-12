<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ResultController extends ApiController
{
    /**
     * @ApiDoc(
     *   section = "result",
     *   description = "Get results",
     *   views = {"default"},
     *   authentication = true,
     *   authenticationRoles = {"ROLE_USER"},
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
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getAction()
    {
        $raw = $this->get('app.answer_repository')->getRawResults();

        $results = $this->get('app.answer_manager')->transformRaw($raw);

        return $this->response($results, 200, ['result_simple', 'challenge_simple']);
    }
}
