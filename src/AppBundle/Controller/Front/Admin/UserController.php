<?php

namespace AppBundle\Controller\Front\Admin;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/users", name="admin_user_index")
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
            'AppBundle:Admin/User:index.html.twig', [
                'paginator' => $this->get('app.user_repository')->createUserPaginator(
                    [
                        'query' => $request->get('q', null)
                    ],
                    $request->get('sorting', [])
                )->setCurrentPage($request->get('page', 1))
            ]
        );
    }

    /**
     * @Route("/users/add", name="admin_user_add")
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
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->add('save', SubmitType::class, [
            'label' => 'user.add.button',
            'attr' => ['class' => 'btn btn-primary']
        ]);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('app.user_repository')->save($user);
            $this->addFlash('success', $this->get('translator')->trans('user.add.success'));

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render(
            'AppBundle:Admin/User:add.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/users/{id}/edit", name="admin_user_edit")
     * @param Request $request
     * @param User $user
     * @return array
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->add('save', SubmitType::class, [
            'label' => 'user.edit.button',
            'attr' => ['class' => 'btn btn-primary']
        ]);

        if ($form->handleRequest($request)->isValid()) {
            $user = $form->getData();
            $this->get('app.user_repository')->save($user);
            $this->addFlash('success', $this->get('translator')->trans('user.edit.success'));

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render(
            'AppBundle:Admin/User:edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
