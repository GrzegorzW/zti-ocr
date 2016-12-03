<?php

namespace AppBundle\Controller\Front\Admin;

use AppBundle\Entity\Challenge;
use AppBundle\Form\ChallengeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ChallengeController extends Controller
{
    /**
     * @Route("/challenges", name="admin_challenge_index")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
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
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function createAction(Request $request)
    {
        $cha = new Challenge();
        $form = $this->createForm(ChallengeType::class, $cha);
        $form->add('save', SubmitType::class, [
            'label' => 'challenge.add.button',
            'attr' => ['class' => 'btn btn-primary']
        ]);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('app.challenge_repository')->save($cha);
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \LogicException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction(Challenge $challenge)
    {
        $this->get('app.challenge_repository')->remove($challenge);
        $this->addFlash('success', $this->get('translator')->trans('challenge.remove.success'));

        return $this->redirectToRoute('admin_challenge_index');
    }

    /**
     * @Route("/challenges/{id}/edit", name="admin_challenge_edit")
     *
     * @param Request $request
     * @param Challenge $challenge
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
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
