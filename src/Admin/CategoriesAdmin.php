<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Validator\Constraints\NotBlank;

class CategoriesAdmin extends AbstractAdmin
{

    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'categories';
    }


    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('titre',null,[
                'label'=>'Categorie', 
                'constraints' => [
                    new NotBlank()]])
            ->add('couleur')
            ->add('article')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('titre',null,[
                'label'=>'TCategorie', 
                'constraints' => [
                    new NotBlank()]])
            ->add('couleur')
            ->add('article');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('titre',null,[
                'label'=>'Categorie', 
                'constraints' => [
                    new NotBlank()]])
            ->add('couleur')
            ->add('article')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('titre',null,[
                'label'=>'Categorie', 
                'constraints' => [
                    new NotBlank()]])
            ->add('couleur')
            ->add('article')
            ;
    }
}
