<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ChallengeController extends ApiController
{
    /**
     * @ApiDoc(
     *   section = "challenge",
     *   description = "List challenges",
     *   views = {"user", "admin"},
     *   authentication = true,
     *   authenticationRoles = {"ROLE_USER"},
     *   resource = true,
     *   statusCodes = {
     *     200 = "Success",
     *     401 = "Authentication required",
     *     403 = "Unauthorized"
     *   },
     *   output= {
     *       "class" = "AppBundle\Entity\Challenge",
     *       "groups"={"challenge_simple", "challenge_detailed"},
     *       "collection" = true
     *   }
     * )
     *
     * @Rest\Get("/challenges")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function cgetAction()
    {
        $questions = $this->get('app.challenge_repository')->getChallengesQB();

        return $this->response($questions, 200, ['challenge_simple', 'challenge_detailed']);
    }


}
