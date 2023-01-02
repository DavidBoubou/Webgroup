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
use Sonata\AdminBundle\Form\Type\TemplateType;

//entity
use App\Entity\User;
use App\Entity\Categories;

//contrainst
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

//routes

use Sonata\AdminBundle\Route\RouteCollectionInterface;
use  Sonata\PageBundle\Admin\PageAdmin;
/*
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
*/

final class Adminarticles extends AbstractAdmin // PageAdmin AbstractAdmin
{
    //Activation du preview
    public $supportsPreviewMode = true;

 /*   public function toString(object $object): string
        {
            return $object instanceof MyEntity
                ? $object->getTitre()
                : 'Articles'; // shown in the breadcrumb on the create view
        }
*/

    protected function configureDashboardActions(array $actions): array
    {
        /*
                $actions['import'] = [
                'label' => 'import_action',
                'translation_domain' => 'SonataAdminBundle',
                'url' => $this->generateUrl('import'),
                'icon' => 'level-up-alt',
            ];
        */
        // $actions['import'] = ['template' => 'import_dashboard_button.html.twig'];
        //$actions['export'] ;
        return $actions;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        //Le bouton d'exportation se trouve sur la page list.
        $collection->add('export') 
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
                'controller' =>  'App\Admin\Action\MergeController::batchMergeAction' 
            ];
    
        return $actions;
    }

/*Utliser la métode dun  forbuilder pour les arguements.*/

protected function configureFormFields(FormMapper $form):void 
    {
        // This method configures which fields are displayed on the edit and create actions. 
        //The FormMapper behaves similar to the FormBuilder of the Symfony Form component;
        $form ->with('Détails de l\'articles', array('class' => 'col-md-12'))
        ->add('title',TextType::class,[
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
            ->end()




        ->with('configuration avancée', array('class' => 'col-md-12'))
        //configurer les modelType
        ->add('categorie',ModelAutocompleteType::class, [
            //Relation ManyToMany
            'multiple' =>true,
            'btn_add'=>true,
            //propriété sur les recherche
            'property' => ['title'],
            'required' => false])


            
        /*->add('categorie',EntityType::class,[
            'class' => Categories::class,
            'choice_label' => 'title'])
            */
       /*->add('autheur',EntityType::class,[
            'class' => User::class,
            'choice_label' => 'email'])
        */

        //->add('autheur')

        //->add('date', DatePickerType::class)
        ->add('publie',  CheckboxType::class, [
            'label'    => 'publié ',
            'required' => false,
        ])
        ->end()
        ;

        //SEO
        $form->with('seo', ['class' => 'col-md-6'])->end();
        if (null === $page || !$page->isHybrid()) {
            $form
                ->with('seo')
                    ->add('slug', TextType::class, ['required' => false])
                    ->add('customUrl', TextType::class, ['required' => false])
                ->end();
        }

        $form
            ->with('seo', ['collapsed' => true])
                ->add('title', null, ['required' => false])
                ->add('metaKeyword', TextareaType::class, ['required' => false])
                ->add('metaDescription', TextareaType::class, ['required' => false])
            ->end();

    }

protected function configureDatagridFilters(DatagridMapper $datagrid):void
    {
        // This method configures the filters, used to filter and sort the list of models;
        $datagrid->add('title',null,[
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
        
        $list->addIdentifier('title',null, [
            'label'=>'Titre de l\'article', 'editable'=>true]) 

            //overider le template de la bannier  
            ->add('baniere_url', TemplateType::class, [
                'label' => 'Banière',
                'template'   => 'Admin/field/image_field.html.twig',
            ])  

            ->add('content')
            
            ->add('categorie',EntityType::class,[
                'class' => Categories::class,
                'associated_property' => 'titre'])
            
            /*->add('autheurs',EntityType::class,[
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
        $show->add('title')   

        //overider le template de la bannier      
        //->add('baniere_url')
        ->add('baniere_url', TemplateType::class, [
            'label' => 'Banière',
            'template'   => 'Admin/field/image_field.html.twig',
        ])  

        ->add('content')

        //Faire le OneToMany 
        ->add('categorie')
        
        //show my relation
        ->add('autheur')

        //->add('date')
        ->add('publie')
        ;
        
    }

    //Exporter les champs et les associations.
    protected function configureExportFields(): array
        {
           return ['title', 'content', 'autheur'];
        }

    //Format d'exportation
    public function getExportFormats(): array
        {
            //return a format html and pdf
            return ['csv'];
        }

      /*    
    public function  postPersist(object $user): void
        {
          if($user instanceof User)
            {

            }
           
        } */
    
}
