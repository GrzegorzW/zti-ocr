<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Answer;
use AppBundle\Form\AnswerType;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use FOS\RestBundle\Controller\Annotations as Rest;
use InvalidArgumentException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class AnswerController extends ApiController
{
    /**
     * @ApiDoc(
     *   section = "answer",
     *   description = "Post answer",
     *   views = {"default"},
     *   authentication = true,
     *   authenticationRoles = {"ROLE_USER"},
     *   resource = true,
     *   statusCodes = {
     *     204 = "Success",
     *     400 = "Invalid params",
     *     418 = "Invalid answer",
     *     401 = "Authentication required",
     *     403 = "Unauthorized",
     *     404 = "Not found"
     *   },
     *   input= {
     *      "class" = "AppBundle\Form\AnswerType"
     *   }
     * )
     *
     * @Rest\Post("/answers")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws HttpException
     * @throws InvalidArgumentException
     * @throws InvalidOptionsException
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function postAction(Request $request): Response
    {
        $answer = new Answer();
        $form = $this->get('form.factory')->createNamed('', AnswerType::class, $answer);

        $this->handleForm($form, $request);
        if (!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }

        if (!$answer->isCorrect()) {
            throw new HttpException(418, 'Your answer is incorrect.');
        }

        $this->get('app.answer_repository')->save($answer);

        return $this->response([], 204);
    }
}
