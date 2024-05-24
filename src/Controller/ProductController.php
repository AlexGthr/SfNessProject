<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/produit', name: 'app_product')]
    public function product(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }

    #[Route('/produit/{id}', name: 'app_show_product')]
    public function show_product(ProductRepository $productRepository, Product $product, $id = null): Response
    {

        $products = $productRepository->find($id);

        if ($products) {

            return $this->render('product/showProduct.html.twig', [
                'controller_name' => 'ProductController',
                'products' => $products
            ]);

        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/panier', name: 'app_panier')]
    public function panier(): Response
    {

            return $this->render('product/panier.html.twig', [
                'controller_name' => 'ProductController',
            ]);

    }
}
