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
     * @Route("/cloth", name="cloths", methods="GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function cloths(Request $request): Response
    {
        /** @var ClothRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Cloth::class);

        $products = $repository->findAll();

        return $this->render('product/product-index.html.twig', ['products' => $products, 'title' => 'cloths.name', 'show_route' => 'cloth']);
    }

    /**
     * @Route("/cloth/{id}", name="cloth", methods="GET")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function cloth($id, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cloth::class);

        $product = $repository->find($id);

        return $this->render('product/product-show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/mask", name="masks", methods="GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function masks(Request $request): Response
    {
        /** @var MaskRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Mask::class);

        $products = $repository->findAll();

        return $this->render('product/product-index.html.twig', ['products' => $products, 'title' => 'masks.name', 'show_route' => 'mask']);
    }

    /**
     * @Route("/mask/{id}", name="mask", methods="GET")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function mask($id, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Mask::class);

        $product = $repository->find($id);

        return $this->render('product/product-show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/pants", name="pants", methods="GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function pants(Request $request): Response
    {
        /** @var PantsRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Pants::class);

        $products = $repository->findAll();

        return $this->render('product/product-index.html.twig', ['products' => $products, 'title' => 'pants.name', 'show_route' => 'pant']);
    }

    /**
     * @Route("/pant/{id}", name="pant", methods="GET")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function pant($id, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Pants::class);

        $product = $repository->find($id);

        return $this->render('product/product-show.html.twig', ['product' => $product]);
    }
}