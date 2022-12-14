/**

Sonata est un bundle pour l'interface administrateur possédant des fonctions clés (configureFormFields,configureDatagridFilters, configureListFields, configureShowFields) et dont le système est basé sur les fonctions du formulaires  (add()) et leur types de champs et les entité.

Des pages existantes (edit, create, list, delete, show, export, batch)

Possibilité de créer un dashboard, puis un back-office et une page de recherche perosnnalisé, faire leur template, et donner des permission.

template route:vendor/sonata-project/admin-bundle/src/Resources/views/CRUD/base_show.html.twig

Gestion des utlisateurs
Gestion de la SEO
Gestion du contenu

 */

# Methode
- template du dashboard
- definir le nom du menu et son template pour le choix du bundle
- definir les actions sur chaque entité du dashboard
- Definir les droits sur les actions/route et la visibilité du contenu
- struturer ou nomifier les urls
- Definition de la base de données (mongo/mysql)
- Definition des types de champs et des relation

# Know Sonata

## Configuration SonataAdmin / les templates overridé
@see vendor\sonata-project\admin-bundle\src\Resources\views
>>> config/packages/sonata_admin.yaml
// Default configuration for extension with alias: "sonata_admin"
sonata_admin:
    security:
        handler: sonata.admin.security.handler.noop

        role_admin: ROLE_ADMIN
        role_super_admin: ROLE_SUPER_ADMIN

        information:

            # Prototype
            id: []
        admin_permissions:

            # Defaults:
            - CREATE
            - LIST
            - DELETE
            - UNDELETE
            - EXPORT
            - OPERATOR
            - MASTER
        object_permissions:

            # Defaults:
            - VIEW
            - EDIT
            - HISTORY
            - DELETE
            - UNDELETE
            - OPERATOR
            - MASTER
            - OWNER
        acl_user_manager: null
    title: 'Sonata Admin'
    title_logo: bundles/sonataadmin/images/logo_title.png
    search: true
    default_controller: 'sonata.admin.controller.crud'
    options:
        html5_validate: true

        # Auto order groups and admins by label or id
        sort_admins: false
        confirm_exit: true
        js_debug: false
        skin: 'skin-black'
        use_select2: true
        use_icheck: true
        use_bootlint: false
        use_stickyforms: true
        pager_links: null
        form_type: 'standard' # One of "standard"; "horizontal"
        default_admin_route: show
        default_group: default
        default_translation_domain: SonataAdminBundle
        default_icon: 'fas fa-folder'
        dropdown_number_groups_per_colums:  2
        logo_content: 'all' # One of "text"; "icon"; "all"
        list_action_button_content: 'all' # One of "text"; "icon"; "all"

        # Enable locking when editing an object, if the corresponding object manager supports it.
        lock_protection: false
    dashboard:
        groups:

            # Prototype
            id:
                label: ~
                translation_domain: ~
                icon: ~
                provider: ~
                items:
                    admin: ~
                    label: ~
                    route: ~
                    route_params: []
                roles: []
        blocks:
            type: ~
            roles: []
            settings:

                # Prototype
                id: ~
            position: right
            class: col-md-4

    default_admin_services:
        model_manager: null
        data_source: null
        form_contractor: null
        show_builder: null
        list_builder: null
        datagrid_builder: null
        translator: null
        configuration_pool: null
        route_generator: null
        validator: null
        security_handler: null
        label: null
        menu_factory: null
        route_builder: null
        label_translator_strategy: null
        pager_type: null

    templates:
        user_block: '@SonataAdmin/Core/user_block.html.twig'
        add_block: '@SonataAdmin/Core/add_block.html.twig'
        layout: '@SonataAdmin/standard_layout.html.twig'
        ajax: '@SonataAdmin/ajax_layout.html.twig'
        dashboard: '@SonataAdmin/Core/dashboard.html.twig'
        search: '@SonataAdmin/Core/search.html.twig'
        list: '@SonataAdmin/CRUD/list.html.twig'
        filter: '@SonataAdmin/Form/filter_admin_fields.html.twig'
        show: '@SonataAdmin/CRUD/show.html.twig'
        show_compare: '@SonataAdmin/CRUD/show_compare.html.twig'
        edit: '@SonataAdmin/CRUD/edit.html.twig'
        preview: '@SonataAdmin/CRUD/preview.html.twig'
        history: '@SonataAdmin/CRUD/history.html.twig'
        acl: '@SonataAdmin/CRUD/acl.html.twig'
        history_revision_timestamp: '@SonataAdmin/CRUD/history_revision_timestamp.html.twig'
        action: '@SonataAdmin/CRUD/action.html.twig'
        select: '@SonataAdmin/CRUD/list__select.html.twig'
        list_block: '@SonataAdmin/Block/block_admin_list.html.twig'
        search_result_block: '@SonataAdmin/Block/block_search_result.html.twig'
        short_object_description: '@SonataAdmin/Helper/short-object-description.html.twig'
        delete: '@SonataAdmin/CRUD/delete.html.twig'
        batch: '@SonataAdmin/CRUD/list__batch.html.twig'
        batch_confirmation: '@SonataAdmin/CRUD/batch_confirmation.html.twig'
        inner_list_row: '@SonataAdmin/CRUD/list_inner_row.html.twig'
        outer_list_rows_mosaic: '@SonataAdmin/CRUD/list_outer_rows_mosaic.html.twig'
        outer_list_rows_list: '@SonataAdmin/CRUD/list_outer_rows_list.html.twig'
        outer_list_rows_tree: '@SonataAdmin/CRUD/list_outer_rows_tree.html.twig'
        base_list_field: '@SonataAdmin/CRUD/base_list_field.html.twig'
        pager_links: '@SonataAdmin/Pager/links.html.twig'
        pager_results: '@SonataAdmin/Pager/results.html.twig'
        tab_menu_template: '@SonataAdmin/Core/tab_menu_template.html.twig'
        knp_menu_template: '@SonataAdmin/Menu/sonata_menu.html.twig'
        form_theme: []
        filter_theme: []

    assets:
        stylesheets:

            # The default stylesheet list:
            - bundles/sonataadmin/app.css

        # stylesheet paths to add to the page in addition to the list above
        extra_stylesheets: []

        # stylesheet paths to remove from the page
        remove_stylesheets: []

        javascripts:

            # The default javascript list:
            - bundles/sonataadmin/app.js

        # javascript paths to add to the page in addition to the list above
        extra_javascripts: []

        # javascript paths to remove from the page
        remove_javascripts: []

    extensions:

        # Prototype
        id:
            global: false
            admins: []
            excludes: []
            implements: []
            extends: []
            instanceof: []
            uses: []

    persist_filters: false
    filter_persister: sonata.admin.filter_persister.session
    show_mosaic_button: true

    global_search:
        empty_boxes: show
        admin_route: show

    breadcrumbs:
        child_admin_route: show


## class sonata

class -->	                    definition
ConfigurationPool -->	        configuration pool where all Admin class instances are stored
ModelManager -->	            handles specific code relating to your persistence layer (e.g. Doctrine ORM)
DataSource -->	                handles code related to the sonata exporter
FormContractor -->	            builds the forms for the edit/create views using the Symfony FormBuilder
ShowBuilder -->	                builds the show fields
ListBuilder -->	                builds the list fields
DatagridBuilder -->	            builds the filter fields
Request  -->		            the received http request
RouteBuilder -->	            allows you to add routes for new actions and remove routes for default actions
RouterGenerator	 -->	        generates the different URLs
SecurityHandler	 -->	        handles permissions for model instances and actions
Validator	 -->	            handles model validation
Translator	 -->	            generates translations
LabelTranslatorStrategy	 -->	a strategy to use when generating labels
MenuFactory -->		            generates the side menu, depending on the current action


## Debug
php bin/console sonata:admin:list
php bin/console sonata:admin:explain name_route_list

# Installation du bundle Sonata sur Mysql (voir NoSql)
>>> installation de admin et de la base de donné.
composer require sonata-project/admin-bundle
composer require sonata-project/doctrine-orm-admin-bundle
php bin/console cache:clear
php bin/console assets:install

## Activer les blocks d'affichage
>>> config/packages/sonata_admin.yaml

sonata_block:
    blocks:
        # enable the SonataAdminBundle block
        sonata.admin.block.admin_list:
            contexts: [admin]

## activer la traduction
>>> config/packages/framework.yaml

framework:
    translator: { fallbacks: ['%locale%'] }

## Definir la  route racine de page d accueil admin de Sonata (admin/dashboard)
>>> config/routes/sonata_admin.yaml

admin_area:
    resource: '@SonataAdminBundle/Resources/config/routing/sonata_admin.xml'
    prefix: /admin

_sonata_admin:
    resource: .
    type: sonata_admin
    prefix: /admin

# Créer le cahier de charge d'administration
https://docs.sonata-project.org/projects/SonataAdminBundle/en/4.x/getting_started/creating_an_admin/


## 1- Créer une classe admin (page admin) pour un model ayant des fonctions natifs
/**
    Sonata n'utilise pas d'abstractType
 */

### 1.1 base des pages Adminitrateur/ pageadmin pour un service
- Créer l 'entité
> php bin/console make:entity
>>>src/Entity/ClassName
final class ClassNAme
{
    //Afficher le titre de l'entité si il existe
      public function __toString()
        {
            return $this->getTitle() ?: '';
        }
    //code ...
}

//Définisser la page admin de la ClassName Entity
>> php bin/console make:sonata:admin App/Entity/ClassName
>>>admin/AbstractAdmin.php
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Filter\Model\FilterData;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType
use App\Admin\EntityType;
use Sonata\UserBundle\Form\Type\SecurityRolesType;
/*
with configureFormFields() choose 'choice_label' with the form entityType
with configureListFields() choose 'associated_property' with the form entityType
with configureShowFields(), configureDatagridFilters() choose  ->add('Entity_Field.field_name') with relationnal field
*/

final class admin extends AbstractAdmin
{

    //0- Change the string which appears on create Entity action
    public function toString(object $object): string
        {
            return $object instanceof MyEntity
                ? $object->getTitle()
                : 'Blog Post'; // shown in the breadcrumb on the create view
        }

    //0.1-Recupéré une requuetre (Post/GET)  
    protected function configurePersistentParameters(): array
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'provider' => $this->getRequest()->get('provider'),
            'context'  => $this->getRequest()->get('context', 'default'),
        ];
    }

//Utliser la méthode des  formbuilder pour la gestion des argurments de ces hooks.
// 1- This method configures which fields are displayed on the edit and create actions. The FormMapper behaves similar to the FormBuilder of the Symfony Form component; 
//Formulaire pour créer des objetCréer
protected function configureFormFields(FormMapper $form): void
    {       
        //Definir un group d affichage de titre content avec une class col-md-9
       $form
            ->with('Management')
                ->add('roles', SecurityRolesType::class, ['multiple' => true])
                ->add('locked', null, ['required' => false])
                ->add('expired', null, ['required' => false])
                ->add('enabled', null, ['required' => false])
                ->add('credentialsExpired', null, ['required' => false])
            ->end()
       
       ->with('Content', ['class' => 'col-md-9',
                    // class you can use for your box content (width)
                    'box_class'   => 'box box-solid box-danger',
                    //Description en header de la box
                    'description' => 'Lorem ipsum',])

            // champs name de type test
            ->add('name', TextType::class)

            //Réorguaniser les champs            
            ->reorder([
                'url',
                'position'
            ])

            // "privateNotes" field will be rendered only if the authenticated
            // user is granted with the "ROLE_ADMIN_MODERATOR" role
            ->add('privateNotes', null, [], [
                'role' => 'ROLE_ADMIN_MODERATOR'
            ])


            // conditionally add "status" field if the subject already exists
            // `ifFalse()` is also available to build this kind of condition
            ->ifTrue($this->hasSubject())
                ->add('status')
            ->ifEnd()

            //charger un media
            ->add('binaryContent', 'file', ['required' => false]);

            //champs étant un tableau contenant des multiples type de valeur (content,public,type)
            ->add('settings', ImmutableArrayType::class, [
                'keys' => [
                    ['content', 'textarea', []],
                    ['public', 'checkbox', []],
                    ['type', 'choice', ['choices' => [1 => 'type 1', 2 => 'type 2']]]
            ]);
            ->end();

        //Definir une tab Post avec  group d affichage de titre Meta data et de class col-md-3
        //With the tab you can manage more content
         $form->tab('Post')
                ->with('Meta data', ['collapsed' => true])
                // ...
                ->end()
             ->end()


    ;
    }

// 2-This method configures the filters and search by 'field_name', used to filter and sort the list of models;
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        //Mettre le filtre toujours visibe (même si il est inactive),
        $datagrid->add('name', null, [
            'show_filter' => true
        ])

        //champs avec function de callback pour gérer la query et la valeur du filtre
        //Dangereux : Callback filter
        ->add('full_text', CallbackFilter::class /** callbackfilter  is a filter */, [
            //Appel de la fonction getfulltextfilter
            'callback' => [$this, 'getFullTextFilter'],
            //Type du champs
            'field_type' => TextType::class,
        ])

        //cahcer l'opérateur de trie 
        ->add('bar', null, [
            'operator_type' => 'hidden', # ou changer le type d'operateur en 'sonata_type_boolean' ou sonata_type_equal
            'advanced_filter' => false  desactiver le filtre sur le champs (appliquer sur tout les champs pour annuler le filtrage)
        ])

        //L'utilisateur décide de quel champs sera afficher/filtrer
        $datagrid->add('name2')
        
        //champs entité relationnel
        ->add('autheur',EntityType::class,[
                'class' => User::class,
                'associated_property' => 'email'])

        ->add('category', null, [
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    // used to render a select box, check boxes or radios
                    // 'multiple' => true,
                    // 'expanded' => true,
                ],
            ]);
    }

//2.2.-optionnal callback function from my configureDatagridFilters

    public function getFullTextFilter(ProxyQueryInterface $query, string $alias, string $field, FilterData $data): bool
    {
        if (!$data->hasValue()) {
            return false;
        }

        //use Sonata\Form\Type\EqualType with the var TYPE_IS_EQUAL 
        $operator = $data->isType(EqualType::TYPE_IS_EQUAL) ? '=' : '!=';

        $query
         // Use `andWhere` instead of `where` to prevent overriding existing `where` conditions
            ->andWhere($alias.'.username '.$operator.' :username')
            ->setParameter('username', $data->getValue())
        ;

        return true;
    }


