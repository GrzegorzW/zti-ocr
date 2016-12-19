<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ResultController extends Controller
{
    /**
     * @Route("/", name="public_result_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Public/Result:index.html.twig');
    }
}
