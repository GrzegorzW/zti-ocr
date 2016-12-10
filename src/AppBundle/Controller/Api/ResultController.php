<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Answer;
use AppBundle\Form\AnswerType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     *     "class" = "AppBundle\Model\Results",
     *     "groups"={"result_simple"}
     *   }
     * )
     *
     * @Rest\Get("/results")
     */
    public function getAction()
    {
        $raw = $this->get('app.answer_repository')->getRawResults();

        $results = $this->get('app.answer_manager')->transformResults($raw);

        return $this->response($results, 200, ['result_simple']);
    }
}
