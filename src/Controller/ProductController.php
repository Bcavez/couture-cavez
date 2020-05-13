<?php

namespace App\Controller;

use App\Entity\Cloth;
use App\Entity\Mask;
use App\Entity\Pants;
use App\Repository\ClothRepository;
use App\Repository\MaskRepository;
use App\Repository\PantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/cloth", name="cloth", methods="GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function Cloth(Request $request): Response
    {
        /** @var ClothRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Cloth::class);

        $products = $repository->findAll();

        return $this->render('product/product.html.twig', ['products' => $products, 'title' => 'Cloth']);
    }

    /**
     * @Route("/mask", name="mask", methods="GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function Mask(Request $request): Response
    {
        /** @var MaskRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Mask::class);

        $products = $repository->findAll();

        return $this->render('product/product.html.twig', ['products' => $products, 'title' => 'Mask']);
    }

    /**
     * @Route("/pants", name="pants", methods="GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function Pants(Request $request): Response
    {
        /** @var PantsRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Pants::class);

        $products = $repository->findAll();

        return $this->render('product/product.html.twig', ['products' => $products, 'title' => 'Pants']);
    }
}