<?php

namespace App\Admin\Controller;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class MergeController extends AbstractController
{
    public function batchMergeAction(ProxyQueryInterface $query, AdminInterface $admin): RedirectResponse
    {
        $admin->checkAccess('edit');
        $admin->checkAccess('delete');
        dd(type_of($admin));
        $modelManager = $admin->getModelManager();

        $target = $modelManager->find($admin->getClass(), $request->get('targetId'));

        if ($target === null) {
            $this->addFlash('sonata_flash_info', 'flash_batch_merge_no_target');

            return new RedirectResponse(
                $admin->generateUrl('list', [
                    'filter' => $admin->getFilterParameters()
                ])
            );
        }

        $selectedModels = $query->execute();

        // do the merge work here

        try {
            foreach ($selectedModels as $selectedModel) {
                $modelManager->delete($selectedModel);
            }

            $this->addFlash('sonata_flash_success', 'flash_batch_merge_success');
        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', 'flash_batch_merge_error');
        } finally {
            return new RedirectResponse(
                $admin->generateUrl('list', [
                    'filter' => $admin->getFilterParameters()
                ])
            );
        }
    }

    // ...
}