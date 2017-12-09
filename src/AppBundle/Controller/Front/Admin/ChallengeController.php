<?php

namespace AppBundle\Controller\Front\Admin;

use AppBundle\Entity\Challenge;
use AppBundle\Form\ChallengeType;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Pagerfanta\Exception\LessThan1CurrentPageException;
use Pagerfanta\Exception\NotIntegerCurrentPageException;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChallengeController extends Controller
{
    /**
     * @Route("/challenges", name="admin_challenge_index")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws OutOfRangeCurrentPageException
     * @throws NotIntegerCurrentPageException
     * @throws LessThan1CurrentPageException
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'AppBundle:Admin/Challenge:index.html.twig', [
                'paginator' => $this->get('app.challenge_repository')->createChallengePaginator(
                    [
                        'query' => $request->get('q', null)
                    ],
                    $request->get('sorting', [])
                )->setCurrentPage($request->get('page', 1))
            ]
        );
    }

    /**
     * @Route("/challenges/add", name="admin_challenge_add")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws AlreadySubmittedException
     * @throws UnexpectedTypeException
     * @throws LogicException
     */
    public function createAction(Request $request)
    {
        $challenge = new Challenge();
        $form = $this->createForm(
            ChallengeType::class,
            $challenge,
            [
                'validation_groups' => [ChallengeType::VALIDATION_CREATE]
            ]
        );
        $form->add('save', SubmitType::class, [
            'label' => 'challenge.add.button',
            'attr' => ['class' => 'btn btn-primary']
        ]);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('app.challenge_repository')->save($challenge);
            $this->addFlash('success', $this->get('translator')->trans('challenge.add.success'));

            return $this->redirectToRoute('admin_challenge_index');
        }

        return $this->render(
            'AppBundle:Admin/Challenge:add.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/challenges/{id}/delete", name="admin_challenge_delete")
     *
     * @param Challenge $challenge
     *
     * @return RedirectResponse
     * @throws ORMInvalidArgumentException
     * @throws \LogicException
     * @throws OptimisticLockException
     */
    public function deleteAction(Challenge $challenge)
    {
        $this->get('app.challenge_repository')->remove($challenge);
        $this->addFlash('success', $this->get('translator')->trans('challenge.delete.success'));

        return $this->redirectToRoute('admin_challenge_index');
    }

    /**
     * @Route("/challenges/{id}/edit", name="admin_challenge_edit")
     *
     * @param Request $request
     * @param Challenge $challenge
     *
     * @return Response
     *
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws AlreadySubmittedException
     * @throws UnexpectedTypeException
     * @throws LogicException
     */
    public function editAction(Request $request, Challenge $challenge)
    {
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->add('save', SubmitType::class, [
            'label' => 'challenge.edit.button',
            'attr' => ['class' => 'btn btn-primary']
        ]);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('app.challenge_repository')->save($challenge);
            $this->addFlash('success', $this->get('translator')->trans('challenge.edit.success'));

            return $this->redirectToRoute('admin_challenge_index');
        }

        return $this->render(
            'AppBundle:Admin/Challenge:edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