//3-This method configures which fields are shown when all models are listed (the addIdentifier() method means that this field will link to 
//the show/edit page of this particular model);
    protected function configureListFields(ListMapper $list): void
    {
        //Le name dirige vers le contenu  de l'entité
        $list->->addIdentifier('name', null, [
                'route' => [
                    //url de la page de directiion :show
                    'name' => 'show'
                ]
            ])

            //Afficher le nom de lentité de relation catégorie
            ->add('category.name')

            //Montrer uniquement l'icon du champs
            ->add('upvotes', null, [
                        'label' => false,
                        'label_icon' => 'fas fa-thumbs-up',
                    ])

            //Champs virtuel n'existant pas dans le Model dont la donné sera touhours null
            ->add('thisPropertyDoesNotExist', null, [
                            # Definie un champs virtuel et son url
                            'virtual_field' => true,
                            'template' => 'path/to/your/template.html.twig'
                        ])

            //Stylisation personnalisé du champs (header_style, header_class, row_align,collapse, label_icon)
            ->add('id', null, [
                'label' => 'name',                              # or 'false' to not display
            'header_style' => 'width: 5%; text-align: center',  # style css (sans classe css)
            'row_align' => 'center',                            # left, center, right
            'label_icon' => 'fas fa-thumbs-up',                 #fontawesome
            'collapse' =>                                       # or 'true'
                            [
                                // height in px
                                'height' => 40,

                                // content of the "read more" link
                                'more' => 'I want to see the full description',

                                // content of the "read less" link
                                'less' => 'This text is too long, reduce the size',
                            ]
        ])

            //Overrider le template d'un champs MyField_name de la page liste
            ->add('Myfield_name', FieldDescriptionInterface::TYPE_STRING, ['template' => '@SonataMedia/MediaAdmin/list_Myfield_name.html.twig'])
             
        /** 
        //the 'field' link to the 'edit' page entity
         $list->addIdentifier('field', null, [
                 'route' => [
                    //nom de la route pour voir l'entité
                     'name' => 'edit'
                 ]
             ]);
        */

  // you may specify the field type directly as the
        // second argument instead of in the options
        ->add('isVariation', FieldDescriptionInterface::TYPE_BOOLEAN)

        // if null, the type will be guessed
        // le champs est éditable depuis la page list
        ->add('enabled', null, [
            'editable' => true
        ])

        // editable association field
        ->add('status', FieldDescriptionInterface::TYPE_CHOICE, [
            'editable' => true,
            'class' => 'Vendor\ExampleBundle\Entity\ExampleStatus',
            'choices' => [
                1 => 'Active',
                2 => 'Inactive',
                3 => 'Draft',
            ],
        ])

        // editable multiple field
        ->add('winner', FieldDescriptionInterface::TYPE_CHOICE, [
            'editable' => true,
            'multiple' => true,
            'choices' => [
                'jury' => 'Jury',
                'voting' => 'Voting',
                'encouraging' => 'Encouraging',
            ],
        ])

        // we can add options to the field depending on the type
        ->add('price', FieldDescriptionInterface::TYPE_CURRENCY, [
            'currency' => $this->currencyDetector->getCurrency()->getLabel()
        ])

        // Here we specify which property is used to render the label of each entity in the list
        ->add('productCategories', null, [
            'associated_property' => 'name'
            // By default, sorting will be done on the associated property.
            // To sort on another property, add the following:
            'sort_field_mapping' => [
                'fieldName' => 'weight',
            ],
        ])

        // you may also use dotted-notation to access
        // specific properties of a relation to the entity
        ->add('image.name')

        // you may also use a custom accessor
        ->add('description1', null, [
            'accessor' => 'description'
        ])
        ->add('description2', null, [
            'accessor' => function ($subject) {
                return $this->customService->formatDescription($subject);
            }
        ])
            //Liste des actions par lignes
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ]);

        // You may also specify the actions you want to be displayed in the list
        ->add(ListMapper::NAME_ACTIONS, null, [
            'actions' => [
                'show' => [],
                'edit' => [
                    // You may add custom link parameters used to generate the action url
                    'link_parameters' => [
                        'full' => true,
                    ]
                ],
                'delete' => [],
            ]
        ])

    ;






            /**
                    @override templates
                    templates whitch is affect with the ListView .
                    list:                       '@SonataAdmin/CRUD/list.html.twig'
                    action:                     '@SonataAdmin/CRUD/action.html.twig'
                    select:                     '@SonataAdmin/CRUD/list__select.html.twig'
                    list_block:                 '@SonataAdmin/Block/block_admin_list.html.twig'
                    short_object_description:   '@SonataAdmin/Helper/short-object-description.html.twig'
                    batch:                      '@SonataAdmin/CRUD/list__batch.html.twig'
                    inner_list_row:             '@SonataAdmin/CRUD/list_inner_row.html.twig'
                    base_list_field:            '@SonataAdmin/CRUD/base_list_field.html.twig'
                    pager_links:                '@SonataAdmin/Pager/links.html.twig'
                    pager_results:              '@SonataAdmin/Pager/results.html.twig'
            
             */
    }


    //3.2- optionel: hook disable listing entities by removing the corresponding routes/page 
    protected function configureRoutes(RouteCollectionInterface $collection): void
        {
            // Si ma class est un Children alors desactiver l'action create 
            if ($this->hasParentFieldDescription()) {
                $collection->remove('create');
            }

            // Supprimer toute les routes a l'exeption de 'list' et 'edit'
            $collection->clearExcept(['list', 'edit']);

            // Supprimer toute les routes a l'exeption de 'list'.
            $collection->clearExcept('list');

             // All routes are removed
            $collection->clear();

            // Removing the list route will disable listing entities.
            //Désactive la page list de l'entité
            $collection->remove('list')

            //Restaureer une route ayant été désactivé
            $collection->restore('list')

            //Genere une route personnalisé associé a un CRUDController @voir créer une action
            $collection->add('myCustom') // Action gets added automatically

            //Genere un route view avec l'url 'admin/view/_action'
            $collection->add('view', $this->getRouterIdParameter().'/view')

            //Configuration aditionnel d'une route symfony
            $collection->add(
            'custom_action',
            $this->getRouterIdParameter().'/custom-action',
            [],
            [],
            [],
            '',
            ['https'],
            ['GET', 'POST']
        );

        }

    //3.3- optionnel configurer un filtre par défaut - configuration par défault d'un filtre
    protected function configureDefaultFilterValues(array &$filterValues): void
    {

        $filterValues['field_name'] = [
            //Voir tout les type d'opérateur (cllasName::constante)
            //(https://github.com/sonata-project/form-extensions/tree/1.x/src/Type)
            'type'  => ContainsOperatorType::TYPE_CONTAINS, #Type d'opération contient sinon (EqualType::TYPE_IS_EQUAL)

            //Valeur du filtre se renseigner sur les constatnte statique des class
            // (https://github.com/sonata-project/form-extensions/tree/1.x/src/Type)
            'value' => 'bar',  // valeur de chaine sinon boolean  selo le 'type'
        ];
    }


//4-This method configures which fields are displayed on the show action.
    protected function configureShowFields(ShowMapper $show): void
    {
        
        //Definir une tab Post avec  group d affichage de titre Meta data et de class col-md-3
        //With the tab you can manage more content
         $show->tab('Post')
                ->with('Meta data', ['collapsed' => true])
                $show->add('name');
                ->end()
             ->end()
    }

}


//Enregistrement de la class Admin
>>> config/services.yaml
services:
    # ...
  //Nom du service de la classe
    admin.category:
//chemin de la class
        class: App\Admin\CategoryAdmin
//optionnel overide le setLabelTranslatorStrategy
        calls:
            - [setLabelTranslatorStrategy, ['@sonata.admin.label.strategy.underscore']]
        tags:
//chemin du model et nom l'outils et du lablel de la classe.
            - { name: sonata.admin, model_class: App\Entity\Category, manager_type: orm, group: 'groupe_ContentOfCategory', label: Category, show_in_dashboard: false /** Ne pas montrer dans le menu du tableau de bord */, on_top: true /** ne pas montrer d'arboressence dans les élement enfant */ }

//Créer le schema de la base de donné
>>> console
php bin/console doctrine:schema:create


//option héritage admin --------------------------------------------
>>>> PersonAdmin extends ParentAdmin <<<<
use Sonata\AdminBundle\Show\ShowMapper;
//Hérite de ParentAdmin
final class PersonAdmin extends ParentAdmin
{
    //Appel de l'élement parent
    protected function configureShowFields(ShowMapper $show): void
    {
        //Appel de l'élement parent
        parent::configureShowFields($show);

        // remove one field
        $show->remove('field_to_remove');

        // remove a group from the "default" tab
        $show->removeGroup('GroupToRemove1');

        // remove a group from a specific tab
        $show->removeGroup('GroupToRemove2', 'Tab2');

        // remove a group from a specific tab and also remove the tab if it ends up being empty
        $show->removeGroup('GroupToRemove3', 'Tab3', true);
    }
}    

#### gestion des routes admin
//Voir toute les routes de 'admin.service.name'
bin/console sonata:admin:explain <<admin.service.name>>

Les urls de base sont de type: ‘admin_vendor_bundlename_entityname_actionType’

##### url des pages admin avec prefix_
If the admin class is a child of another admin class the route name will be prefixed by the parent route name, example:
>>> src/Admin/MyAbstractAdmin.php
protected function generateBaseRouteName(bool $isChildAdmin = false): string
    {
        //route prefix, to which an underscore and the action name will be added to generate the actual route names:
        return 'sonata_post';
            // will result in routes named:
            //   sonata_post_list
            //   sonata_post_create
            //   etc..

    }


##### url personnalisé des pages admin
//Générer une url personnalisé
>>> src/Admin/MyAbstractAdmin.php
    hook permettant de personnalisé une route
    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        //admin/foo
        return 'foo';
        //with result with action
        //http://yourdomain.com/admin/foo/list
        //http://yourdomain.com/admin/foo/1/edit
        //
        //http://yourdomain.com/admin/--EntityParent_post--/{postId}/EntityChild_comment/{commentId}/edit
    }


##### url admin dans un template
<a href="{{ admin.generateUrl('list') }}">List</a>
<a href="{{ admin.generateUrl('list', params|merge({'page': 1})) }}">List</a>
<a href="{{ path('admin_app_post_list') }}">Post List</a>

#### field
    Sonata\AdminBundle\Form\Type\ModelType
    Sonata\AdminBundle\Form\Type\ModelListType
    Sonata\AdminBundle\Form\Type\ModelHiddenType
    Sonata\AdminBundle\Form\Type\ModelAutocompleteType
    Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType
    Sonata\AdminBundle\Form\Type\AdminType
    Sonata\Form\Type\CollectionType
    Sonata\AdminBundle\Form\Type\CollectionType


#### field with custom template/ formulaire avec template personnalisé
>>> AbstractAdmin
use Sonata\AdminBundle\Form\Type\TemplateType;

final class PersonAdmin extends AbstractAdmin
 {
     protected function configureFormFields(FormMapper $form): void
     {
         $form
              ->add('title')
              ->add('googleMap', TemplateType::class, [
                  'template'   => 'path/to/your/template.html.twig'
                  'parameters' => [
                      'url' => $this->generateGoogleMapUrl($this->getSubject()),
                  ],
              ])
              ->add('streetname', TextType::class)
              ->add('housenumber', NumberType::class);
     }
 }

>>>templates/to/your/template.html.twig'

<a href="{{ url }}">{{ object.title }}</a>

#### field with relationship Many to One
>>> AbstractAdmin::configFormField()
            //Evite les erreurs
            ->add('category.name')
----------------------------------------------------
            /*
            Champs relationnel many users to one post
            the User list is set in a model where you can search, select and delete a User.
            */
           $form- ->add('author', ModelListType::class, [
                    'btn_add'       => 'Add author',       //Specify a custom label
                    'btn_list'      => 'button.list',      //which will be translated
                    'btn_delete'    => false,              //or hide the button.
                    'btn_edit'      => 'Edit',             //Hide add and show edit button when value is set
                    'btn_catalogue' => 'SonataNewsBundle', //Custom translation domain for buttons
                ], [
                    'placeholder' => 'No author selected',
                ]);
------------------------ or--------------------------------------
            /*
            Champs relationnel many users to one post
            the User list is set in a select widget with an Add button to create a new User,
            */
                $form->add('tags', ModelType::class, ['expanded' => true]);


#### field with relationship One to Many
// one galerie have many media 

            ->add('galleryHasMedias', CollectionType::class, [
                   // Prevents the "Delete" option from being displayed
                    'type_options' => ['delete' => false],
                   // 'btn_add ' => true,
                   // 'btn_catalogue' => true,
                    'by_reference' => false,
                ],
                [
                    'edit' => 'inline',/** the 'inline' mode allows you to add new rows*/
                    'inline' => 'table', /** the fields are displayed into 'table',*/
                    'sortable' => 'field_name', /*if the model has a position field, you can enable a drag and drop sortable effect by setting */
                    'limit' => 3, /** limits the number of elements that can be added */
            ]);


#### Spécial field (Datepicker , color, Array , OrderStatusType)

##### Datepicker x2

>>>config/packages/twig.yaml

twig:
    form_themes:
        - '@SonataForm/Form/datepicker.html.twig'

>>> AbstractAdmin::configureFormField
use Sonata\Form\Type\DatePickerType;
use Sonata\Form\Type\DateTimePickerType;

$formMapper
            ->add('publicationDateStart', DateTimePickerType::class, [
                //Configuration des option du datepeacker 1
                'dp_side_by_side'       => true,
                'dp_use_current'        => false,
                'dp_use_seconds'        => false,
                'dp_collapse'           => true,
                'dp_calendar_weeks'     => false,
                'dp_view_mode'          => 'days',
                'dp_min_view_mode'      => 'days',
                //atepicker icon is not shown and the pop-up datepicker is invoked simply by clicking on the date input
                datepicker_use_button   => true,
            ])

            // or DatePickerType if you don't need the time
            ->add('publicationDateStart', DatePickerType::class);

>>>js or twig

    <script type="text/javascript" src="path_to_jquery.min.js"></script>
    <script type="text/javascript" src="/bundles/sonataForm/vendor/moment/min/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="path_to_bootstrap.min.js"></script>
    <script type="text/javascript" src="/bundles/sonataForm/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="path_to_bootstrap.min.css"/>
    <link rel="stylesheet" href="/bundles/sonataForm/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"/>


##### color piker 

>>> AbstractAdming::configureForm
use Sonata\Form\Type\ColorType;

$formMapper
            ->add('color', ColorType::class);

>>>config/packages/twig.yaml

twig:
    form_themes:
        - '@SonataForm/Form/color.html.twig'


### 1.2 Créer un childAdmin (relation par url entre une class et une autre class admin)

Déclarer une class admin 2 (VideoAdmin) comme enfant d'une class admin 1 (PlaylistAdmin) créera une nouvel route (/playlist/{id}/video/list) ou les video (class 2) seront filtrer automatiquement.

// Déclaration du childadmin 
>>> config/services.yaml
App\Admin\className2_VideoAdmin:
    # tags, calls, etc

App\Admin\className1_PlaylistAdmin:
    calls:
        - [addChild, ['@App\Admin\className2_VideoAdmin', 'playlist']]
        # Or `[addChild, ['@App\Admin\className2_VideoAdmin']]` if there is no
        # field to access the Playlist from the Video entity

