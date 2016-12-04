<?php

namespace AppBundle\Controller\Front\Admin;

use AppBundle\Entity\Answer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends Controller
{
    /**
     * @Route("/answers", name="admin_answer_index")
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
            'AppBundle:Admin/Answer:index.html.twig', [
                'paginator' => $this->get('app.answer_repository')->createAnswerPaginator(
                    [
                        'query' => $request->get('q', null)
                    ],
                    $request->get('sorting', [])
                )->setCurrentPage($request->get('page', 1))
            ]
        );
    }

    /**
     * @Route("/answers/{id}/delete", name="admin_answer_delete")
     *
     * @param Answer $answer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \LogicException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction(Answer $answer)
    {
        $this->get('app.challenge_repository')->remove($answer);
        $this->addFlash('success', $this->get('translator')->trans('answer.delete.success'));

        return $this->redirectToRoute('admin_answer_index');
    }
}
