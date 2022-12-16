<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type\TemplateType;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\UX\Dropzone\Form\DropzoneType;
//routes
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class BaniereAdmin extends AbstractAdmin
{
    /*
    function __contruct()
    {

    }
    */

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {

        $collection->remove('delete');

    }

    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'baniere';
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
            ->addIdentifier('titre',null,[
                'label'=>'titre', 
                'constraints' => [
                    new NotBlank()]])

            //overider le template de la bannier  
            ->add('image_url', TemplateType::class, [
                            'label' => 'Banière',
                            'template'   => 'Admin/field/image_field.html.twig',
                        ])  ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('titre',null,[
                'label'=>'Baniere', 
                'constraints' => [
                    new NotBlank()]])
            ->add('image_url',FileType::class, [
                'label' => 'Brochure (PDF file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'jpg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
           // ->add('image_url', DropzoneType::class)
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
