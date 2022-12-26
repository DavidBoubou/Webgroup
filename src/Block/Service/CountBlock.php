<?php

declare(strict_types=1);

namespace App\Block\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CountBlock extends AbstractBlockService
{

//1-configuration du blok
public function configureSettings(OptionsResolver $resolver):void
{
    $resolver->setDefaults([
        //the count 
        'count' => 0,
        'template' => 'Block/count.html.twig',
    ]);

    return;
}



//4-hoook d'éxécution du formulaire pour un block rss
//Cette methode droit retourner une réponse objet pour rendre le tableau
public function execute(BlockContextInterface $blockContext, Response $response = null): Response
{
    // merge settings
    $settings = $blockContext->getSettings();



    return $this->renderResponse($blockContext->getTemplate(), [
        'block'     => $blockContext->getBlock(),
        'settings'  => $settings
    ], $response);


}

/*
    public function getCacheKeys(BlockInterface $block): array
    {
        $updatedAt = $block->getUpdatedAt();

        return [
            'block_id' => 'count_article_by_user',
            'updated_at' => null !== $updatedAt ? $updatedAt->format('U') : null,
        ];
    }
    */

}