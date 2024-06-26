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
    public function addPanier($id, PanierService $panierService, ProductRepository $productRepository): Response
    {
        // Vérification si le produit existe
        $product = $productRepository->find($id);
        if (!$product) {
            return $this->json([
                'code' => 404,
                'message' => 'Product not found',
            ], 200);
        }

        $panierService->add($id);
    
        return $this->json([
            'code' => 200,
            'message' => 'OK',
            'addValide' => 'Produit ajouté au panier !'
        ], 200);
    }

    #[Route('/panier/remove/{id}', name: 'app_removeItemPanier')]
    public function removeItemPanier($id, PanierService $panierService, ProductRepository $productRepository): Response
    {
        // Vérification si le produit existe
        $product = $productRepository->find($id);
        if (!$product) {
            return $this->json([
                'code' => 404,
                'message' => 'Product not found',
            ], 200);
        }

        $panierService->remove($id);
        $total = $panierService->getTotal();

        return $this->json([
            'code' => 200,
            'message' => "ok",
            'total' => number_format($total, 2, '.', '')
        ], 200);
    }

    #[Route('/panier/addQuantity/{id}', name: 'app_addQuantity')]
    public function addQuantityPanier($id, PanierService $panierService, ProductRepository $productRepository): Response
    {
        // Vérification si le produit existe
        $product = $productRepository->find($id);
        if (!$product) {
            return $this->json([
                'code' => 404,
                'message' => 'Product not found',
            ], 200);
        }

        $panierService->upQuantity($id);

        $quantity = $panierService->getQuantity($id);

        $totalPriceItem = $panierService->getTotalPrice($id);

        $total = $panierService->getTotal();

        return $this->json([
            'code' => 200,
            'message' => "OK",
            'quantity' => $quantity,
            'totalPriceItem' => number_format($totalPriceItem, 2, '.', ''),
            'total' => number_format($total, 2, '.', '')
        ], 200);
    }

    #[Route('/panier/downQuantity/{id}', name: 'app_downQuantity')]
    public function downQuantityPanier($id, PanierService $panierService, ProductRepository $productRepository): Response
    {
        // Vérification si le produit existe
        $product = $productRepository->find($id);
        if (!$product) {
            return $this->json([
                'code' => 404,
                'message' => 'Product not found',
            ], 200);
        }

        $panierService->downQuantity($id);
        
        $quantity = $panierService->getQuantity($id);

        $totalPriceItem = $panierService->getTotalPrice($id);

        $total = $panierService->getTotal();

        return $this->json([
            'code' => 200,
            'message' => "OK",
            'quantity' => $quantity,
            'totalPriceItem' => number_format($totalPriceItem, 2, '.', ''),
            'total' => number_format($total, 2, '.', '')
        ], 200);
    }

    #[Route('/panier/deletePanier', name: 'app_deletePanier')]
    public function deletePanier(PanierService $panierService): Response
    {

        $panierService->removeAllProduct();

        return $this->redirectToRoute('app_panier');
    }
}
