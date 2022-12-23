<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PageController extends AbstractController
{
    #[Route('/page', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    public function __invoke(int $id): Response
    {
        return $this->render('page/index.html.twig', ['id' => $id]);
    }
}
