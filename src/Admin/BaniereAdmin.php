<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

//routes
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class BaniereAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {

        $collection->remove('delete');

    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('titre',null,[
                'label'=>'Baniere', 
                'constraints' => [
                    new NotBlank()]])
            ->add('image_url')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('titre',null,[
                'label'=>'Baniere', 
                'constraints' => [
                    new NotBlank()]])

            ->add('image_url');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('titre',null,[
                'label'=>'Baniere', 
                'constraints' => [
                    new NotBlank()]])
            ->add('image_url')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('titre',null,[
                'label'=>'Baniere', 
                'constraints' => [
                    new NotBlank()]])
            ->add('image_url')
            ;
    }
}
