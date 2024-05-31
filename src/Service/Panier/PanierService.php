<?php

namespace App\Service\Panier;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    private RequestStack $requestStack; 
    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function add(int $id) 
    {

        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }


        $this->getSession()->set('panier', $panier);
    }

    public function remove(int $id) 
    {

        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->getSession()->set('panier', $panier);

    }

    public function getPanier(): array 
    {
        $panier = $this->getSession()->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) {

            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];

        }

        return $panierWithData;
    }

    public function getTotal() 
    {
        $total = 0;

        foreach($this->getPanier() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }
}

?>