>>> config/services.xml 
<service id="App\Admin\className2_VideoAdmin">
    <!-- tags, calls, etc -->
</service>
<service id="App\Admin\className1_PlaylistAdmin">
    <!-- ... -->

    <call method="addChild">
        <argument type="service" id="App\Admin\className2_VideoAdmin"/>
        <argument>playlist</argument>
    </call>
</service>


//Construction du childadmin
//Element mère
>>>admin/className1_PlaylistAdmin extends AbstractAdmin
namespace App\Admin;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;

protected function configureTabMenu(MenuItemInterface $menu, string $action, ?AdminInterface $childAdmin = null): void
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $menu->addChild('View Playlist', $admin->generateMenuUrl('show', ['id' => $id]));

        if ($this->isGranted('EDIT')) {
            $menu->addChild('Edit Playlist', $admin->generateMenuUrl('edit', ['id' => $id]));
        }

        if ($this->isGranted('LIST')) {
            $menu->addChild('Manage Videos', $admin->generateMenuUrl('App\Admin\VideoAdmin.list', ['id' => $id]));
        }
    }

//Element cible
>>>admin/className2_VideoAdmin.php extends AbstractAdmin 
namespace App\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        if ($this->isChild()) {
            return;
        }

        // This is the route configuration as a parent
        $collection->clear();

    }





### 1.3 Option de configuration (template, librairie et outils interne) d'une page admin
@see @see vendor\sonata-project\admin-bundle\src\Resources\views
>>> config/packages/sonata_admin.yaml
sonata_admin:
    options:
        html5_validate:  true     # enable or disable html5 form validation
        confirm_exit:    true     # enable or disable a confirmation before navigating away
        js_debug:        false    # enable or disable to show javascript debug messages
        use_select2:     true     # enable or disable usage of the Select2 jQuery library
        use_icheck:      true     # enable or disable usage of the iCheck library
        use_bootlint:    false    # enable or disable usage of Bootlint
        use_stickyforms: true     # enable or disable the floating buttons
        form_type:       standard # can also be 'horizontal'

    templates:
        edit:              '@SonataAdmin/CRUD/edit.html.twig'
        tab_menu_template: '@SonataAdmin/Core/tab_menu_template.html.twig'

## 2- Dashborad Admin Landing page et menu

 ### Contex
//Configurer le contenu et le layout du tableau de bord landing page
//lien /admin/dashboard
//sonata.admin.block.admin_list est le service qui list les Model Administrateur au tableau de bord dont le template est
//@SonataAdmin/Block/block_admin_list.html.twig
//gestion des droit de visibilité de certain bloc de vue
//Il y a plusieur type de bloc permettant des type de contenue sur le dashboard
// Le nom des Menu déroulant est le nom des groupes définie dans service.yaml

#### One side (easiest) definition des groups et traduction
//Le 'group' tag est tres important.
//Cette configuration overide les autres
>>> config/packages/sonata_admin.yaml
sonata_admin:
    dashboard:
    # Definition d'un ou de plusieurs group
        groups:
            app.admin.group.content:
                label: app.admin.group.content
                # domaine de traduction
                translation_domain: App
                # service(Model) implémenter au tableau de bord (voir services.yml)
                items:
                    - app.admin.post    # Liste le model dont le service est app.admin.post (service.yml)

            app.admin.group.blog:
                items:
                    - sonata.admin.page # Liste les model manquants
                roles: ['ROLE_ONE', 'ROLE_TWO'] # droit du group app.admin.group.blog

            app.admin.group.misc: ~ # group contenu vide de configuration basique (service.yml)

#### otherside (harder) definition des groupes et traductions par défault
//Declarer l'interface administrateur en donnant un group
>>> config/services.yaml
services:
    app.admin.post:
        class: App\Admin\PostAdmin
        tags:
            - { name: sonata.admin, model_class: App\Entity\Post, manager_type: orm, /** tres important*/group: 'Content', label: 'Post' }

>>> config/services.xml
<service id="app.admin.post" class="App\Admin\PostAdmin">
      <tag name="sonata.admin" model_class="App\Entity\Post" manager_type="orm" group="Content" label="Post"/>
  </service>

>>>  config/services.yaml <<<
//autres structure pour multilangue (translattion domaine)
services:
    app.admin.post:
        class: App\Admin\PostAdmin
        tags:
            - name: sonata.admin
              model_class: App\Entity\Post
              manager_type: orm
              group: 'app.admin.group.content'
              translation_domain: 'App'
              label: 'app.admin.model.post'

>>> config/services.xml <<<
//autres structure pour multilangue (translattion domaine)
<service id="app.admin.post" class="App\Admin\PostAdmin">
      <tag
          name="sonata.admin"
          model_class="App\Entity\Post"
          manager_type="orm"
          group="app.admin.group.content"
          translation_domain="App"
          label="app.admin.model.post"
          />
  </service>

 ### Configurer Layout dashboard et bloc personnalisé
>>> config/packages/sonata_admin.yaml
sonata_admin:
    dashboard:
    # Initialisation
        blocks:
            -   # block 1
                position: left  #position
                class: col-md-6 # Class du bloc
                type: sonata.admin.block.admin_list #type de bloc (liste les models selon la configuration service ou sonataAdmin)
            -   # block 2
                position: right #position
                type: sonata.block.service.text #type de bloc (text HTML)
                settings:   #configurationn du type de bloc (text HTML)
                    content: >
                        <h2>Welcome to the Sonata Admin</h2>
                        <p>This is a <code>sonata.block.service.text</code> from the Block
                        Bundle, you can create and add new block in these area by configuring
                        the <code>sonata_admin</code> section.</p> <br/> For instance, here
                        a RSS feed parser (<code>sonata.block.service.rss</code>):
            -   # block 3
                position: right #position
                type: sonata.block.service.rss  #type du bloc (rss)
                roles: [POST_READER]    # Role pour voir le blog 
                settings:   # configuration du rss
                    title: Sonata Project's Feeds
                    url: https://sonata-project.org/blog/archive.rss

            -   # block 4
                position: top                              # (position) zone in the dashboard
                type:     sonata.admin.block.admin_preview # un preview des Model Admin (block id)
                settings:
                    code:  sonata.page.admin.page          # admin code - service id
                    icon:  fas fa-magic                     # font awesome icon
                    limit: 10
                    text:  Latest Edited Pages
                    filters:                               # (filtrer le contenu) /filter values
                        edited:      { value: 1 }
                        _sort_by:    updatedAt
                        _sort_order: DESC
            -   # block 5
                class:    col-lg-3 col-xs-6          #  bootstrap responsive code
                position: top                        # position zone in the dashboard
                type:     sonata.admin.block.stats   # block id
                settings:
                    code:  sonata.page.admin.page    # admin code - service id
                    icon:  fas fa-magic              # font awesome icon
                    text:  app.page.stats            # static text or translation message
                    color: bg-yellow                 # colors: bg-green, bg-red and bg-aqua
                    filters:                         # filter values
                        edited: { value: 1 }
            -   # block 6
                position: left                        # position zone in the dashboard
                type: sonata.admin.block.admin_list   # pAffichage de tout les models
                settings:
                    groups: [sonata_page1, sonata_page2]    # the group  witch display in the block 6
        # Declaration of group of Model/items/services
        groups:
                    sonata_page1:
                        items:
                            - sonata.page.admin.myitem1

                    sonata_page2:
                        items:
                            - sonata.page.admin.myitem2
                            - sonata.page.admin.myitem3                   
/**---- Position ---
TOP     TOP     TOP

 LEFT CENTER RIGHT
 LEFT CENTER RIGHT
 LEFT CENTER RIGHT

BOTTOM BOTTOM BOTTOM

 */

 ### Actions sur le tableau de bord

 #### Caché un bouton du dashboard sans le désactivé
 >>> AbstractAdmin.php
    protected function configureDashboardActions(array $actions): array
    {
        $actions = parent::configureDashboardActions();

        unset($actions['list']);

        return $actions;
    }

 #### Afficher un bouton d'action en plus dans le dashboard
 >>> AbstractAdmin.php

     protected function configureDashboardActions(array $actions): array
    {
        //Nom de l'action et configuration
        $actions['import'] = [
            'label'              => 'Import',
            'url'                => $this->generateUrl('import'),
            'icon'               => 'import',
            'translation_domain' => 'SonataAdminBundle', // optional
            'template'           => '@SonataAdmin/CRUD/dashboard__action.html.twig', // optional
        ];

        return $actions;
    }

 #### Désactivé un bouton des models



## 3-Search page
//Afficher les Model ayant un résultat sinon personnalisé la Query.
//LIKE %query% OR LIKE %query%

### template
>>> onfig/packages/sonata_admin.yaml
sonata_admin:
    templates:
        # other configuration options
        search:              '@SonataAdmin/Core/search.html.twig'                   # template de la barre de recherche
        search_result_block: '@SonataAdmin/Block/block_search_result.html.twig'     # template du resultat de recherche

### Désactivation de la recherche sur un model/Entité
//Mettre global_search="false" 
>>> services.yml
<service id="app.admin.post" class="App\Admin\PostAdmin">
    <tag name="sonata.admin" global_search="false" model_class="App\Entity\Post" manager_type="orm" group="Content" label="Post"/>
</service>

### Gestion des option la recherche
>>>config/packages/sonata_admin.yaml
sonata_block:
    # Activer le block de résultat de barre de recherche
    blocks:
        sonata.admin.block.search_result:
            contexts: [admin]
    # Permettre la modification du contenu du résultat
    global_search:
        admin_route: edit
        #Faire disparaitre les blocks sans résultat
        empty_boxes: hide # utiliser fade pour une oppacité sur les bloc sans résultat

>>>service.xml <<<
<service id="app.admin.post" class="App\Admin\PostAdmin">
      <tag name="sonata.admin" model_class="App\Entity\Post" manager_type="orm" group="Content" label="Post"/>
      <call method="setTemplate">
          <argument>search_result_block</argument>
          <argument>@SonataPost/Block/block_search_result.html.twig</argument>
      </call>
  </service>

## Export


## 4- Créer un template d'administration

### Overider les pages (liste, edit, create, update,delete) et l'administration
>>> config/packages/sonata_admin.yaml

sonata_admin:
    templates:
        #defult template of the dashboard
        dashboard: '@SonataAdmin/Core/dashboard.html.twig'

        # default global templates
        layout:  '@SonataAdmin/standard_layout.html.twig'
        ajax:    '@SonataAdmin/ajax_layout.html.twig'

        # default value if done set, actions templates, should extend global templates
        list:    '@SonataAdmin/CRUD/list.html.twig'
        show:    '@SonataAdmin/CRUD/show.html.twig'
        edit:    '@SonataAdmin/CRUD/edit.html.twig'
        show_compare:               '@SonataAdmin/CRUD/show_compare.html.twig'
        history:                    '@SonataAdmin/CRUD/history.html.twig'
        preview:                    '@SonataAdmin/CRUD/preview.html.twig'
        delete:                     '@SonataAdmin/CRUD/delete.html.twig'
        batch:                      '@SonataAdmin/CRUD/list__batch.html.twig'
        acl:                        '@SonataAdmin/CRUD/acl.html.twig'
        action:                     '@SonataAdmin/CRUD/action.html.twig'
        select:                     '@SonataAdmin/CRUD/list__select.html.twig'
        filter:                     '@SonataAdmin/Form/filter_admin_fields.html.twig'
        search:                     '@SonataAdmin/Core/search.html.twig'
        batch_confirmation:         '@SonataAdmin/CRUD/batch_confirmation.html.twig'
        inner_list_row:             '@SonataAdmin/CRUD/list_inner_row.html.twig'
        base_list_field:            '@SonataAdmin/CRUD/base_list_field.html.twig'
        list_block:                 '@SonataAdmin/Block/block_admin_list.html.twig'
        user_block:                 '@SonataAdmin/Core/user_block.html.twig'
        add_block:                  '@SonataAdmin/Core/add_block.html.twig'
        pager_links:                '@SonataAdmin/Pager/links.html.twig'
        pager_results:              '@SonataAdmin/Pager/results.html.twig'
        tab_menu_template:          '@SonataAdmin/Core/tab_menu_template.html.twig'
        history_revision_timestamp: '@SonataAdmin/CRUD/history_revision_timestamp.html.twig'
        short_object_description:   '@SonataAdmin/Helper/short-object-description.html.twig'
        search_result_block:        '@SonataAdmin/Block/block_search_result.html.twig'
        action_create:              '@SonataAdmin/CRUD/dashboard__action_create.html.twig'
        button_acl:                 '@SonataAdmin/Button/acl_button.html.twig'
        button_create:              '@SonataAdmin/Button/create_button.html.twig'
        button_edit:                '@SonataAdmin/Button/edit_button.html.twig'
        button_history:             '@SonataAdmin/Button/history_button.html.twig'
        button_list:                '@SonataAdmin/Button/list_button.html.twig'
        button_show:                '@SonataAdmin/Button/show_button.html.twig'
        form_theme:                 []
        filter_theme:               []

### Overider les templates des types de champs des page (liste, edit, create, update,delete)
>>>>config/packages/sonata_doctrine_orm_admin.yaml

sonata_doctrine_orm_admin:
    templates:
        types:
            list:
                array:      '@SonataAdmin/CRUD/list_array.html.twig'
                boolean:    '@SonataAdmin/CRUD/list_boolean.html.twig'
                date:       '@SonataAdmin/CRUD/list_date.html.twig'
                time:       '@SonataAdmin/CRUD/list_time.html.twig'
                datetime:   '@SonataAdmin/CRUD/list_datetime.html.twig'
                text:       '@SonataAdmin/CRUD/base_list_field.html.twig'
                trans:      '@SonataAdmin/CRUD/list_trans.html.twig'
                string:     '@SonataAdmin/CRUD/base_list_field.html.twig'
                smallint:   '@SonataAdmin/CRUD/base_list_field.html.twig'
                bigint:     '@SonataAdmin/CRUD/base_list_field.html.twig'
                integer:    '@SonataAdmin/CRUD/base_list_field.html.twig'
                decimal:    '@SonataAdmin/CRUD/base_list_field.html.twig'
                identifier: '@SonataAdmin/CRUD/base_list_field.html.twig'

            show:
                array:      '@SonataAdmin/CRUD/show_array.html.twig'
                boolean:    '@SonataAdmin/CRUD/show_boolean.html.twig'
                date:       '@SonataAdmin/CRUD/show_date.html.twig'
                time:       '@SonataAdmin/CRUD/show_time.html.twig'
                datetime:   '@SonataAdmin/CRUD/show_datetime.html.twig'
                text:       '@SonataAdmin/CRUD/base_show_field.html.twig'
                trans:      '@SonataAdmin/CRUD/show_trans.html.twig'
                string:     '@SonataAdmin/CRUD/base_show_field.html.twig'
                smallint:   '@SonataAdmin/CRUD/base_show_field.html.twig'
                bigint:     '@SonataAdmin/CRUD/base_show_field.html.twig'
                integer:    '@SonataAdmin/CRUD/base_show_field.html.twig'
                decimal:    '@SonataAdmin/CRUD/base_show_field.html.twig'

