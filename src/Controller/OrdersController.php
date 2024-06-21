<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Service\Panier\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrdersController extends AbstractController
{
    #[Route('/ajoutOrder', name: 'add_order')]
    public function index(PanierService $panierService, ProductRepository $productRepository, OrderRepository $orderRepository, EntityManagerInterface $entityManager): Response
    {

        // On vérifie que l'user est connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        // On récupère les informations du Panier
        $panier = $panierService->getPanier();

        // Si le panier est vide, on redirige vers la page Home
        if ($panier === []) {
            return $this->redirectToRoute('app_home');
        }

        // Si le panier n'est pas vide, on crée la commande et la commande Produit
        $order = new Order();
        $orderReference = uniqid();
        $order->setReference("5555");
        
        for ($i = 0; $i < count($panier); $i++) {
            
            $product = $panier[$i]['product'];
            
            if ($product) {

                $orderProduct = new OrderProduct();

                $orderProduct->setProduct($product);
                $orderProduct->setQuantity($panier[$i]["quantity"]);
                $orderProduct->setPrice($product->getPrice());

                $order->addOrderProduct($orderProduct);

            }

        }
        
        $entityManager->persist($order);
        $entityManager->flush($order);

        return $this->redirectToRoute('app_home');
    }
}
