<?php

namespace App\Controller;

use App\Service\Panier\PanierService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrdersController extends AbstractController
{
    #[Route('/ajoutOrder', name: 'add_order')]
    public function index(PanierService $panierService): Response
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

        // Si le panier n'est pas vide, on crée la commande
        $order = new Order();

        // Puis on parcourt le panier pour l'ajouté à une commande

        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }
}
