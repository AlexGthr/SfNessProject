<?php

namespace App\Controller;

use DateTime;
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

        // On crée une nouvelle référence est on l'ajoute à la nouvelle commande
        $reference = $panierService->createReference();
        $order->setReference($reference);

        // On défini le payement sur "false"
        $order->setPaid(false);

        // On défini l'user qui crée la commande
        $order->setCommand($user);

        // Puis on ajoute la date de création de la commande
        $date = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $order->setCreationDate($date);
        
        // On ajoute les produits dans notre OrderProduct pour garder les produits commander en BDD
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
        
        // Puis on met à jour dans la BDD
        $entityManager->persist($order);
        $entityManager->flush($order);

        // On supprime le panier en session et on redirige vers la nouvelle page
        $panierService->removeAllProduct();
        return $this->redirectToRoute('app_home');
    }
}
