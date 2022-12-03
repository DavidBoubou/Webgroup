<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {

        // Removing the list route will disable listing entities.
        //Désactive la page list de l'entité
        $collection->remove('delete');

    }

    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'utilisateurs';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('adresse')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('adresse');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('email')
           // ->add('roles')
            ->add('password')
            ->add('adresse')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('email')
         //   ->add('roles')
            ->add('password')
            ->add('adresse')
            ;
    }
}
