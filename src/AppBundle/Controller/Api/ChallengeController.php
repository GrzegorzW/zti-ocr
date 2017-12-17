<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Pagerfanta\Exception\LessThan1CurrentPageException;
use Pagerfanta\Exception\NotIntegerCurrentPageException;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     *
     * @return Response
     * @throws \InvalidArgumentException
     * @throws OutOfRangeCurrentPageException
     * @throws NotIntegerCurrentPageException
     * @throws LessThan1CurrentPageException
     */
    public function cgetAction(Request $request): Response
    {
        $key = $request->getRequestUri();
        $redis = $this->get('app.redis_client');

        $cached = $redis->get($key);

        if ($cached) {
            $response = new Response($cached, 200);
            $response->setTtl(300);

            return $response;
        }

        $challengesQB = $this->get('app.challenge_repository')->getChallengesQB();

        $result = $this->get('app.pagination_manager')
            ->paginate($challengesQB, $request->query->get('sorting', ['createdAt' => 'desc']))
            ->setCurrentPage($request->query->getInt('page', 1));

        $response = $this->responseWithPaginator($result, 200, ['challenge_simple']);

        $redis->set($key, $response->getContent(), 300);

        return $response->setTtl(300);
    }
}
