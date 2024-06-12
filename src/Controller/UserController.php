<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_profil')]
    public function index(UserRepository $userRepository, AddressRepository $addressRepository, Address $address = null, EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $user = $this->getUser();
        $infoUser = $userRepository->find($id);
        $address = $addressRepository->findBy(['users' => $id]);

        if ($user && $infoUser && $user === $infoUser) { 

            if (!$address) {
                $address = new Address();
            }

            // On crée le formulaire pour le PRODUIT
            $form = $this->createForm(AddressType::class, $address);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $address = $form->getData();
                $address->setUsers($infoUser);

                $entityManager->persist($address);
                $entityManager->flush();

            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'infoUser' => $infoUser,
                'formProfil' => $form
            ]);
        }
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'infoUser' => $infoUser,
            'formProfil' => $form
        ]);
        } else {
            return $this->redirectToRoute('app_home');
        }

        return $this->redirectToRoute('app_home');
    }
}
