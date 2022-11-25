/**

Sonata est un bundle pour l'interface administrateur possédant des hooks et dont le système est basé sur les fonctions du formualaires et leur types de champs et les entitéq.

Gestion des utlisateurs
Gestion de la SEO
Gestion du contenu

 */

# Installation du bunde Sonata sur Mysql (voir NoSql)
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


## Créer une classe admin (page admin) pour un model ayant des fonctions natifs
/**
    Sonata n'utilise pas d'abstractType
 */
### base du CRUD Adminitrateur/ pageadmin pour un service
- Créer l 'entité
>>>src/Entity/ClassName
final class ClassNAme
{

}

//Définisser la page admin
>>admin/AbstractAdmin.php
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class admin extends AbstractAdmin
{

//Utliser la métode dun  forbuilder pour les arguements.

// 1- This method configures which fields are displayed on the edit and create actions. The FormMapper behaves similar to the FormBuilder of the Symfony Form component;
protected function configureFormFields(FormMapper $form): void
    {       
        //Definir un group d affichage de titre content avec une class col-md-9
       $form->with('Content', ['class' => 'col-md-9'])

            // champs name de type test
            ->add('name', TextType::class)

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

// 2-This method configures the filters, used to filter and sort the list of models;
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name');
    }

//3-This method configures which fields are shown when all models are listed (the addIdentifier() method means that this field will link to the show/edit page of this particular model);
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('name');
    }

//4-This method configures which fields are displayed on the show action.
    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('name');
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
        tags:
//chemin du model et nom l'outils et du lablel de la classe.
            - { name: sonata.admin, model_class: App\Entity\Category, manager_type: orm, label: Category }

//Créer le schema de la base de donné
>>> console
php bin/console doctrine:schema:create

#### field with relationship Many to One
>>> configFormField()

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


            ],

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

## Créer un template d'administration
// Overider les pages (liste, edit, create, update,delete)
>>> config/packages/sonata_admin.yaml

sonata_admin:
    templates:
        # default global templates
        layout:  '@SonataAdmin/standard_layout.html.twig'
        ajax:    '@SonataAdmin/ajax_layout.html.twig'

        # default value if done set, actions templates, should extend global templates
        list:    '@SonataAdmin/CRUD/list.html.twig'
        show:    '@SonataAdmin/CRUD/show.html.twig'
        edit:    '@SonataAdmin/CRUD/edit.html.twig'


// Overider les templates des types de champs des page (liste, edit, create, update,delete)
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





## DataTransformer
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

## Personalisé une query
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

# SEO ( en cours)
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

## 2- Breadcrumb ****
- impossible

## 3- SiteMap ****
- impossible


# USER
/** choose between MongoDb or Mysql bundle */
composer require sonata-project/user-bundle

## --- one side ---- configuration de la sécurité bundle MYSQL

### Base
// Configuration de la class user et du resetting
>>> config/packages/sonata_user.yaml

sonata_user:
    class:
        user: App\Entity\ClassNameUser
    resetting:
        email:
            address: sonata@localhost
            sender_name: Sonata Admin

    // custom mailer to send reset password emails
    mailer: custom.mailer.service.id
    //prevent normal users to change settings of super-admin users,
//    security_acl: true

>>> config/packages/doctrine.yaml

doctrine:
    orm:
        entity_managers:
            default:
                mappings:
                    SonataUserBundle: ~

//Créer lentité User -ClassNameUser
>>>src/Entity/ClassNameUser.php extends BaseUser
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



### Sonata_user.yaml
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


### Configurer les roles en BO******.
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

## --- other side -- Configuration de la sécurité user bundle MongoDB

# Advanced Options

1. Routing
2. Translation
3. Templates
4. Security
5. Customize admin
6. Events
7. Advanced configuration
8. Preview Mode


# Cookbook

1. Select2
2. iCheck
3. Jquery UI
4. KnpMenu
5. Uploading and saving documents (including images) using DoctrineORM and SonataAdmin
6. Showing image previews
7. Row templates
8. Sortable behavior in admin listing
9. Modifying form fields dynamically depending on edited object
10. Creating a Custom Admin Action
11. Decouple from CRUDController
12. Customizing a mosaic list
13. Overwrite Admin Configuration
14. Improve Performance of Large Datasets
15. Virtual Field Descriptions
16. Bootlint
17. Lock Protection
18. Sortable Sonata Type Model in Admin
19. Deleting a Group of Fields from an Admin
20. Using DataMapper to work with domain entities without per field setters
21. Persisting Filters
22. Integrate Symfony Workflow Component
23. SonataAdmin without SonataUserBundle



# 
SonataBlockBundle
SonataFormatterBundle
SonataTranslationBundle
SonataUserBundle

SonataClassificationBundle
SonataIntlBundle
SonataMediaBundle
SonataPageBundle