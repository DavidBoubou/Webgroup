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


            $this->addFlash('sonata_flash_success', 'flash_batch_merge_success');
            return new RedirectResponse('/' );
    }
    


}