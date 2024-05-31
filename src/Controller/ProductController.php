<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Panier\PanierService;
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

    #[Route('/produit/{id}', name: 'show_product')]
    public function show_product(ProductRepository $productRepository, Product $product, $id = null): Response
    {

        $product = $productRepository->find($id);

        if ($product) {

            return $this->render('product/showProduct.html.twig', [
                'controller_name' => 'ProductController',
                'product' => $product
            ]);

        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/panier', name: 'app_panier')]
    public function panier(PanierService $panierService): Response
    {

            return $this->render('product/panier.html.twig', [
                'controller_name' => 'ProductController',
                'items' => $panierService->getPanier(),
                'total' => $panierService->getTotal()
            ]);


    }

    #[Route('/panier/add/{id}', name: 'app_addPanier')]
    public function addPanier($id, PanierService $panierService): Response
    {

        $panierService->add($id);

        return $this->redirectToRoute('app_product');
    }

    #[Route('/panier/remove/{id}', name: 'app_removeItemPanier')]
    public function removeItemPanier($id, PanierService $panierService): Response
    {
        $panierService->remove($id);

        return $this->redirectToRoute('app_panier');
    }
}
