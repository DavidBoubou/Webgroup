<?php

declare(strict_types=1);

namespace Sonata\BlockBundle\Block\Service;


use Sonata\BlockBundle\Block\Service\ChartBlock;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

//chart
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartBlock2 extends ChartBlock 
    {

    private ChartBuilderInterface  $chartBuilder ;
    private Environment $twig;

    public function __construct(Environment $twig,ChartBuilderInterface  $chartBuilder)
    {
        $this->twig = $twig;
        $this->chartBuilder = $chartBuilder;

    }


    //1-configuration du blok
    public function configureSettings(OptionsResolver $resolver):void
    {
    //  $chartBuilder = $this->chartBuilder;
        $resolver->setDefaults([
            //the count 
            'chart' => $this->MyChart($chart),
            'template' => 'Block/chart.html.twig',
        ]);

        return;
    }

    public function MyChart(ChartBuilderInterface  $chartBuilder ):chart
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $chart;
    }



    //4-hoook d'éxécution du formulaire pour un block rss
    //Cette methode droit retourner une réponse objet pour rendre le tableau
    public function execute(BlockContextInterface $blockContext, Response $response = null, chartBuilderInterface  $chartBuilder=null ): Response
    {
        // merge settings
        $settings = $blockContext->getSettings();



        return $this->renderResponse($blockContext->getTemplate(), [
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings,
            //'chart' => $this->MyChart($this->chartBuilder)
            //'chart' => $chart
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
        public function load(BlockInterface $block): void
        {
        }

        public function getCacheKeys(BlockInterface $block): array
        {
            $updatedAt = $block->getUpdatedAt();

            return [
                'block_id' => $block->getId(),
                'updated_at' => null !== $updatedAt ? $updatedAt->format('U') : null,
            ];
        }


    }