### Service bloc (contenu admin perosnnalisé)

### Dashboard

### bloc personnalisé

### template personnalise

### List bloc personnalisé
@see  '@SonataAdmin/Block/block_admin_list.html.twig'

## 5-Créer des actions/bouttons personalisé et mosaique 

### Créer une action 
>>> AbstractAdmin.php

protected function configureListFields(ListMapper $listMapper)
{
    /**
    # Construction d'une action personnalisé
    $listMapper
    ->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS (-- actions,edit,link_parameters--), [
        'actions' => [
            'show' => [],
            'edit' => [],
            'delete' => ['template' => 'Admin/MyController/my_partial.html.twig'],
            //this twig file will be located at: templates/Admin/MyController/my_partial.html.twig
        ]
    ]);

     */


    $listMapper
        ->addIdentifier('id')
        ->add('name')        
        // add custom action links
        ->add('_action', 'actions', array(
            'actions' => array(
                'view' => array(),
                'calculate' => array('template' => 'chemoinfoEdrugBundle:CRUD:list__action_calculate.html.twig'),
                'edit' => array(),
            )
        ))
    ;
}

// Ajout de la route de mon action 'custom_action' et de sa configuration
protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add(
            'custom_action',
            $this->getRouterIdParameter().'/custom-action',
            [],
            [],
            [],
            '',
            ['https'],
            ['GET', 'POST']
        );
    }

>>> config/services.yaml

app.admin.media:
    class: App\Admin\MediaAdmin
    tags:
        - { name: sonata.admin, model_class: App\Entity\Page, controller: App\Controller\MediaCRUDController, manager_type: orm, label: 'Media' }

//Contenu de mon action
>>> src/Controller/CRUDController.php

namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;

class MediaCRUDController extends CRUDController
{
    public function myCustomAction(): Response
    {
        // your code here ...
    }
}

### Show icon on action button
>>> config/packages/sonata_admin.yaml
sonata_admin:
    options:
        # Choices are: text, icon or all (default)
        # Montre l'icon des bouton action
        list_action_button_content: icon

### Hide Mosaique boutton
//Cacher sur toute l'application
>>> config/packages/sonata_admin.yaml <<<
sonata_admin:
    # for hide mosaic view button on all screen using `false`
    show_mosaic_button: true

//cacher sur un element spécifique
>>> config/services.yaml
sonata_admin.admin.post:
    class: Sonata\AdminBundle\Admin\PostAdmin
    tags:
    # avec 'show_mosaic_button' vous pouvez cahchez/montrez le bouton sur un entité
        - { name: sonata.admin, model_class: Sonata\AdminBundle\Entity\Post, manager_type: orm, group: admin, label: Post, show_mosaic_button: true }

## 6-DataTransformer ****** important
// Permet d'une part de gérer une énumération définie d'entité pour une validation
https://docs.sonata-project.org/projects/SonataAdminBundle/en/5.x/reference/action_list/
- Dangereux

ArrayToModelTransformer: transform an array to an object,
ModelsToArrayTransformer: transform a collection of array into a collection of object,
ModelToIdTransformer: transform an id into an object.


## Audit
/** Mirroir créer sur la base de données pour permettre des révisions

actions audit:

/admin/vendor/entity/{id}/history: displays the history list
/admin/vendor/entity/{id}/history/{revision}: displays the object at a specific revision
/admin/vendor/entity/{id}/history/{base_revision}/{compare_revision}: displays a comparison of an object between two specified revisions

 */
composer require simplethings/entity-audit-bundle

## 7-Personalisé une query
- Dangereux
use Sonata\AdminBundle\Datagrid\ORM\ProxyQuery;

$queryBuilder = $this->em->createQueryBuilder();
$queryBuilder->from('Post', 'p');

//Query personalisant la query principal
$proxyQuery = new ProxyQuery($queryBuilder);
$proxyQuery->leftJoin('p.tags', 't');
$proxyQuery->setSortBy('name');
$proxyQuery->setMaxResults(10);
$proxyQuery->setDistinct(false);

$results = $proxyQuery->execute();

## 8-ligne de commande
php bin/console make:sonata:admin App/Entity/User


## 9 - champs non-model/ fantome / virtuel/ 

### Déclarer une fonction dans le Model lié a un formulaire
>>> src/Entity/EntityClassName.php

public function getFullName(): string
{
    return $this->getGivenName().' '.$this->getFamilyName();
}

>>>> src/Admin/AbstractAdminClassName.php

protected function configureListFields(ListMapper $list)
{
    //Ajout d'un champs (nom-module)fonctionnel liant a un contenu
    $list->addIdentifier('fullName'/**Entity::get--option() */);
}

### Sans Modifier le Model
>>>> src/Admin/AbstractAdmin.php

protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
{
    $query = parent::configureQuery($query);

    $query
        ->leftJoin('n.Comments', 'c')
        ->addSelect('COUNT(c.id) MyAddedfieldNameQuery')
        ->addGroupBy('n');

    return $query;
}

protected function configureListFields(ListMapper $list): void
{
    $list->addIdentifier('MyAddedfieldNameQuery');
}

### Sinon voir le champs virtuel


# Field type ******

## Field relational (configureFormFields)

    use Sonata\AdminBundle\Form\Type\ModelType;
    use Sonata\AdminBundle\Form\Type\ModelListType;
    use Sonata\AdminBundle\Form\Type\ModelHiddenType;
    use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Sonata\AdminBundle\Form\Type\AdminType;
    use Sonata\Form\Type\CollectionType;
    use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;

 protected function configureFormFields(FormMapper $form): void
    {
        $imageFieldOptions = [[
            'label'        => 'User\'s expectations',
            'property'     => false, //designate which field to use for the choice values
            'query'        => $this->modelManager->createQuery('UserBundle\Entity\Expectation'),//You can set this to a ProxyQueryInterface instance in order to define a custom query for retrieving the available options
            'required'     => false,
            'multiple'     => true,
            'expanded'      => false,
            'choices'       => false,
            'preferred_choices'=> false,
            'choice_loader'  => false,    //defaults to a ModelChoiceLoader built from the other options
            'model_manager' =>null ,//You usually should not need to set this manually.
            'class'=>null,  //The entity class managed by this field. You usually should not need to set this manually.
            'btn_add'=> false,//hide the button
            'btn_list'=> false,//hide the button
            'btn_delete'=> false, //hide the button
            'btn_translation_domain' =>false ,//hide the button
            'by_reference' => false,
            'template'     => 'choice',
            'sortable'     => true,
        ]; 

        $form
            ->add('image1', ModelType::class, $imageFieldOptions)
            /**
                'model_manager' =>null ,//You usually should not need to set this manually.
                'class'=>null,  //The entity class managed by this field. You usually should not need to set this manually.
                'btn_add'=> false,//hide the button
                'btn_list'=> false,//hide the button
                'btn_delete'=> false, //hide the button
             */
            ->add('image1', ModelListType::class)
            ->add('categoryId', ModelHiddenType::class)
            /**
            'property' => ['field',],//You have to set this to designate which field (or a list of fields) to use for the choice values. 
            'class' => null,
            'model_manager'=> null,// actually calculated from the linked admin class. 
            'callback' => 
            //Callable function that can be used to modify the query which is used to retrieve autocomplete items. The callback should receive 
            //three parameters - the admin instance, the property (or properties) defined as searchable and the search value entered by the user.

From the $admin parameter it is possible to get the Datagrid and the Request
             *///see:https://docs.sonata-project.org/projects/SonataAdminBundle/en/4.x/reference/form_types/
             //Configure the datagrid filter of your relational entities the property has to be inside.
            ->add('category', ModelAutocompleteType::class, [
                'property' => 'title',
                //if many to many relationship
                'multiple' => true,
                //add buton add
                'btn_add' => true,
                //taille minimun des input
                'minimum_input_length'=>'3'
                //champs accessible pour le role 'autocomplete' 
                'target_admin_access_action' => 'autocomplete',
                //change the default to String behavior of your entity
                'to_string_callback' => function($entity, $property) {
                                return $entity->getTitle();
                            },])
                 'callback' => static function (AdminInterface $admin, string $property, $value): void {
                                //obetention de la datagrid function result
                                $datagrid = $admin->getDatagrid();
                                //Obtention de la requete
                                $query = $datagrid->getQuery();
                                $query
                                    ->andWhere($query->getRootAlias() . '.foo=:barValue')
                                    ->setParameter('barValue', $admin->getRequest()->get('bar'))
                                ;
                                $datagrid->setValue($property, null, $value);
            ])

            //--- Traitement: affichage des champs de formulaire selon le ChoiceFieldMaskType 'choice' ----
             ->add('linkType', ChoiceFieldMaskType::class, [
                'choices' => [
                    'uri' => 'uri',
                    'route' => 'route',
                ],
                'map' => [ //Associative array. Describes the fields that are displayed for each 'choice'.
                    'route' => ['route', 'parameters'],
                    'uri' => ['uri'],
                ],
                'placeholder' => 'Choose an option',
                'required' => false
            ])
            ->add('route', TextType::class)
            ->add('uri', TextType::class)
            ->add('parameters')
            //--- End of ChoiceFieldMaskType ----------------------

            //***  champs relationnel admin type*/
            ->add('image1', AdminType::class, [], [
                //The admin serviceName of the class to make relation
                'admin_code' => 'sonata.admin.imageSpecial'
            ])

            //***  champs relationnel admin type*/
            //->add('image1', AdminType::class)
              ->add('image1', AdminType::class,['delete'=>false,
                    btn_add =>['labe'=>'','class'=>'',], 
                    btn_list =>false,
                    btn_delete=>false,
                    btn_translation_domain =>false])

            //Champs de type choix.
            ->add('multiChoices', ChoiceType::class, [
                //Multiple choice ManyToMany
                'multiple' => true,
                //Activate Select2 sortable
                'sortable' => true,
            ])

             ->add('sales', CollectionType::class, [
                'type_options' => [
                    // Prevents the "Delete" option from being displayed
                    'delete' => false,
                    'delete_options' => [
                        // You may otherwise choose to put the field but hide it
                        'type'         => HiddenType::class,
                        // In that case, you need to fill in the options as well
                        'type_options' => [
                            'mapped'   => false,
                            'required' => false,
                        ]
                    ]
                ]
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ])


            // A jQuery event is fired after a row has been added (sonata-admin-append-form-element). You can listen to this event to trigger custom JavaScript (eg: add a calendar widget to a newly added date field)
            // A jQuery event is fired after a row has been added (sonata-collection-item-added) or before deleted (sonata-collection-item-deleted). A jQuery event is fired after a row has been deleted successfully (sonata-collection-item-deleted-successful) You can listen to these events to trigger custom JavaScript.
             ->add('sales', CollectionType::class, ['allow_add' =>true,'allow_delete' => true]



        ;
    }

## field basiques (configureListFields function)
    FieldDescriptionInterface::TYPE_MANY_TO_MANY	used for relational tables
    FieldDescriptionInterface::TYPE_MANY_TO_ONE	used for relational tables
    FieldDescriptionInterface::TYPE_ONE_TO_MANY	used for relational tables
    FieldDescriptionInterface::TYPE_ONE_TO_ONE	used for relational tables
    FieldDescriptionInterface::TYPE_DATE	display a formatted date. Accepts the option format
    FieldDescriptionInterface::TYPE_TIME	display a formatted time. Accepts the options format and timezone
    FieldDescriptionInterface::TYPE_DATETIME	display a formatted date and time. Accepts the options format and timezone
    FieldDescriptionInterface::TYPE_STRING	display a text
    FieldDescriptionInterface::TYPE_EMAIL	display a mailto link. Accepts the options as_string, subject and body
    FieldDescriptionInterface::TYPE_ENUM	display the name of a backed enum
    FieldDescriptionInterface::TYPE_TEXTAREA	display a textarea
    FieldDescriptionInterface::TYPE_TRANS	translate the value with a provided value_translation_domain and format (sprintf format) option
    FieldDescriptionInterface::TYPE_FLOAT	display a number
    FieldDescriptionInterface::TYPE_CURRENCY	display a number with a provided currency option
    FieldDescriptionInterface::TYPE_PERCENT	display a percentage

### More complex basics field (configureListFields)

- FieldDescriptionInterface::TYPE_ARRAY	 -> //display value from an array
protected function configureListFields(ListMapper $list): void
{
    $list
        ->add('options', FieldDescriptionInterface::TYPE_ARRAY, [
            'inline' => true, //If true, the array will be displayed as a single line, the whole array and each array level will be wrapped up with square brackets. If false, the array will be displayed as an unordered list. For the show action, the default value is true and for the list action it’s false.
            'display' => 'both', //Define what should be displayed: keys, values or both. Defaults to 'both'. Available options are: 'both', 'keys', 'values'.
            'key_translation_domain' => true, //This option determines if the keys should be translated and in which translation domain. The values of this option can be true (use admin translation domain), false (disable translation), null (uses the parent translation domain or the default domain) or a string which represents the exact translation domain to use.
            'value_translation_domain' => null //This option determines if the values should be translated and in which translation domain. The values of this option can be true (use admin translation domain), false (disable translation), null (uses the parent translation domain or the default domain) or a string which represents the exact translation domain to use.
        ])
    ;
}


- FieldDescriptionInterface::TYPE_BOOLEAN	 ->//display a green or red picture dependant on the boolean value
    $list
        ->add('invalid', FieldDescriptionInterface::TYPE_BOOLEAN, [
            'ajax_hidden' => true,Yes/No; ajax_hidden allows to hide list field during an AJAX context.
            'editable' => true, //Yes/No; editable allows to edit directly from the list if authorized.
            'inverse'  => true, // Yes/No; reverses the background color (green for false, red for true).
        ])
    ;



- FieldDescriptionInterface::TYPE_CHOICE	 -> //uses the given value as index for the choices array and displays (and optionally translates) the matching value
    $list
        ->add('status', FieldDescriptionInterface::TYPE_CHOICE, [
            //Array of choices.
            'choices' => [
                'r' => 'red',
                'g' => 'green',
                'b' => 'blue',
                'prep' => 'Prepared',
                'prog' => 'In progress',
                'done' => 'Done',
            ],
            'multiple' => false,       //Determines if choosing multiple choices is allowed. Defaults to false.
            'delimiter'	=>'|'        ,//Separator of values, if multiple.

            'class'	=> 'MyClassName', //Class qualified name for editable association field.
            'choice_translation_domain' => 'App', //Translation domain.
            'required' =>true,//	Whether the field is required or not (default true) when the editable option is set to true. If false, an empty placeholder will be added.

        ])

- FieldDescriptionInterface::TYPE_URL	  -> display a link
        //Générer un lien pour un champs title
        // Output for value `Sonata is great!` (related object has identifier `123`):
        // `<a href="http://blog.example.com/xml/123">Sonata is great!</a>`
        ->add('title', FieldDescriptionInterface::TYPE_URL, [
            'hide_protocol'	=> true,    //remove protocol part from the link text
            'url' => 'https://url.com'	//URL address (e.g. http://example.com)
            'attributes'=>	['target' => '_blank','class' => 'red'], //array of html tag attributes (e.g. ['target' => '_blank'])
            'route' => [
                'name' => 'acme_blog_article', //route name (e.g. acme_blog_homepage)
                'absolute' => true, //create absolute or relative url address based on route.name and route.parameters (default false)
                'parameters' => ['format' => 'xml'], //array of route parameters (e.g. ['type' => 'example', 'display' => 'full'])
                'identifier_parameter_name' => 'id' //parameter added to route.parameters, its value is an object identifier (e.g. ‘id’) to create dynamic links based on rendered objects.
            ]
        ])

- FieldDescriptionInterface::TYPE_HTML	display (and optionally truncate or strip tags from) raw html
strip	Strip HTML and PHP tags from a string

        // Output for value `<p><strong>Creating a Template for the Field</strong> and form</p>`:
        //->add('content', FieldDescriptionInterface::TYPE_HTML) # Yhat Make tag HTML
        ->add('content', FieldDescriptionInterface::TYPE_HTML, [
            'strip' => true, //if true retrieve tag HTML
            //'truncate'=> true, #works also
            'truncate' =>[
                'length'=>'10' ///Détermine le nombre de caractère avant la coupure du text.
                'cut'=> false, //Détermine si le contenu doit être couper '...'
                'ellipsis'=> '. etc' // le contenu doit être couper avec la valeur 'ellipsis'
            ]
        ])


## Custom field/ Champs Admin personalisé
//Exemple de création de champ personnalisé DUMP
//voir @SonataAdmin/Resources/views/CRUD pour la liste des templates pouvant aider.
>>>config/sonata_doctrine_orm_admin.yaml
sonata_doctrine_orm_admin:
    templates:
        types:
            show: # or "list"
                # Mon nouveau champs 'dump' - les champs son des template
                dump: 'field_types/show_dump.html.twig'
>>>templates/field_types/show_dump.html.twi
{# templates/field_types/show_dump.html.twig #}

{# Utiliser un template CRUD/base_show_field.html.twig pour la page show  #}
{% extends '@SonataAdmin/CRUD/base_show_field.html.twig' %}

{% block field %}
    {{ dump(value) }}
{% endblock %}

>>>AbstractAdmin
protected function configureShowFields(ShowMapper $show): void
{
    $show
        ->add('foo', 'dump');
}




# Preview Mode 

## Contex
Preview Mode is an optional view of an object before it is persisted or updated.
Le template de preview est basée sur le template de formulaire d'édition d'entité. 

## Afficher un boutton preview
>>>>AbstractAdmin
    public $supportsPreviewMode = true;

## Template personnalisé du preview
>>> config/packages/sonata_admin.yaml  <<<<<
sonata_admin:
    templates:
        preview: '@App/CRUD/preview.html.twig'

>>>>AbstractAdmin <<<<<

protected function configure()
{
    $this->setTemplate('preview', '@App/CRUD/preview.html.twig');
}

## The template basique d'un preview
{# '@App/CRUD/preview.html.twig #}

{% extends '@App/layout.html.twig' %}

{% use '@SonataAdmin/CRUD/base_edit_form.html.twig' with form as parentForm %}

{% import '@SonataAdmin/CRUD/base_edit_form_macro.html.twig' as form_helper %}

{# a block in '@App/layout.html.twig' expecting article #}
{% block templateContent %}
    {% set article = object %}

    {{ parent() }}

    <div class="sonata-preview-form-container">
        {{ block('parentForm') }}
    </div>
{% endblock %}

{% block formactions %}
    <button class="btn btn-success" type="submit" name="btn_preview_approve">
        <i class="fas fa-check"></i>
        {{ 'btn_preview_approve'|trans({}, 'SonataAdminBundle') }}
    </button>
    <button class="btn btn-danger" type="submit" name="btn_preview_decline">
        <i class="fas fa-times"></i>
        {{ 'btn_preview_decline'|trans({}, 'SonataAdminBundle') }}
    </button>
{% endblock %}


## caché le fieldset du preview
>>>style.css
.sonata-preview-form-container .row {
    display: none;
};



# Les actions personalisé *******
 Les actions sont affichés sur les pages listes.

## --- Créer une action 
>>> AbstractAdmin.php

protected function configureListFields(ListMapper $listMapper)
{
    /**
    # Construction d'une action personnalisé
    $listMapper
    ->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS (-- actions,edit,link_parameters--), [
        'actions' => [
            'show' => [],
            'edit' => [],
            'delete' => ['template' => 'Admin/MyController/my_partial.html.twig'],
            //this twig file will be located at: templates/Admin/MyController/my_partial.html.twig
        ]
    ]);

     */


    $listMapper
        ->addIdentifier('id')
        ->add('name')        
        // add custom action links
        ->add('_action', 'actions', array(
            'actions' => array(
                'view' => array(),
                'calculate' => array('template' => 'chemoinfoEdrugBundle:CRUD:list__action_calculate.html.twig'),
                'edit' => array(),
            )
        ))
    ;
}

// Ajout de la route de mon action 'custom_action' et de sa configuration
protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add(
            'custom_action',
            $this->getRouterIdParameter().'/custom-action',
            [],
            [],
            [],
            '',
            ['https'],
            ['GET', 'POST']
        );
    }

>>> config/services.yaml

app.admin.media:
    class: App\Admin\MediaAdmin
    tags:
        - { name: sonata.admin, model_class: App\Entity\Page, controller: App\Controller\MediaCRUDController, manager_type: orm, label: 'Media' }

//Contenu de mon action
>>> src/Controller/CRUDController.php

namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;

class MediaCRUDController extends CRUDController
{
    public function myCustomAction(): Response
    {
        // your code here ...
    }
}


##  Créer une action personnalisé sur une entité /Creating a Custom Admin Action
https://docs.sonata-project.org/projects/SonataAdminBundle/en/5.x/cookbook/recipe_custom_action/
>>> config/services.yaml
services:
    app.admin.car:
        class: App\Admin\CarAdmin
        tags:
            - { name: sonata.admin, model_class: App\Entity\Car, /* Myactions controlleur */controller: App\Controller\ClassController, manager_type: orm, group: Demo, label: Car }

>>> src/Controller/ClassController.php
namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
// Bouton permettant un clonage
class ClassController extends CRUDController
{
    
     /**
     * @param $id
     */
    public function cloneAction($id): Response
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        // Be careful, you may need to overload the __clone method of your object
        // to set its id to null !
        $clonedObject = clone $object;

        $clonedObject->setName($object->getName().' (Clone)');

        $this->admin->create($clonedObject);

        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
        //return new RedirectResponse( $this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()])
);
    }
}

>>> template/Mytemplate.twig<<<
//Si vous retourner un template depuis le CRUD
{% extends '@SonataAdmin/standard_layout.html.twig' %}

{% block sonata_admin_content %}
    Your content here
{% endblock %}

>>>> templates/CRUD/list__action_clone.html.twig
//The template of my actions button
{# templates/CRUD/list__action_clone.html.twig #}
<a class="btn btn-sm" href="{{ admin.generateObjectUrl('clone', object) }}">clone</a>

>>> AbstractAdmin
    protected function configureListFields(ListMapper $list): void
    {
        //action lié a l'entité
        $list
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    // ...
                    //Ajout de l'action clone par entité
                    'clone' => [
                        'template' => 'CRUD/list__action_clone.html.twig',
                    ],
                ],
            ]);
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        //Ajout de la route clone
        $collection
                //../admin/app/car/1/clone
            ->add('clone', $this->getRouterIdParameter().'/clone');
    }

