<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_accueil')]
    public function index(): Response
    {
        return $this->render('client/page-teaser.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/articles/{slug}', name: 'app_client_articles')]
    public function archive(): Response
    {
        return $this->render('client/page-full.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
