<?php

namespace App\Service\Panier;

use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    private RequestStack $requestStack; 
    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;
    private OrderRepository $orderRepository;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager, ProductRepository $productRepository, OrderRepository $orderRepository)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
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

    public function getTotal(): float
    {
        $total = 0;

        foreach($this->getPanier() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

    public function upQuantity($id) 
    {
        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id] += 1;
        }
    
        $this->getSession()->set('panier', $panier);
    }

    public function downQuantity($id) 
    {
        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id] -= 1;
            if ($panier[$id] <= 0) {
                unset($panier[$id]);
            }
        }
    
        $this->getSession()->set('panier', $panier);
    }

    public function removeAllProduct() 
    {
        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier)) {
            unset($panier);
        }

        $this->getSession()->set('panier', []);
    }

    public function getQuantity($id) {
        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            return $panier[$id];
        }
    }

    public function getTotalPrice($id) {
        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            $price = $this->productRepository->find($id);

            $totalPrice = $price->getPrice() * $panier[$id];

            return $totalPrice;
        }
    }

    public function createReference() {
        $date = new \DateTime();
        $formattedDate = $date->format('Ymd');

        $lastOrder = $this->orderRepository->findOneBy([], ['id' => 'DESC']);

        $lastNumber = 0;

        if ($lastOrder) {
            $lastReference = $lastOrder->getReference();
            if ($lastReference && strpos($lastReference, $formattedDate) === 0) {
                $lastNumber = (int)substr($lastReference, -2);
            }
        }

        $newNumber = str_pad((string)($lastNumber + 1), 2, '0', STR_PAD_LEFT);
        return $formattedDate . '' . $newNumber;
    }
    
}

?>