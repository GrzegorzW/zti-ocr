<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\ApiController;
use AppBundle\Entity\Category;
use AppBundle\Entity\Challenge;
use AppBundle\Event\ImageUploadedEvent;
use AppBundle\Form\ChallengeType;
use AppBundle\Form\QuestionStatusType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionController extends ApiController
{
    /**
     * @ApiDoc(
     *   section = "challenge",
     *   description = "Create question",
     *   views = {"admin"},
     *   authentication=true,
     *   authenticationRoles={"ROLE_ADMIN"},
     *   resource = true,
     *   statusCodes = {
     *     201 = "Success",
     *     400 = "Invalid params",
     *     401 = "Authentication required",
     *     403 = "Unauthorized",
     *     404 = "Not found",
     *   },
     *   input= {
     *      "class" = "AppBundle\Form\QuestionType"
     *   },
     *   output= {
     *       "class" = "AppBundle\Entity\Question",
     *       "groups"={"challenge_simple", "challenge_detailed", "challenge_admin"}
     *   }
     * )
     *
     * @Rest\Post("/questions")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function postAction(Request $request)
    {
        $challenge = new Challenge();
        $form = $this->get('form.factory')->createNamed('', ChallengeType::class, $challenge);

        $this->handleForm($form, $request);
        if (!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }

        $this->get('event_dispatcher')->dispatch(
            ImageUploadedEvent::IMAGE_UPLOADED,
            new ImageUploadedEvent($challenge->getImage())
        );

        $this->get('app.challenge_repository')->save($challenge);

        return $this->response($challenge, 201, ['challenge_simple', 'challenge_detailed', 'challenge_admin']);
    }

    /**
     * @ApiDoc(
     *   section = "challenge",
     *   description = "Get question",
     *   views = {"admin"},
     *   authentication=true,
     *   authenticationRoles={"ROLE_ADMIN"},
     *   resource = true,
     *   statusCodes = {
     *     200 = "Success",
     *     401 = "Authentication required",
     *     403 = "Unauthorized",
     *     404 = "Not found"
     *   },
     *   output= {
     *       "class" = "AppBundle\Entity\Question",
     *       "groups"={"challenge_simple", "challenge_detailed", "challenge_admin"}
     *   },
     *   requirements={
     *        {"name"="questionId", "dataType"="string", "description"="Question ID"}
     *   }
     * )
     *
     * @Rest\Get("/challenges/{challengeId}")
     *
     * @param Challenge $challenge
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Challenge $challenge)
    {
        return $this->response($challenge, 200, ['challenge_simple', 'challenge_detailed', 'challenge_admin']);
    }

    /**
     * @ApiDoc(
     *   section = "challenge",
     *   description = "List challenges",
     *   views = {"user", "admin"},
     *   authentication=true,
     *   authenticationRoles={"ROLE_ADMIN"},
     *   resource = true,
     *   statusCodes = {
     *     200 = "Success",
     *     400 = "Invalid params",
     *     401 = "Authentication required",
     *     403 = "Unauthorized"
     *   },
     *   output= {
     *       "class" = "AppBundle\Entity\Question",
     *       "groups"={"challenge_simple", "challenge_admin"},
     *       "collection" = true
     *   }
     * )
     *
     * @Rest\Get("/challenges")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     */
    public function listAction(Request $request)
    {
        $statuses = [Challenge::STATUS_ENABLED, Challenge::STATUS_DISABLED];
        $categoriesQB = $this->get('app.challenge_repository')->getQuestionsQB($statuses);

        $result = $this->get('app.pagination_manager')
            ->paginate($categoriesQB, $request->query->get('sorting', ['createdAt' => 'desc']))
            ->setCurrentPage($request->query->getInt('page', 1));

        return $this->responseWithPaginator($result, 200, ['challenge_simple', 'challenge_admin']);
    }
}
