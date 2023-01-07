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
                'No product found'
            );
        }

        return $this->render('client/page-teaser.html.twig', [
            'controller_name' => 'ClientController',
            'articles'=>$articles,
        ]);
    }

    #[Route('/articles/{titre}', name: 'app_client_articles')]
    public function archive(Articles $article): Response
    {
        /**
        $post = $this->getPostManager()->findOneByPermalink($permalink, $this->container->get('sonata.news.blog'));
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($post->getTitle())
            //Preênd le titre de la page
            ->addTitlePrefix($post->getTitle());
            //Description
            ->addMeta('name', 'description', $post->getAbstract())
            //Propriété de la SEO
            ->addMeta('property', 'og:title', $post->getTitle())
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('sonata_news_view', [
                'permalink' => $this->getBlog()->getPermalinkGenerator()->generate($post, true)
            ], true))
            ->addMeta('property', 'og:description', $post->getAbstract())
            ->setBreadcrumb('news_post', [
                'post' => $post,
            ])
        ;
          
         */
        return $this->render('client/page-full.html.twig', [
            'controller_name' => 'ClientController',
            'article'=>$article,
        ]);
    }


    //route 
    #[Route('/media', name: 'app_client_articles')]
    public function media(): Response
    {

    }

}
