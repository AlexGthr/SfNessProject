<?php

namespace App\Controller;

use App\Repository\FaqRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {

        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/apropos', name: 'app_apropos')]
    public function apropos(FaqRepository $faqRepository): Response
    {
        $faqs = $faqRepository->findAll();

        return $this->render('home/apropos.html.twig', [
            'controller_name' => 'HomeController',
            'faqs' => $faqs
        ]);
    }
}
