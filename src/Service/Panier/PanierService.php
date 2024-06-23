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

        // Je récupère la date du jour
        $date = new \DateTime();
        // Et je la formate en "annéemoisjour -> 20241231" par exemple
        $formattedDate = $date->format('Ymd');

        // Je récupère la dernière commande qui existe
        $lastOrder = $this->orderRepository->findOneBy([], ['id' => 'DESC']);

        // Je défini le dernier chiffre
        $lastNumber = 0;

        // Puis je fais un check si j'ai une dernière commande pour ajuster les derniers chiffres (01/02/03 etc)
        if ($lastOrder) {
            // Je récupère la reference de la dernière commande
            $lastReference = $lastOrder->getReference();
            // Je compare avec strpos la date de la reference et de ma formattedDate
            if ($lastReference && strpos($lastReference, $formattedDate) === 0) {
                // Si on retrouve la même chose, alors je récupère les deux derniers chiffre avec SUBSTR
                $lastNumber = (int)substr($lastReference, -2);
            }
        }
        // Ensuite je crée partie de la référence après la date '01 / 02 / 03' avec str_pad qui permet d'ajouter une chaine de caractère jusqu'a une longueur specifique.
        $newNumber = str_pad((string)($lastNumber + 1), 2, '0', STR_PAD_LEFT);
        return $formattedDate . '' . $newNumber;
    }
    
}

?>