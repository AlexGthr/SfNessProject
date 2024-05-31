<?php

namespace App\Service\Panier;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    private RequestStack $requestStack; 
    private EntityManagerInterface $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function add(int $id) {
        $panier = $this->getSession()->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }


        $this->getSession()->set('panier', $panier);
    }

    public function remove(int $id) {}

    // public function add(int $id) {}

    // public function add(int $id) {}
}

?>