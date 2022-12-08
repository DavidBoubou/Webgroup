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
//toOneRelation
use Sonata\AdminBundle\Form\Type\ModelListType;
//ToMany or ManyToMany
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;


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
    //Activation du preview
    public $supportsPreviewMode = true;

    protected function configureDashboardActions(array $actions): array
    {
       // $actions['export'] ;
        return $actions;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {

        $collection->add('export') //Le bouton d'exportation se trouve sur la page list.
                    ->add('merge')
                    ->add('clone', $this->getRouterIdParameter().'/clone');
        // Removing the list route will disable listing entities.
        //Désactive la page list de l'entité
        //$collection->remove('delete');

    }


    
    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'articles';
    }
    

    protected function configureBatchActions(array $actions): array
    {

        $actions['merge'] = [
                'ask_confirmation' => true,
                'controller' =>  'App\Admin\Controller\MergeController::batchMergeAction' 
            ];
    
        return $actions;
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
        /*->add('categorie',ModelAutocompleteType::class, [
            //Relation ManyToMany
            'multiple' =>true,
            'btn_add'=>true,
            //propriété sur les recherche
            'property' => ['titre'],
            'required' => false])
            */
        /*->add('categorie',EntityType::class,[
            'class' => Categories::class,
            'choice_label' => 'titre'])
            */
    /*    ->add('autheur',EntityType::class,[
            'class' => User::class,
            'choice_label' => 'email'])
    */    

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
                //->add('autheurs')                
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
            'label'=>'Titre de l\'article', 'editable'=>true]) 
            //overider le template de la bannier       
            ->add('baniere_url',null,['editable'=>true])
            ->add('content')
            //->add('catégorie')
            ->add('categorie',EntityType::class,[
                'class' => Categories::class,
                'associated_property' => 'titre'])
            
           /* ->add('autheurs',EntityType::class,[
                'class' => User::class,
                'associated_property' => 'email'])
             */   
            //->add('date')
            ->add('publie',null,['editable'=>true])

            // actions sur les lignes
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'clone' => [
                        'template' => 'CRUD/list__action_clone.html.twig',
                    ],
                ]
            ]);

    }

protected function configureShowFields(ShowMapper $show):void 
    {
        //This method configures which fields are displayed on the show action.
        $show->add('titre',null, ['label'=>false,'editable'=>true])   
        //overider le template de la bannier      
        ->add('baniere_url',null, ['label'=>false])
        ->add('content',null, ['label'=>false])
        //Faire le OneToMany 
        //->add('categorie.titre')
        ->add('categorie[titre]',TextType::class)
        
        //show my relation
        //->add('autheurs')
        //->add('date')
        ->add('publie',null, ['label'=>false,'editable'=>true])
        ;

        
    }

    //Exporter les champs et les associations.
    protected function configureExportFields(): array
        {
          //  return ['titre', 'content', 'autheurs'];
        }

    //Format d'exportation
    public function getExportFormats(): array
        {
            //return a format html and pdf
            return ['csv'];
        }

        /*
            public function  postPersist($object)
            {

            }
      */
}
