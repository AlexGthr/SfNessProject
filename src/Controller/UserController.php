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
    public function index(UserRepository $userRepository, $id): Response
    {
        $user = $this->getUser();
        $infoUser = $userRepository->find($id);

        if ($user && $infoUser && $user === $infoUser) {

            return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'infoUser' => $infoUser
            ]);

        }

        return $this->redirectToRoute('app_home');
    }

    #[Route('/addAddress/{id}', name: 'app_address')]
    public function addAddress(UserRepository $userRepository, AddressRepository $addressRepository, Address $address = null, EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $user = $this->getUser();
        $infoUser = $userRepository->find($id);

        if ($user && $infoUser && $user === $infoUser) {

            $address = $addressRepository->findOneBy(['users' => $id]);
            // Récupération des données et filtrage
            $nom = filter_var($request->request->get('nom'), FILTER_SANITIZE_STRING);
            $prenom = filter_var($request->request->get('prenom'), FILTER_SANITIZE_STRING);
            $adresse = filter_var($request->request->get('adresse'), FILTER_SANITIZE_STRING);
            $codePostal = filter_var($request->request->get('code_postal'), FILTER_SANITIZE_STRING);
            $ville = filter_var($request->request->get('ville'), FILTER_SANITIZE_STRING);            

            // Expressions régulières pour les validations
            $regexLetters = '/^[a-zA-Z]+$/';
            $isNomValid = !empty($nom) && preg_match($regexLetters, $nom);
            $isPrenomValid = !empty($prenom) && preg_match($regexLetters, $prenom);
            $isAdresseValid = !empty($adresse);
            $isCodePostalValid = !empty($codePostal);
            $isVilleValid = !empty($ville) && preg_match($regexLetters, $ville);

            if ($isNomValid && $isPrenomValid && $isAdresseValid && $isCodePostalValid && $isVilleValid) {

                if ($address) {

                    $address->setName($prenom);
                    $address->setLastName($nom);
                    $address->setAddress($adresse);
                    $address->setZipCode($codePostal);
                    $address->setCity($ville);
                    
                    $entityManager->persist($address);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_profil', ['id' => $id]);

                } else {
                    $address = new Address();

                    $address->setName($prenom);
                    $address->setLastName($nom);
                    $address->setAddress($adresse);
                    $address->setZipCode($codePostal);
                    $address->setCity($ville);
                    $address->setUsers($infoUser);

                    $entityManager->persist($address);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_profil', ['id' => $id]);
                }
            } else {
                return $this->redirectToRoute('app_profil', ['id' => $id]);
            }
        }

        return $this->redirectToRoute('app_home');
    }

}
