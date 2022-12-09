<?php

namespace App\Admin\Action;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class MergeController extends AbstractController
{
    public function batchMergeAction(ProxyQueryInterface $query, AdminInterface $admin,ChartBuilderInterface $chartBuilder): RedirectResponse
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        // Create data with articles realease by my user.
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

        //Option du chart
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

            //My special template with menu and chart.
            $this->addFlash('sonata_flash_success', 'flash_batch_merge_success');
            return new RedirectResponse('/' );
    }
    


}