protected function configureActionButtons(array $buttonList, string $action, ?object $object = null): array
{
    $buttonList['import'] = ['template' => 'import_button.html.twig'];

    return $buttonList;
}

## Créer une action sans entité
//https://docs.sonata-project.org/projects/SonataAdminBundle/en/5.x/cookbook/recipe_custom_action/
//Permet de liberté sur leurs affichages et leurs traitement.
>>> AbstractAdmin
use Sonata\AdminBundle\Route\RouteCollectionInterface;
//Ajout d'une route import
protected function configureRoutes(RouteCollectionInterface $collection): void
{
    $collection->add('import');
}

//Ajout du boutton import
protected function configureActionButtons(array $buttonList, string $action, ?object $object = null): array
{
    $buttonList['import'] = ['template' => 'import_button.html.twig'];

    return $buttonList;
}

//Ajout du boutton au tableau de bord
protected function configureDashboardActions(array $actions): array
{
    $actions['import'] = [
        'label' => 'import_action',
        'translation_domain' => 'SonataAdminBundle',
        'url' => $this->generateUrl('import'),
        'icon' => 'level-up-alt',
    ];

    return $actions;
}

>>> CRUDController

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

public function importAction(Request $request): Response
    {
        // do your import logic
    }

>>> import_button.html.twig'
<li>
    <a class="sonata-action-element" href="{{ admin.generateUrl('import') }}">
        <i class="fas fa-level-up-alt"></i> {{ 'import_action'|trans({}, 'SonataAdminBundle') }}
    </a>
</li>

## Create a BatchAction
>>> AbstractAdmin
protected function configureBatchActions(array $actions): array
{
    if (
      $this->hasRoute('edit') && $this->hasAccess('edit') &&
      $this->hasRoute('delete') && $this->hasAccess('delete')
    ) {
        $actions['merge'] = [
            'label' => 'Merge',
            'ask_confirmation' => true,
            //'template' => '.twig' #overide ask_confirmation template
            'controller' => 'app.controller.merge::batchMergeAction',
            // Or 'App/Controller/MergeController::batchMergeAction' base on how you declare your controller service.
        ];
    }

    return $actions;
}


//PreBatchaction
// execute something before doing the batch action
// to alter the query or the list of selected id
public function preBatchAction($actionName, ProxyQueryInterface $query, array &$idx, bool $allElements): void
{
    // altering the query or the idx array
    $foo = $query->getParameter('foo')->getValue();

    // Doing something with the foo object
    // ...

    $query->setParameter('foo', $bar);
}

>>> AbstractController
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

