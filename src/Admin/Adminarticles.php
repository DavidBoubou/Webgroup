<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

//components
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ModelType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\UX\Dropzone\Form\DropzoneType;

//contrainst
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/*
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
*/

final class Adminarticles extends AbstractAdmin
{

/*Utliser la métode dun  forbuilder pour les arguements.*/

protected function configureFormFields(FormMapper $form):void 
    {
        // This method configures which fields are displayed on the edit and create actions. 
        //The FormMapper behaves similar to the FormBuilder of the Symfony Form component;
        $form->add('titre',TextType::class,[
            'label'=>'Titre de l\'article', 
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 3]),]])

            //Utiliser dropzone
        ->add('baniere_url',TextType::class,[
            'label'=>'Url de la banniere', 
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 3])
            ]])

        ->add('content',CKEditorType::class,[
            'label'=>'Contenu', 
            'constraints' => [
                new Length(['min' => 3])
            ]])

        ->add('catégorie',ModelType::class,[
            'label'=>'Catégories'])

        ->add('autheur',ModelType::class,[
            'label'=>'Autheur', 
            'constraints' => [
                new NotBlank()
            ]])
        //->add('date', DatePickerType::class)
        ->add('publie',  CheckboxType::class, [
            'label'    => 'publié ',
            'required' => false,
        ])
        ;

    }

protected function configureDatagridFilters(DatagridMapper $datagrid):void
    {
        // This method configures the filters, used to filter and sort the list of models;
        $datagrid->add('titre')        
                ->add('titre')
                ->add('catégorie')
                ->add('autheur')
                //->add('date')
                ->add('publie')
        ;

    }

protected function configureListFields(ListMapper $list):void 
    {
        //This method configures which fields are shown when all models are listed 
        //(the addIdentifier() method means that this field will link to the show/edit page of this particular
        // model);
        /*
        $list->addIdentifier('titre')        
            ->add('baniere_url')
            ->add('content')
            ->add('titre')
            ->add('catégorie')
            ->add('autheur')
            //->add('date')
            ->add('publie')
        ;
        */

    }

protected function configureShowFields(ShowMapper $show):void 
    {
        //This method configures which fields are displayed on the show action.
        $show->add('titre')        
        ->add('baniere_url')
        ->add('content')
        ->add('titre')
        ->add('catégorie')
        ->add('autheur')
        //->add('date')
        ->add('publie')
        ;

        
    }
}
