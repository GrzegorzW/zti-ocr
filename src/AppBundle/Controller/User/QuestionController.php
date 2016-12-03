<?php

namespace AppBundle\Controller\User;

use AppBundle\Controller\ApiController;
use AppBundle\Entity\Category;
use AppBundle\Entity\Challenge;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionController extends ApiController
{
    /**
     * @ApiDoc(
     *   section = "challenge",
     *   description = "Get random questions collection",
     *   views = {"user", "admin"},
     *   authentication=true,
     *   authenticationRoles={"ROLE_USER"},
     *   resource = true,
     *   statusCodes = {
     *     200 = "Success",
     *     401 = "Authentication required",
     *     403 = "Unauthorized"
     *   },
     *   output= {
     *       "class" = "AppBundle\Entity\Question",
     *       "groups"={"challenge_simple", "challenge_detailed"},
     *       "collection" = true
     *   },
     *   parameters={
     *       {
     *          "name"="limit",
     *          "dataType"="integer",
     *          "required"=false,
     *          "description"="Questions limit: max: 10; default 10."
     *       }
     *   },
     *   requirements={
     *        {"name"="categoryId", "dataType"="string", "description"="Category ID"}
     *   }
     * )
     *
     * @Rest\Get("/questions")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function cgetAction(Request $request)
    {
        // $limit = $request->request->getInt('limit', Challenge::RANDOM_QUESTIONS_LIMIT);
        //
        // $questions = $this->get('app.challenge_repository')->getRandomQuestions(, $limit);

        // return $this->response($questions, 200, ['challenge_simple', 'challenge_detailed']);
    }


}