>>> twig
{# templates/bundles/SonataAdminBundle/CRUD/list__batch.html.twig #}

{# see @SonataAdmin/CRUD/list__batch.html.twig for the current default template #}

{% extends get_admin_template('base_list_field', admin.code) %}

{% block field %}
    <input type="checkbox" name="idx[]" value="{{ admin.id(object) }}"/>

    {# the new radio button #}
    <input type="radio" name="targetId" value="{{ admin.id(object) }}"/>
{% endblock %}




# SonataBlockBundle/ sonata block 
composer require sonata-project/block-bundle

## Context
Les blocks retournes toujours du contenu et cela même durant les exceptions.
@Sonata\BlockBundle\Exception\BlockNotFoundException

il y a 3 type de block sonata que l'on peut réutiliser et overider:
1- RSSBlock : retour un flux RSS
@SonataBlock/Block/block_core_rss.html.twig

2- HTMLBlock: Retour du texte HTML
the template is in sonata_admin

3- MenuBlockService: Retourne un Menu
@SonataBlock/Block/block_side_menu_template.html.twig

Les blocks ont des fonctions principales DefaultSetting(),execute()
Vous pouver directement afficher un block sur un template a l'aide de sonata_block_render()
Vous pouvez gérer le cache des block, ,faire des relations entre les entités par les évènement de block.

## 1- Debuguage activer le profiler de block
>>> config/packages/sonata_block.yaml
sonata_block:
    profiler:
        enabled:  '%kernel.debug%'
        template: '@SonataBlock/Profiler/block.html.twig'


## Block pour Menu (MenuBlockService)
//Set cache_policy to private if this menu is dedicated to be in a user part.
>>>config/services.yaml
services:
    sonata.block.menu.main:
        class: Sonata\BlockBundle\Menu\MainMenu
        cache_policy:private
        menu_template :@SonataBlock/Block/block_side_menu_template.html.twig
        tags:
            - { 
                name: knp_menu.menu,
                alias: sonata.main
             }

## 2- Appel d'un block sur Sonata twig
//Pour utiliser le blocBundle
>>>config/packages/sonata_block.yaml
sonata_block:
    default_contexts: [sonata_page_bundle]
    blocks:
        # Some block with different templates
        #acme.demo.block.demo:
        #    templates:
        #       - { name: 'Simple', template: '@AcmeDemo/Block/demo_simple.html.twig' }
        #       - { name: 'Big',    template: '@AcmeDemo/Block/demo_big.html.twig' }

//Ajout du bloc comme service
>>> config/services.yaml
services:
    # The name of My block
    sonata.block.service.rss:
    # The Classname\Class of My block
        class: Sonata\BlockBundle\Block\Service\RssBlockService
        # The argument of my class 
        arguments:
            - ~
            - '@twig' #@tiwg utilise le constructeur pour instancier avec le template de la class.
        # The tag  of all block
        tags:
            - { name: sonata.block }
>>> twig
{{ sonata_block_render(block) }}
or
//this is the best call
{{ sonata_block_render({ 'type': 'sonata.block.service.rss' }, {
    'options' : 'value'
}) }}

or use the cache option
{{ sonata_block_render(block, {
    'use_cache': use_cache,
    'extra_cache_key': extra_cache_key
}) }}
or call a event
{{ sonata_block_render_event('node.comment', {
    'target': post
}) }}
or css and jascript 
{{ sonata_block_include_stylesheets('screen', app.request.basePath) }}
{{ sonata_block_include_javascripts('screen', app.request.basePath) }}

## 3- Service Block
// C'est un service implement BlockServiceInterface
//Exemple d'un Block RSS

>>> AbstractBlockService
/*namespace Sonata\BlockBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;

use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
*/

declare(strict_types=1);

namespace Sonata\BlockBundle\Block\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolver;

//1-configuration du blok
public function configureSettings(OptionsResolver $resolver):void
{
    $resolver->setDefaults([
        //the feed url
        'url' => false,
        //the block title
        'title' => 'Insert the rss title',
        //The template to render the block
        'template' => '@SonataBlock/Block/block_core_rss.html.twig',
    ]);
}

//2-Configuration de l'edition du block et de son formulaire ne pas oublier l'étape 4
public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
{
    $formMapper
    //The sonata_type_immutable_array type is a specific form type which allows to edit an array.
        ->add('settings', 'sonata_type_immutable_array', [
            'keys' => [
                ['url', 'url', ['required' => false]],
                ['title', 'text', ['required' => false]],
            ]
        ])
    ;
}

//3-hook de validation de la configuration du formulaire/contraintes
public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
{
    //Definition des contrainte error sur $errorElement
    $errorElement
        //variable du formulaire
        ->with('settings.url')
        //les contraintes de la variable
            ->assertNotNull([])
            ->assertNotBlank()
        ->end()
        ->with('settings.title')
            ->assertNotNull([])
            ->assertNotBlank()
            ->assertMaxLength(['limit' => 50])
        ->end()
    ;
}
//4-hoook d'éxécution du formulaire pour un block rss
//Cette methode droit retourner une réponse objet pour rendre le tableau
public function execute(BlockContextInterface $blockContext, Response $response = null): Response
{
    // merge settings
    $settings = $blockContext->getSettings();
    $feeds = false;

    if ($settings['url']) {
        $options = [
            'http' => [
                'user_agent' => 'Sonata/RSS Reader',
                'timeout' => 2,
            ]
        ];

        // retrieve contents with a specific stream context to avoid php errors
        $content = @file_get_contents($settings['url'], false, stream_context_create($options));

        if ($content) {
            // generate a simple xml element
            try {
                $feeds = new \SimpleXMLElement($content);
                $feeds = $feeds->channel->item;
            } catch (\Exception $e) {
                // silently fail error
            }
        }
    }

    return $this->renderResponse($blockContext->getTemplate(), [
        'feeds'     => $feeds,
        'block'     => $blockContext->getBlock(),
        'settings'  => $settings
    ], $response);

    //Utilisation du cache
    /**
       # set a TTL setting inside the block, so if ttl equals 0, then no cache will be available for the block and its parents,
       # set a use_cache setting to false or true, if the variable is set to false then no cache will be available for the block and its parents,
       # no cache backend by default! By default, there is no cache backend setup, you should focus on raw performance before adding cache layers.



    //Gestionn de l'authentification
     $user = false;
    if ($this->securityContext->getToken()) {
        $user = $this->securityContext->getToken()->getUser();
    }

    if (!$user instanceof UserInterface) {
        $user = false;
    }
    
    return new Response(sprintf("your name is %s", $user->getUsername()))->setTtl(0)->setPrivate();

    // ou retourne une réponse privé
     return $this->renderPrivateResponse($blockContext->getTemplate(), [
        'user' => $user,
        'block' => $blockContext->getBlock(),
        'context' => $blockContext,
    ]);

     */
}

    //Fonction utiliser dans le but de trouver des block cachable
    public function getCacheKeys(BlockInterface $block): array
    {
        return [
            //block_id 
            'id' => 'sample_cached_block'
        ];
    }

>>> twig
//Definition du template du block sur un fond blanc
{% extends sonata_block.templates.block_base %}
{% block block %}
    <h3 class="sonata-feed-title">{{ settings.title }}</h3>

    <div class="sonata-feeds-container">
        {% for feed in feeds %}
            <div>
                <strong><a href="{{ feed.link}}" rel="nofollow" title="{{ feed.title }}">{{ feed.title }}</a></strong>
                <div>{{ feed.description|raw }}</div>
            </div>
        {% else %}
                No feeds available.
        {% endfor %}
    </div>
{% endblock %}


//Ajout du bloc comme service
>>> config/services.yaml
services:
    # The name of My block
    sonata.block.service.rss:
    # The Classname\Class of My block
        class: Sonata\BlockBundle\Block\Service\RssBlockService
        # The argument of my class 
        arguments:
         #   - ~
            - '@twig'
        # The tag  of all block
        tags:
            - { name: sonata.block }

>>> config/packages/sonata_block.yaml
//Ajout du service dans la configuration sonata
sonata_block:
    blocks:
        sonata.block.service.rss: ~

## 3.1-Block d'évènement ***
//Permet d'effectuer des relations entre les block 
>>> post.twig.html
<h1>{{ post.title }}</h1>
<div> {{ post.message }} </div>
// Mon evenement de block
{{ sonata_block_render_event('blog.comment', { 'target': post }) }}

>>> config/services.yaml
services:
    //The service of My block event
    disqus.comment:
        // The class use for my block event
        class: Sonata\CommentBundle\Event\Disqus"
        tags:
        //  - { name: kernel.event_listener, event: sonata.block.MyBlockEventService, method: TheMethodeClassOfMyBlockEvent }
            - { name: kernel.event_listener, event: sonata.block.event.blog.comment, method: onBlock }

>>> Sonata\CommentBundle\Event\Disqus
use Sonata\BlockBundle\Model\Block;

class Disqus
{
    public function onBlock(BlockEvent $event)
    {
        $block = new Block();
        $block->setId(uniqid('', true)); // set a fake id
        $block->setSettings($event->getSettings());
        $block->setType('sonata.comment.block.discus');

        $event->addBlock($block);
    }
}

## 4- Tester un block 
Tester un service Block
>>> AbstractBlockServiceTestCase
use Sonata\BlockBundle\Test\AbstractBlockServiceTestCase;
class CustomBlockServiceTest extends AbstractBlockServiceTestCase
{
    public function testDefaultSettings()
    {
        //Charger le service Block CustomBlockService avec ses arguments
        $blockService = new CustomBlockService('foo', $this->twig);
        //Demande du COntext du block
        $blockContext = $this->getBlockContext($blockService);

        //Configurer les contrainte de la configuration voir CustomBlockService::configureSettings()
        $this->assertSettings([
            'foo' => 'bar',
            'attr' => [],
            'template' => false,
        ], $blockContext);
    }
    //Test de l'éxécution
    public function testExecute()
    {
        //Charger le service Block CustomBlockService avec ses arguments
        $blockService = new CustomBlockService('foo', $this->twig);
        //Demande du COntext du block
        $blockContext = $this->getBlockContext($blockService);
        //Exécuter le Block
        $blockService->execute($blockContext);
        //Contrainte
        $this->assertSame($blockContext, $this->templating->parameters['context']);
        $this->assertInternalType('array', $this->templating->parameters['settings']);
        $this->assertInstanceOf('Sonata\BlockBundle\Model\BlockInterface', $this->templating->parameters['block']);
        $this->assertSame('bar', $this->templating->parameters['foo']);
    }
}

## 5-cache

### Context
//Faire le cache sur un Block parent afin que les child puisse hérité
 *The cache is a response objet.Why a Response object ? It is a simple element, which contains the data (the body) and some metadata (the headers). As the block returns a Response object, it is possible to send it to the client, this use case can be quite useful for some cache backends (esi, ssi or js).

 *you can use a cache for MongoDB.

 *Varnish, Ssi or Js's cache create a new contex of the block it's data setting has been lost when you loose sonata_block_render.

set a TTL setting inside the block, so if ttl equals 0, then no cache will be available for the block and its parents,
set a use_cache setting to false or true, if the variable is set to false then no cache will be available for the block and its parents,
no cache backend by default! By default, there is no cache backend setup, you should focus on raw performance before adding cache layers.

### Cache sur un block parent
>>>BaseBlockService
public function execute(BlockContextInterface $blockContext, Response $response = null)
{
    $user = false;
    if ($this->securityContext->getToken()) {
        $user = $this->securityContext->getToken()->getUser();
    }

    if (!$user instanceof UserInterface) {
        $user = false;
    }

    return new Response(sprintf("your name is %s", $user->getUsername()))->setTtl(0)->setPrivate();
    /**
        return $this->renderPrivateResponse($blockContext->getTemplate(), [
        'user' => $user,
        'block' => $blockContext->getBlock(),
        'context' => $blockContext,
    ]);
    
     */
}
###
>>> config/packages/sonata_block.yaml
//Event Listener permettant d'alteré une réponse pour effectuer un cache
sonata_block:
    http_cache:
        handler: sonata.block.cache.handler.noop    # no cache alteration
        handler: sonata.block.cache.handler.default # default value
        listener: true   
    blocks:
        sonata.page.block.container:
        //configurer un type de cache Back-End
            cache: sonata.cache.memcached

>>> config/packages/sonata_cache.yaml
sonata_cache:
    //Configuration du même cache pour partager entre tout les données.
    caches:
        memcached:
            prefix: test # prefix to ensure there is no clash between instances
            servers:
                - { host: 127.0.0.1, port: 11211, weight: 0 }

### Cache back-end
- sonata.cache.mongo: use mongodb to store cache element. This is a nice backend as you can remove a cache element by only one value. (remove all block where profile.media.id == 3 is used.)
- sonata.cache.memcached: use memcached as a backend, shared across multiple hosts
- sonata.cache.apc: use apc from PHP runtime, cannot be shared across multiple hosts, and it is not suitable to store high volume of data
- sonata.cache.esi: use an ESI compatible backend to store the cache, like Varnish
- sonata.cache.ssi: use an SSI compatible backend to store the cache, like Apache or Nginx


## Type de champs relationnel Formulaire 
### Many to Many
- Autocompletion
//ToMany or ManyToMany
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
        //configurer les modelType
        ->add('categorie',ModelAutocompleteType::class, [
            //Relation ManyToMany
            'multiple' =>true,
            'btn_add'=>true,
            //propriété sur les recherche
            'property' => ['titre'],
            'required' => false])
### one to Many
### one to one
### Many to one

# SonataExporter **** /Export action
https://docs.sonata-project.org/projects/exporter/en/4.x/
(voir le lien ci-dessus pour plus d'approfondissement)******

### Context
Configurer des exportations par défault
Exportation personnailisé
Configurer tout les écriture par défault
Les champs relationnele ne sont pas exporter par défault.

### Retirer des routes
>>> AbstractAdmin
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        // Removing the export route will disable exporting entities.
        $collection->remove('export');
    }

### Exporter des champs spécifique
>>> AbstractAdmin
//Configurer tout les champs a exporter
protected function configureExportFields(): array
{
    return ['givenName', 'familyName', 'contact.phone', 'getAddress'];
}

//Configurer tout les champs a exporter a travers une extension admin
public function configureExportFields(AdminInterface $admin, array $fields): array
{
    //Ce champs sera vide a l'exportation
    unset($fields['updatedAt']);

    return $fields;
}

### Export format
>>> AbstractAdmin
public function getExportFormats(): array
{
    //return a format html and pdf
    return ['pdf', 'html'];
}

### Personnaliser la requete utilisé pour afficher les données expoerté ***
- Dangereux
final class DataSource implements DataSourceInterface
{
    public function createIterator(ProxyQueryInterface $query, array $fields): \Iterator
    {
        // Custom implementation
    }
}

# Saving hooks

## Context
Evenement s'exécutant durant un processus de Sonata Admin (controlleur)
Pour sauvegarder des données ou éffectuer des actions au rendu des action admin ()

## hooks with Manage Admin ( public function) 
new object : preValidate($object) / prePersist($object) / postPersist($object)
edited object : preValidate($object) / preUpdate($object) / postUpdate($object)
deleted object : preRemove($object) / postRemove($object)
For all submitting actions :preUpdate(object $user)/ postUpdate (object $user): void

## hooks in a controller
/**
If these methods return a Response, the process is interrupted and the response will be returned as is by the controller (if it returns null, the process continues). You can generate a redirection to the object show page by using the method redirectTo($object).
 */
new object : preCreate($object)
edited object : preEdit($object)
deleted object : preDelete($object)
show object : preShow($object)
list objects : preList($object)

## Events generated ******
sonata.admin.event.configure.form
sonata.admin.event.configure.list
sonata.admin.event.configure.datagrid
sonata.admin.event.configure.show

-- PersisteEvent
sonata.admin.event.persistence.pre_update
sonata.admin.event.persistence.post_update
sonata.admin.event.persistence.pre_persist
sonata.admin.event.persistence.post_persist
sonata.admin.event.persistence.pre_remove
sonata.admin.event.persistence.post_remove

--- ConfigureQueryEvent
sonata.admin.event.configure.query

---Block Event --customise my template
sonata.admin.dashboard.top
sonata.admin.dashboard.bottom
sonata.admin.list.table.top
sonata.admin.list.table.bottom
sonata.admin.edit.form.top
sonata.admin.edit.form.bottom
sonata.admin.show.top
sonata.admin.show.bottom

---BatchAction Event
sonata.admin.event.batch_action.pre_batch_action

# Extension 

## Context
L'extension administrateur pertmet de changer ou d'ajouter des outils a l'instance Administrateur.
The interface defines a number of functions which you can use to customize the edit form, list view, form validation, alter newly created objects and other admin features

Attribute name	Type	Description
target	string	Admins service’s name that you want to customize, If you use the global attribute as true, you don’t need to pass it.
priority	integer	Can be a positive or negative integer. The higher the priority, the earlier it’s executed.
global	boolean	adds the extension to all admins.

## Créer une extension
>>> AbstractAdminExtension
App\Admin\Extension;
use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

//Definition de l'extension dans le service.yml
#[AutoconfigureTag(name: 'sonata.admin.extension', attributes: ['target' => 'nom_de_mon_service_admin])]
final class PositionAdminExtension extends AbstractAdminExtension
{
    //Overide configureFormFields
public function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('main')
            //réorder the field
                ->reorder([
                    'url',
                    'position'
                ])
                ->add('position',null, [
                    'target'=>'MyclassName',//string Admins service’s name that you want to customize, 
                    //If 'global'=true, you don’t need to pass it.
                    'priority'	=> -1, integer	Can be a positive or negative integer. The higher the priority, the earlier it’s executed.
                    'global'	=> true,boolean	adds the extension to all admins.
                ])
            ->end()
        ;
    }
}

//Methode 2 : réalisation d'une extension
>>>config/packages/sonata_admin.yaml <<<
sonata_admin:
    extensions:
        app.publish.extension:
            global: true        #adds the extension to all admins.
            admins:             #specify one or more admin service ids to which the Extension should be added.
                - App\Admin\Extension\PositionAdminExtension
                - app.admin.article
            implements: 
            #specify one or more interfaces. If the managed class of an admin implements one of the specified interfaces the extension will be #added to that admin.
                - App\Publish\PublishStatusInterface
            excludes:           #specify admins service ids to which the Extension should not be added 
                - app.admin.blog
                - app.admin.news
            extends:
            #specify one or more classes. If the managed class of an admin extends one of the specified classes the extension will be added to #that admin.
                - App\Document\Blog
            instanceof: #specify one or more classes. If the managed class of an admin extends one of the specified classes or is an instance #of that class the extension will be added to that admin.
                - App\Document\Page
            uses:#Specify one or more traits. If the managed class of an admin uses one of the specified traits the extension will be added to #that admin.
                - App\Trait\Timestampable
            #priority:1	#Can be a positive or negative integer. The higher the priority, the earlier it was executed.
>>>config/service.yml
    app.articles.extension:
        class: App\Admin\Extension\ArticlesAdminExtension
        tags:
            - { name: sonata.admin.extension,   
                target: admin.articles 
                 }

## Retirer une extension de l'Admin
>>> AbstractAdmin
    use App\AdminExtension\PublishStatusAdminExtension;

    protected function configure(): void
    {
        // ...

        if ($someCondition) {
            $this->addExtension(new PublishStatusAdminExtension());
        }



# -------------------------------------------- ------   ------------ ---- -----

# SEO *******( en cours)
https://docs.sonata-project.org/projects/SonataSeoBundle/en/3.x/reference/sitemap/
## 1- Instalation de la SEO et configuration

composer require sonata-project/seo-bundle

>>> config/packages/sonata_seo.yaml

sonata_seo:
    encoding:         UTF-8
    page:
        title:           'Project name'
        # title_prefix:  'Prefix |'
        # title_suffix:  '| Suffix'
        default:          sonata.seo.page.default
        metas:
            name:
                keywords:             foo bar
                description:          The description
                robots:               index, follow

            property:
                # Facebook application settings
                #'fb:app_id':          XXXXXX
                #'fb:admins':          admin1, admin2

                # Open Graph information
                # see http://developers.facebook.com/docs/opengraphprotocol/#types or http://ogp.me/
                'og:site_name':       Sonata Project Sandbox
                'og:description':     A demo of the some rich bundles for your Symfony2 projects

            http-equiv:
                'Content-Type':         text/html; charset=utf-8
                #'X-Ua-Compatible':      IE=EmulateIE7

            charset:
                UTF-8:    ''

        head:
            'xmlns':              http://www.w3.org/1999/xhtml
            'xmlns:og':           http://opengraphprotocol.org/schema/
            #'xmlns:fb':           "http://www.facebook.com/2008/fbml"


>>> twig
<html {{ sonata_seo_html_attributes() }}>
<head {{ sonata_seo_head_attributes() }}>


{{ sonata_seo_title() }}
{{ sonata_seo_title_text() }}
{{ sonata_seo_metadatas() }}


{{ sonata_seo_link_canonical() }}
{{ sonata_seo_lang_alternates() }}
{{ sonata_seo_oembed_links() }}
</head>

{{ sonata_seo_html_attributes() }}
</html>

## Alter SEO information ****
- impossible

## 2- Breadcrumb /Navigation ****
- impossible
### Context
a secondary navigation aid that helps users easily understand the relation between their location on a page (like a product page) and higher level pages (a category page, for instance).

The sonata.admin.breadcrumbs_builder service is used in the layout of every page to compute the underlying data for two breadcrumbs:

one as text, appearing in the title tag of the document’s head tag;
the other as html, visible as an horizontal bar at the top of the page.

### Execution
>>> config/packages/sonata_admin.yaml
sonata_admin:
    breadcrumbs:
       # use this to change the default route used to generate the link
       # to the parent object inside a breadcrumb, when in a child admin
       child_admin_route: show
>>>> php
$this->get('sonata.admin.breadcrumbs_builder')->getBreadcrumbs($admin, $action);

## 3- SiteMap ****
- impossible


# SonataPageBundle ******
https://docs.sonata-project.org/projects/SonataPageBundle/en/3.x/reference/installation/

# SonatUserBundle/ USER (user-bundle) ***
 - impossible -
 copier https://github.com/sonata-project/SonataUserBundle
composer require sonata-project/user-bundle

### Context
Choisir entre le script de MySQL ou MongoDB.
Configurer Mysql/ MariaDB
Utilisation pour un role super-admin sans indexation automatique.
Gestion des Utilisateurs et des groups.
Pour une lecture seul ou une modification ('role'=>'Admin') selon le role de l'admin.
When using ACL, the UserBundle prevents normal user to change settings of super-admin users.

Utilisation de SonataUserBundle pour configurer le switch de compte sur un dashboard.
Matrix permettant d'observer les actions sur les CRUD par Roles.
Inconvénient impossible d'ajouter une class dans Sonata_user.yml qui est enfant de BaseUser
impossible de créer des user avec la ligne de commande Sonata:user:create car l'id ne s'incrémente pas. 

### 1- Configuration de MysqlMysql
//Problem d'incrémentation automatique de classBaseUser
>>>Wampserver/my.ini
//
innodb-default-row-format=dynamic
//SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value
//Afin de pas demander autoIncrementation
sql-mode="[modes]"

### Base
// Configuration de la class user et du resetting
>>> config/packages/sonata_user.yaml
sonata_user:
    class:
        user: App\Entity\SonataUserUser
    resetting:
        email:
            address: sonata@localhost
            sender_name: Sonata Admin

>>> config/packages/doctrine.yaml

doctrine:
    orm:
        entity_managers:
            default:
                mappings:
                    SonataUserBundle: ~

//Créer lentité User -ClassNameUser
>>>src/Entity/ClassNameUser.php extends BaseUser
> php bin/console make:entity ClassNameUser
use Sonata\UserBundle\Entity\BaseUser;

>php bin/console doctrine:schema:update --force


//Configuration des route administrateur sonata
>>> config/routes.yaml

sonata_user_admin_security:
    resource: '@SonataUserBundle/Resources/config/routing/admin_security.xml'
    prefix: /admin

sonata_user_admin_resetting:
    resource: '@SonataUserBundle/Resources/config/routing/admin_resetting.xml'
    prefix: /admin


//Configuration du firewall (voir bundle security)
>>> config/packages/security.yaml

security:
    enable_authenticator_manager: true
    firewalls:
        admin:
            lazy: true
            pattern: /admin(.*)
            provider: sonata_user_bundle
            context: user
            form_login:
                login_path: sonata_user_admin_security_login
                check_path: sonata_user_admin_security_check
                default_target_path: sonata_admin_dashboard
            logout:
                path: sonata_user_admin_security_logout
                target: sonata_user_admin_security_login
            remember_me:
                secret: '%env(APP_SECRET)%'
                lifetime: 2629746
                path: /admin

    role_hierarchy:
        ROLE_ADMIN: [ROLE_USER, ROLE_SONATA_ADMIN]
        ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]

    password_hashers:
        Sonata\UserBundle\Model\UserInterface: auto

    providers:
        sonata_user_bundle:
            id: sonata.user.security.user_provider

    access_control:
        # Admin login page needs to be accessed without credential
        - { path: ^/admin/login$, role: PUBLIC_ACCESS }
        - { path: ^/admin/logout$, role: PUBLIC_ACCESS }
        - { path: ^/admin/login_check$, role: PUBLIC_ACCESS }
        - { path: ^/admin/request$, role: PUBLIC_ACCESS }
        - { path: ^/admin/check-email$, role: PUBLIC_ACCESS }
        - { path: ^/admin/reset/.*$, role: PUBLIC_ACCESS }

        # Secured part of the site
        # This config requires being logged for the whole site and having the admin role for the admin part.
        # Change these rules to adapt them to your needs
        - { path: ^/admin/, role: ROLE_ADMIN }
        - { path: ^/.*, role: PUBLIC_ACCESS }
    //prevent normal users to change settings of super-admin users
//    acl:
//        connection: default

>>>  config/packages/sonata_user.yaml <<<
//a global sonata_user with sonata_BaseUser and UserAdmin, mailer and profile and impersonate and ACL
sonata_user:
    security_acl: false
    manager_type: orm # can be orm or mongodb

    impersonating:
        route: page_slug
        parameters: { path: / }

    class: # Entity Classes
        user: Sonata\UserBundle\Entity\BaseUser

    admin: # Admin Classes
        user:
            class: Sonata\UserBundle\Admin\Entity\UserAdmin
            controller: '%sonata.admin.configuration.default_controller%'
            translation: SonataUserBundle

    profile:
        default_avatar: bundles/sonatauser/default_avatar.png # Default avatar displayed if the user doesn't have one

    mailer: sonata.user.mailer.default # Service used to send emails

    resetting: # Reset password configuration (must be configured)
        email:
            template: '@SonataUser/Admin/Security/Resetting/email.html.twig'
            address: ~
            sender_name: ~

### ACL
//When using ACL, the UserBundle can prevent normal users to change settings of super-admin users, to enable this use the following configuration:
> config/packages/sonata_user.yaml
sonata_user:
    security_acl: true

> config/packages/security.yaml
security:
    acl:
        connection: default
>>>console
//Mettre a jour les ACL, permet un ACL pour chaque Admin.
php bin/console sonata:admin:setup-acl
//Créer un entité ACL pour les admins
php bin/console sonata:admin:generate-object-acl

### Impersonate user (switch users)
/**
changer de compte 
Once you have enabled the feature, you will need to ensure that the user that you wish to role switch from has the ROLE_ALLOWED_TO_SWITCH role.
 */
>>> config/packages/security.yaml
    role_hierarchy:
        ROLE_SUPER_ADMIN: [ROLE_SONATA_ADMIN, ROLE_ALLOWED_TO_SWITCH]

    firewalls:
        admin:
            switch_user: true


//Redirection après le changement de compte.
>>> config/packages/sonata_user.yaml
sonata_user:
    impersonating:
        route: sonata_admin_dashboard


### Configurer les roles par BO******.
//Utiliser le champs RolesMatrixType dans un formulaire
use Sonata\UserBundle\Form\Type\RolesMatrixType 

#### Ne pas montrer une entité dans la Matrix RoleMatrixType

//Ne pas montrer le service Post  dans la Matrix-role de la page admin.
>>>> config/services.yaml
services:
    app.admin.post:
        class: App\Admin\PostAdmin
        tags:
            -
                name: sonata.admin
                model_class: App\Entity\Post
                manager_type: orm
                label: 'Post'
                show_in_roles_matrix: false



# CRUDCONTROLLER******
//Add actions or change action or redirect response
In your overloaded CRUDController you can overload also these methods to limit the number of duplicated code from SonataAdmin: * preCreate: called from createAction * preEdit: called from editAction * preDelete: called from deleteAction * preShow: called from showAction * preList: called from listAction

- 
FieldDescriptionInterface : champs de formulaires de Sonata dont la class est BaseFieldDescription 

-template dans bundle symfony
Resources/views (tout mes templates)
les template de base
@SonataAdmin/standard_layout.html.twig
@SonataAdmin/ajax_layout.html.twig

il y a un templates pour Block, Button, CRUD, Form, Helper, Pager.

- Service
sonata.admin.pool
the Admin classes, lazy-loading them on demand (to reduce overhead) and matching each of them to a group. It is also responsible for handling the top level template files, administration panel title and logo.

## Context
Faire une action personnalisé sur l'interface administrateur de Sonata.

## Action personalisé
>>> src/Admin/MediaAdmin.php

use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class MediaAdmin extends AbstractAdmin
{
    //Methode de configuration des parametre pour récupérer la requete
    //
    protected function configurePersistentParameters(): array
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'provider' => $this->getRequest()->get('provider'),
            'context'  => $this->getRequest()->get('context', 'default'),
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add(
            'custom_action',
            $this->getRouterIdParameter().'/custom-action',
            [],
            [],
            [],
            '',
            ['https'],
            ['GET', 'POST']
        );
    }
}
>>>src/Controller/MediaCRUDController.php
namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;

class MediaCRUDController extends CRUDController
{
    public function myCustomAction(): Response
    {
        // your code here ...
    }
}
>>> config/services.yaml
app.admin.media:
    class: App\Admin\MediaAdmin
    tags:
        - { name: sonata.admin, model_class: App\Entity\Page, controller: App\Controller\MediaCRUDController, manager_type: orm, label: 'Media' }

### SonataDoctrineORMAdminBundle ******
https://docs.sonata-project.org/projects/SonataDoctrineORMAdminBundle/en/5.x/reference/installation/

---- Sonata ----

# The breadcrumbs builder ******

# SonataDoctrine *****
composer require sonata-project/doctrine-orm-admin-bundle

## Context
The ProxyQuery object is used to add missing features from the original Doctrine Query builder:

### Query

use Sonata\AdminBundle\Datagrid\ORM\ProxyQuery;
//Creation d'une query
$queryBuilder = $this->em->createQueryBuilder();
//
$queryBuilder->from('Post', 'p');
//
$proxyQuery = new ProxyQuery($queryBuilder);
//Jointure avec la table tags par la clé étrangere
$proxyQuery->leftJoin('p.tags', 't');
//Orguaniser par Name
$proxyQuery->setSortBy('name');
//Valeur Maximal de 10
$proxyQuery->setMaxResults(10);
//Executer la query
$results = $proxyQuery->execute();

# SonataIntlBundle / traitement de type de texte
composer require sonata-project/intl-bundle

## Context
To display dates, this bundle uses timezone detectors to get the current timezone.
Gestion des dates.

## Configure la timezone
>>> config/packages/sonata_intl.yaml

sonata_intl:
    timezone:
    # My local timezone
        locales:
            fr:    Europe/Paris
            en_UK: Europe/London
    # detecteur timezone
        detectors:
            - sonata.intl.timezone_detector.user
            - sonata.intl.timezone_detector.locale_aware
    # detecteur par défaut timezone
        default: Europe/Paris

## Créer une timezone personnalisé
>>> config/services.yaml

services:
    app.my_custom_timezone_detector:
        class: App\TimezoneDetector\MyCustomTimezoneDetector
        tags:
            - { name: sonata_intl.timezone_detector }

>>> config/packages/sonata_intl.yaml
// Use it in the class
sonata_intl:
    timezone:
        detectors:
            - app.my_custom_timezone_detector
            - sonata.intl.timezone_detector.user
            - sonata.intl.timezone_detector.locale_aware

##  Locale Helper /function to display local information
>>> twig
/** 
country name from the ISO code
language name from the ISO code
locale name from the ISO code
*/
{{ 'FR' | country }} {# => France (if the current locale in session is 'fr') #}
{{ 'FR' | country('de') }} {# => Frankreich (force the locale) #}

{{ 'fr' | language }} => {# français (if the current locale in session is 'fr') #}
{{ 'fr' | language('en') }} {# => French (force the locale) #}

{{ 'fr' | locale }} {# => français (if the current locale in session is 'fr') #}
{{ 'fr' | locale('en') }} {# => French (force the locale) #}

## Local function pour les dates
>>> twig
{{ date_time_object | format_date }} => '1 févr. 2011'
{{ date_time_object | format_time }} => '19:55:26'
{{ date_time_object | format_datetime }} => '1 févr. 2011 19:55:26'
{{ date_time_object | format_date(null, 'fr', 'Europe/Paris', constant('IntlDateFormatter::LONG')) }} => '1 février 2011'
{{ date_time_object | format_time(null, 'fr', 'Europe/Paris', constant('IntlDateFormatter::SHORT')) }} => '19:55'
{{ date_time_object | format_datetime(null, 'fr', 'Europe/Paris',
    constant('IntlDateFormatter::LONG'), constant('IntlDateFormatter::SHORT')) }} => '1 février 2011 19:55'
{{ date_time_object | format_[date|time|datetime]('dd MMM y G', 'fr', 'Europe/Paris') }} => '01 février 2011 ap. J.-C.'

>>> php
   protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('createdAt', 'date', [
                'pattern' => 'dd MMM y G',
                'locale' => 'fr',
                'timezone' => 'Europe/Paris',
            ])
        ;
    }

## Number helper
>>> twig
{{ 10.49|number_format_currency('EUR') }} {# => 10,49 € #}
{{ 10.15459|number_format_decimal }} {# => 10,155 #}
{{ 1000|number_format_scientific }} {# => 1E3 #}
{{ 1000000|number_format_duration }} {# => 1 000 000 #}
{{ 1000000|number_format_decimal(symbols={ 'GROUPING_SEPARATOR_SYMBOL': 'DOT' }) }} {# => 1DOT000DOT000  #}
{{ 42|number_format_spellout }} {# => quarante-deux #}
{{ 1.999|number_format_percent }} {# => 200 % #}
{{ 1|number_format_ordinal }} {# => 1ᵉʳ #}
{{ (-1.1337)|number_format_decimal({'fraction_digits': 2}, {'negative_prefix': 'MINUS'}) }} {# => MINUS1,34 #}

>>> php
  protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('amount', 'decimal', [
                'attributes' => ['fraction_digits' => 2],
                'textAttributes' => ['negative_prefix' => 'MINUS'],
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('price', 'currency', [
                'currency' => 'EUR',
                'locale' => 'fr',
            ])
        ;
    }

# CKeditor & SonataFormatterBundle & Mediabundle ***
https://docs.sonata-project.org/projects/SonataMediaBundle/en/5.x/reference/installation/
https://docs.sonata-project.org/projects/SonataFormatterBundle/en/5.x/reference/ckeditor_medias/

#### CKeditor

##### Configurer le champs de formulaire CKEDITOR
- Ivory ckeditorbundle was abondonned

composer require friendsofsymfony/ckeditor-bundle
php bin/console ckeditor:install
php bin/console assets:install public

>>>> composer.json

        "auto-scripts": {
            "cache:clear": "symfony-cmd",
            "ckeditor:install --clear=drop": "symfony-cmd",
            "assets:install --symlink --relative %PUBLIC_DIR%": "symfony-cmd"
            }
>> console 
instalation de ckeditor avec release -> full, standar, custom et basic
php bin/console ckeditor:install --release=basic

##### ne pas afficher la barre de progression 
php bin/console ckeditor:install --no-progress-bar


#####  utiliser ckeditor dans un formulaire avec un champs textaera
use FOS\CKEditorBundle\Form\Type\CKEditorType;

$builder->add('field', CKEditorType::class, array(
    'config' => array(
        'uiColor' => '#ffffff',
        //...
    ),
));

##### Installation de ckeditor sur Webpack

    npm install --save ckeditor4@^4.13.0

>>> webpack.config.js
    var Encore = require('@symfony/webpack-encore');

    Encore
        // ...
        .copyFiles([
            {from: './node_modules/ckeditor4/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
            {from: './node_modules/ckeditor4/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
            {from: './node_modules/ckeditor4/lang', to: 'ckeditor/lang/[path][name].[ext]'},
            {from: './node_modules/ckeditor4/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
            {from: './node_modules/ckeditor4/skins', to: 'ckeditor/skins/[path][name].[ext]'},
            {from: './node_modules/ckeditor4/vendor', to: 'ckeditor/vendor/[path][name].[ext]'}
        ])
        // Uncomment the following line if you are using Webpack Encore <= 0.24
        // .addLoader({test: /\.json$/i, include: [require('path').resolve(__dirname, 'node_modules/ckeditor')], loader: 'raw-loader', type: 'javascript/auto'})
    ;

>>>> package/ckeditor.yaml overide or complete
fos_ck_editor:
    # ...
    base_path: "build/ckeditor"
    js_path:   "build/ckeditor/ckeditor.js"

##### Faire une configuration ckeditor
>>> app/config/config.yml
fos_ck_editor:
//configuration par défault pour tout les pages
    default_config: my_config //Selectioner Sinon faire la configuration dans la construction du formulaire
//configuration ckeditor appelé 'myconfig' (skin a importé ckeditor,couleur, tollbar,template plugins wordcount Mytemplates avec sa congiguration.
    configs:
        my_config:
            language: fr //Language utilisé
    	    enable: false //Disable ckeditor and use textaera 
    	    jquery: true //Charger le jquery sur ckeditor
    	    jquery_path: your/own/jquery.js //Route du jquery
    	    input_sync: true //Synchroniser la configuration du champs texteaera avec ckeditor
    	    auto_inline: false // Conversion automatique de ckeditor
    	    require_js: true //Utiliser et configurer requirejs si l'application l'utilise
    	    inline: true  // Afichage en inline
            skin: "skin_name,/bundles/mybundle/skins/skin_name/"
            toolbar: [ ["Source", "-", "Save"], "/", ["Anchor"], "/", ["Maximize"] ] //Spécial config of the toolbar you cans use name
            uiColor:                "#000000"
            filebrowserUploadRoute: "my_route"
	// Installer un plugin toolbar et son template
            extraPlugins:           "wordcount"
            templates: "my_templates"
    plugins:
        wordcount:
            path:     "/bundles/mybundle/wordcount/" # with trailing slash
            filename: "plugin.js"
    templates:
        my_templates://nom du template intégré plus haut.
            imagesPath: "/bundles/mybundle/templates/images"
            templates:
                -
                    title:       "My Template"
                    image:       "image.jpg"
                    description: "My awesome template"
                    html:        "<p>Crazy template :)</p>"
        my_config_2:
            toolbar: "my_toolbar_1"
            uiColor: "#cccccc"
   toolbars: // toolbar configuration name
        configs:
            my_toolbar_1: [ [ "Source", "-", "Save" ], "/", [ "Anchor" ], "/", [ "Maximize" ] ]
            my_toolbar_2: [ [ "Source" ], "/", [ "Anchor" ], "/", [ "Maximize" ] ]

##### Faire une configuration spécifique.
    use FOS\CKEditorBundle\Form\Type\CKEditorType;

    $builder->add('field', CKEditorType::class, array(
        'config' => array(
            //some config
        ),
    ));

##### Afficher le formulaire dynamique ckeditor
>>> config/ckeditor.yaml

    autoload: false
    async: true
>>> twig
{{ form_javascript(form) }}


##### possibilité d 'utiliser un template personnalisé.

#####  Possibilité de stylysé les composants de CKEditor.

##### CKEditor et easyAdmin
>>> crudcontroller
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

public function configureCrud (Crud $crud)
{
	return $crud->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
}

public function configureField(String $pageNage)
{
	return textaeraField::new('body')->setFormType(CKEditorType::class);
}

##### Construire un json pour ckeditor
use FOS\CKEditorBundle\Builder\JsonBuilder;

$builder = new JsonBuilder();

// {"0":"foo","1":bar}
echo $builder
    ->setJsonEncodeOptions(JSON_FORCE_OBJECT)
    ->setValues(array('foo'))
    ->setValue('[1]', 'bar', false)
    ->build();

// {"foo":["bar"],"baz":bat}
echo $builder
    ->reset()
    ->setValues(array('foo' => array('bar')))
    ->setValue('[baz]', 'bat', false)
    ->build();

#### SonataFormatterBundle
php bin/console ckeditor:install
php bin/console assets:install
//Installation de Formatter bundle
composer require sonata-project/formatter-bundle
//Installation de Mediabundle
composer require sonata-project/media-bundle

##### Context
Permet de transformer le text en un format de text définie (HTML,text) pour adapter  
au contenu de CKEDitor, l'injection se fait dans un formulaire ou dans un twig.
Le twigFormater utilise le twig rendu par le service/controlleur et obtient toute ces configuratioin cependant le twigFormatter ne peut avoir d'extension d'active.
Ce bundle est utiliser en Administration.


##### 1-configuration
//Configuration du formater twig
>>>config/packages/twig.yaml
twig:
    debug:            '%kernel.debug%'
    strict_variables: '%kernel.debug%'

    form_themes:
        - '@SonataFormatter/Form/formatter.html.twig'

//Configuration du formater Admin
>>> config/packages/sonata.yaml
//Utilisation des formatter text et richthtml
sonata_formatter:
    default_formatter: text
    formatters:
        text:
            service: sonata.formatter.text.text
            extensions:
                - sonata.formatter.twig.control_flow
                - sonata.formatter.twig.gist

        richhtml:
            service: sonata.formatter.text.raw
            extensions:
                - sonata.formatter.twig.control_flow
                - sonata.formatter.twig.gist
                # - sonata.formatter.twig.media # do not add this unless you are using media bundle.

//Intégration de ckeditor
>>> config/packages/sonata_admin.yaml
//Utilisation de CKEditor
sonata_admin:
    assets:
        extra_javascripts:
            - bundles/fosckeditor/ckeditor.js

// S'assurer de l'installation de Ckeditor et de sonatamedia
>>>config/packages/fos_ck_editor.yaml <<<<
fos_ck_editor:
    default_config: default
    configs:
        default:
            # default toolbar plus Format button
            toolbar:
            - [Bold, Italic, Underline, -, Cut, Copy, Paste,
              PasteText, PasteFromWord, -, Undo, Redo, -,
              NumberedList, BulletedList, -, Outdent, Indent, -,
              Blockquote, -, Image, Link, Unlink, Table]
            - [Format, Maximize, Source]

            filebrowserBrowseRoute: admin_app_sonata_media_media_browser
            filebrowserImageBrowseRoute: admin_app_sonata_media_media_browser
            # Display images by default when clicking the image dialog browse button
            filebrowserImageBrowseRouteParameters:
                provider: sonata.media.provider.image
            filebrowserUploadMethod: form
            filebrowserUploadRoute: admin_app_sonata_media_media_upload
            filebrowserUploadRouteParameters:
                provider: sonata.media.provider.file
            # Upload file as image when sending a file from the image dialog
            filebrowserImageUploadRoute: admin_app_sonata_media_media_upload
            filebrowserImageUploadRouteParameters:
                provider: sonata.media.provider.image
                context: my-context # Optional, to upload in a custom context
                format: my-big # Optional, media format or original size returned to editor

##### 2-Utilisation

###### PHP
//Dans un formulaire
use Sonata\FormatterBundle\Form\Type\FormatterType;
$formBuilder
    ->add('rawContent') // source content
    ->add('contentFormatter', FormatterType::class, [
        //a rawContent field: store the original content from the user;
        'source_field' => 'rawContent',
        //a content field: store the transformed content display to the visitor.
        'target_field' => 'content',
    ]);
    
// Format de type 'text' ou 'richhtml
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
$formMapper
    ->add('comment', SimpleFormatterType::class, [
        'format' => 'text',
    ]);

//configuration de CKEDITOR et des formats appliqué
use Sonata\FormatterBundle\Form\Type\FormatterType;
$form
    ->add('content', FormatterType::class, [
        //format_field: the entity’s format field witch a contentFormatter field: store the //selected formatter;
        'format_field'   => 'contentFormatter',
        //format_field_options:(optional) some options of contentFormatter 'text'/'Markdown' ;
        'format_field_options' => [
            'choices' => [
                'text' => 'Text',
                'markdown' => 'Markdown',
            ],
            //Default choice
            'empty_data' => 'markdown',
        ],
        //source_field: the entity’s source field;
        'source_field' => 'rawContent',
        'source_field_options' => [
            'attr' => ['class' => 'span10', 'rows' => 20],
        ],
        'listener' => true,
        //target_field: the entity’s final field with the transformed data show to the user.
        'target_field' => 'content',

        //ckeditor_toolbar_icons : give CKEditor a custom toolbar configuration (optional)
        ckeditor_toolbar_icons => [
                                    ['Bold', 'Italic', 'Underline',
                                        '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord',
                                        '-', 'Undo', 'Redo',
                                        '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',
                                        '-', 'Blockquote',
                                        '-', 'Image', 'Link', 'Unlink', 'Table'],
                                    ['Maximize', 'Source'],
                                ],
    /*
        'ckeditor_context'=> Active and give CKEditor a context in order to customize routes used to browse and upload medias (see “Use CKEditor to select medias in SonataMediaBundle” chapter)
    */
        'ckeditor_context' => 'default',
    ]);

//Exemple de gestion de média
use Sonata\FormatterBundle\Form\Type\FormatterType;
$form
    ->add('shortDescription', FormatterType::class, [
        //source du contenu
        'source_field' => 'rawDescription',
        //format du contenut
        'format_field' => 'descriptionFormatter',
        //contenue final vue par l'utilisateur
        'target_field' => 'description',
        //Activation de CKEDitor
        'ckeditor_context' => 'default',
        'listener' => true,
    ]);

//Dans un script php
$formatterPool = new Pool();
assert($formatterPool instanceof Pool::class);
$html = $formatterPool->transform('rawhtml', $text);


###### HTML
{{ my_data|format_text('rawhtml') }}

##### 3-Use CKEditor to select medias in SonataMediaBundle
>>> config/packages/sonata_media.yaml
//COnfiguration d'une image uploader avec une taille personnaliser.
sonata_media:
    contexts:
        default:
            formats:
                big: { width: 1280, quality: 95 }

>>>config/packages/fos_ck_editor.yaml
fos_ck_editor:
    configs:
        default:
            filebrowserImageUploadRoute: admin_sonata_media_media_upload
            filebrowserImageUploadRouteParameters:
                provider: sonata.media.provider.image
                context: default
                format: big

>>>AbstractAdmin
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
$form
    ->add('details', SimpleFormatterType::class, [
        'format' => 'richhtml',
        'ckeditor_context' => 'default',
        'ckeditor_image_format' => 'big',
    ]);







----- Sonata end ------

# issue:
- can't use chart with blockbundle, we can't try ADMINCRUDCONTROLLER or chart.js without symfony UX, ou dans un evenement de block
- Use Sonata Bundle to manage my user.
- Use the SEO
- 

    private UserManagerInterface $userManager;
    
use Sonata\UserBundle\Model\UserManagerInterface;
    public function preUpdate(object $user): void
    {
        $this->userManager->updateCanonicalFields($user);
        $this->userManager->updatePassword($user);
    }

- 
https://symfony.com/doc/current/templates.html#embedding-controllers
    {# templates/base.html.twig #}

{# ... #}
<div id="sidebar">
    {# if the controller is associated with a route, use the path() or url() functions #}
    {{ render(path('latest_articles', {max: 3})) }}
    {{ render(url('latest_articles', {max: 3})) }}

    {# if you don't want to expose the controller with a public URL,
       use the controller() function to define the controller to execute #}
    {{ render(controller(
        'App\\Controller\\BlogController::recentArticles', {max: 3}
    )) }}
</div>
----------------------------------------------
If you want to render a custom controller action in a template by using the render function in twig you need to add _sonata_admin as an attribute. For example; {{ render(controller('App\\Controller\\XxxxCRUDController::comment',
{'_sonata_admin': 'sonata.admin.xxxx' })) }}. This has to be done because the moment the rendering should happen the routing, which usually sets the value of this parameter, is not involved at all, and then you will get an error "There is no _sonata_admin defined for the controller AppControllerXxxxCRUDController and the current route ' '."
------------------------------------------------------
gérer deux entity manager
------------------------------
Les fonctions et classe utile:
vendor/sonata/admin-bundle/src/...
ProxyQueryInterface $query => Query
AdminInterface $admin => gestion de l'admin
---------------------------------
formulaire et tableau
 ChoiceType::class, [
    'choices'  => [
        'Maybe' => null,
        'Yes' => true,
        'No' => false,
    ],