<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function panier(SessionInterface $session, ProductRepository $productRepository): Response
    {

        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) {

            $panierWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];

        }

        $total = 0;

        foreach($panierWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

            return $this->render('product/panier.html.twig', [
                'controller_name' => 'ProductController',
                'items' => $panierWithData,
                'total' => $total
            ]);


    }

    #[Route('/panier/add/{id}', name: 'app_addPanier')]
    public function addPanier($id, SessionInterface $session): Response
    {

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }


        $session->set('panier', $panier);

        return $this->redirectToRoute('app_product');
    }

    #[Route('/panier/remove/{id}', name: 'app_removeItemPanier')]
    public function removeItemPanier($id, SessionInterface $session): Response
    {

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }
}
