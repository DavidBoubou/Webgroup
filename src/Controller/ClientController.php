<?php

namespace App\Controller;
use App\Entity\Articles;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_accueil')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine->getRepository(Articles::class)->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('client/page-teaser.html.twig', [
            'controller_name' => 'ClientController',
            'articles'=>$articles,
        ]);
    }

    #[Route('/articles/{slug}', name: 'app_client_articles')]
    public function archive(): Response
    {
        return $this->render('client/page-full.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    //Test des block
    #[Route('/block', name: 'block')]
    public function block(): Response
    {
        return $this->render('Block/Example.html.twig');
        
    }

}
