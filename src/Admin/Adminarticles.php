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
use Sonata\AdminBundle\Form\Type\ModelType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\Form\Type\CollectionType;

//entity
use App\Entity\User;
use App\Entity\Categories;

//contrainst
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

//routes

use Sonata\AdminBundle\Route\RouteCollectionInterface;

/*
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
*/

final class Adminarticles extends AbstractAdmin
{

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {

        // Removing the list route will disable listing entities.
        //Désactive la page list de l'entité
        $collection->remove('delete');

    }

    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'articles';
    }

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

        //configurer les modelType
        ///->add('categorie',ModelType::class)
        ->add('categorie',EntityType::class,[
            'class' => Categories::class,
            'choice_label' => 'titre'])

        ->add('autheur',EntityType::class,[
            'class' => User::class,
            'choice_label' => 'email'])
        

        //->add('autheur')

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
        $datagrid->add('titre',null,[
            'label'=>'Titre de l\'article', 
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 3]),]])        

                ->add('categorie.titre')
                ->add('autheur.email')                
                //->add('date')
                ->add('publie')
        ;

    }

protected function configureListFields(ListMapper $list):void 
    {
        //This method configures which fields are shown when all models are listed 
        //(the addIdentifier() method means that this field will link to the show/edit page of this particular
        // model);
        
        $list->addIdentifier('titre',null, [
            'label'=>'Titre de l\'article', ]) 
            //overider le template de la bannier       
            ->add('baniere_url')
            ->add('content')
            //->add('catégorie')
            ->add('categorie',EntityType::class,[
                'class' => Categories::class,
                'associated_property' => 'titre'])
            
            ->add('autheur',EntityType::class,[
                'class' => User::class,
                'associated_property' => 'email'])
                
            //->add('date')
            ->add('publie')
        ;
        

    }

protected function configureShowFields(ShowMapper $show):void 
    {
        //This method configures which fields are displayed on the show action.
        $show->add('titre',null, ['label'=>false])   
        //overider le template de la bannier      
        ->add('baniere_url',null, ['label'=>false])
        ->add('content',null, ['label'=>false])
        //Faire le OneToMany 
        //->add('categorie.titre')
        ->add('categorie[titre]',TextType::class)
        
        //show my relation
        ->add('autheur.email')
        //->add('date')
        ->add('publie',null, ['label'=>false])
        ;

        
    }
}
