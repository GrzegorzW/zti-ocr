<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Answer;
use AppBundle\Form\AnswerType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     *   }
     * )
     *
     * @Rest\Post("/answers")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function postAction(Request $request)
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
