<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexController(Request $request): Response
    {
        return $this->render('default/index.html.twig');
    }
}
