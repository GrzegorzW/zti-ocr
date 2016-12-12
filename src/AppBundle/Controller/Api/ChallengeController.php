<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class ChallengeController extends ApiController
{
    /**
     * @ApiDoc(
     *   section = "challenge",
     *   description = "List challenges",
     *   views = {"default"},
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
     *       "groups"={"challenge_simple"},
     *       "collection" = true
     *   }
     * )
     *
     * @Rest\Get("/challenges")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     */
    public function cgetAction(Request $request)
    {
        $challengesQB = $this->get('app.challenge_repository')->getChallengesQB();

        $result = $this->get('app.pagination_manager')
            ->paginate($challengesQB, $request->query->get('sorting', ['createdAt' => 'desc']))
            ->setCurrentPage($request->query->getInt('page', 1));

        return $this->responseWithPaginator($result, 200, ['challenge_simple']);
    }
}
