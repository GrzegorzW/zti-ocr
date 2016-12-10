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
     *   output= {
     *       "class" = "AppBundle\Model\Results",
     *       "groups"={"result_simple"}
     *   }
     * )
     *
     * @Rest\Get("/results")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getAction()
    {
        $raw = $this->get('app.answer_repository')->getRawResults();

        $result = $this->get('app.answer_manager')->transformResults($raw);

        return $this->response($result, 200, ['result_simple']);
    }
}
