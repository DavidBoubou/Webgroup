v2:

## Supprimer des champs de l'administration.
final class UserAdmin extends Sonata\UserBundle\Admin\Model\UserAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        parent::configureFormFields($form);

        $form
        //remove field
            ->remove('facebookName')
            ->remove('twitterUid')
            ->remove('twitterName')
            ->remove('gplusUid')
            ->remove('gplusName');

        //remove Group    
        $form->removeGroup('nom_du_group', 'nom_de_la_table' );
        //remove all group and tables
        $form->removeGroup('nom_du_group', 'nom_de_la_table',true );
    }

}

# Gestion des libraries de design administrateur
## Select2
https://select2.org/

### Context 
Select2 est basé sur jQuery  pour la box de selection. Il support les recherche, les scroll infinie de resultat, les données distant.
Par défault Select2 est activer sur tout les formulaires.
### use
use Sonata\AdminBundle\Form\Type\ModelType;

protected function configureFormFields(FormMapper $form): void
{
    $form
        ->add('category', ModelType::class, [
            'attr' => [
                //Désactiver/Activer select2 on this form 
                'data-sonata-select2' => 'tru'
                //Désactiver/Activer Allow clear
                'data-sonata-select2-allow-clear' => 'false',
                //caractère minimun pour rechercher les éléments
                'data-sonata-select2-minimumResultsForSearch' => '10',
            ]
        ])
    ;
}

### Disable Select2
#### Disable Select2
>>>config/packages/sonata_admin.yaml
sonata_admin:
    options:
        use_select2:    false # disable select2

#### Disable select2 on some form elements
use Sonata\AdminBundle\Form\Type\ModelType;
protected function configureFormFields(FormMapper $form): void
{
    $form
        ->add('category', ModelType::class, [
            'attr' => [
                'data-sonata-select2' => 'false'
            ]
        ])
    ;
}

## icheck
### Context 
iCheck is a jQuery based checkbox and radio buttons skinning plugin. It provides a cross-browser and accessible solution to checkboxes and radio buttons customization.
The iCheck plugin is enabled on all checkbox and radio form elements by default.

### Disable icheck
#### Disable icheck on all app
>>>config/packages/sonata_admin.yaml
sonata_admin:
    options:
        use_icheck:    false # disable select2

#### Disable icheck on some form elements
use Sonata\AdminBundle\Form\Type\ModelType;
protected function configureFormFields(FormMapper $form): void
{
    $form
        //checkbox or radio
        ->add('category', ModelType::class, [
            'attr' => [
                'data-sonata-icheck' => 'false'
            ]
        ])
    ;
}


## JQueryUI
https://jqueryui.com/sortable/

### Context 
Utilisation de JQuery UI.
### Config Jquery
>>>> webpack.config.js
let Encore = require('@symfony/webpack-encore');

Encore
    //Utiliser Jquery a l'extérieur et garder cette instance en sonata.js
    .addExternals({ jquery: 'jQuery' })
    .addEntry('sonata', './assets/js/sonata.js')

//Importation du JQuery et JqueryUI
>>>> assets/js/sonata.js
import $ from 'jquery';
import 'jquery-ui/ui/widget';
import 'jquery-ui/ui/widgets/draggable';

$('.foo').draggable(); // The new UI plugin can be used.
$('.bar').sortable(); // The already loaded by sonata plugin can be used too.

## Bootlint
### Context 
The admin comes with Bootlint integration. Bootlint is an HTML linter for Bootstrap projects.
You should use it when you want add some contributions on Sonata UI to check the eventual Twitter Bootstrap conventions’ mistakes.

### Activer Bootlint
>>> config/packages/sonata_admin.yaml
sonata_admin:
    options:
        use_bootlint:    true # enable Bootlint


#

## Modifier dynamiquement/condition des Formualaire admin
    protected function configureFormFields(FormMapper $form): void
    {
        // Description field will always be added to the form:
        $form
            ->add('description', TextareaType::class)
        ;
        //The value returned on will be your linked model getSubject()
        $subject = $this->getSubject();

        // If you're using auto-generated identifiers.
        if ($subject->getId() === null) {
            // The thumbnail field will only be added when the edited item is created
            $form->add('thumbnail', FileType::class);
        }

        // Name field sera aujouter sulement pour la route create
        if ($this->isCurrentRoute('create')) {
            $form->add('name', TextType::class);
        }

        // The foo field will added when current action is related acme.demo.admin.code Admin's edit form
        if ($this->isCurrentRoute('edit', 'acme.demo.admin.code')) {
            $form->add('foo', 'text');
        }
        //Si le ROLE 'LIST' alors:
        if ($this->isGranted('LIST')) {
             $form->add('role', 'text');
        }
    }

# Overide Template of route admin with details

##  Customize a route list with  mosaic template custom, route list en  affichage mosaique personnalisé

### Context
Il est possible de configurer la vue par défault en créant un template personnalisé.
La gestion des images demande l'instalation de SontaMediaBundle.

### application

### Configurer l'image de fond par défault:
>>>> config/packages/sonata_admin.yaml
sonata_admin:
    # ...
    options:
        # ...
        mosaic_background: '/path/to/image.png' # or use base64

### Configurer le template:        
>>>> config/services.yaml
services:
    sonata.media.admin.media:
        class: %sonata.media.admin.media.class%
        call:
            method:"setTemplates"
        arguments:
            type:"collection"
            key:"outer_list_rows_mosaic"
            -@SonataMedia/MediaAdmin/list_outer_rows_mosaic.html.twig
        tags:
            -
                name: sonata.admin
                model_class: "%sonata.media.admin.media.entity%"
                controller:"%sonata.media.admin.media.controller%"
                manager_type: orm
                group:"sonata_media"
                translation_domain:"%sonata.media.admin.media.translation_domain%"
                label:"media"
                label_translator_strategy:"sonata.admin.label.strategy.underscore"

//pout une carte de la liste
>>>> list_outer_rows_mosaic.html.twig
// ### Modifier dynamiquement/condition un twig admin
{% extends '@SonataAdmin/CRUD/list_outer_rows_mosaic.html.twig' %}

{% block sonata_mosaic_background %}{{ meta.image }}{% endblock %}

{% block sonata_mosaic_default_view %}
    <span class="label label-primary pull-right">{{ object.providerName|trans({}, 'SonataMediaBundle') }}</span>
{% endblock %}

{% block sonata_mosaic_hover_view %}
    <span class="label label-primary pull-right">{{ object.providerName|trans({}, 'SonataMediaBundle') }}</span>

    {% if object.width %} {{ object.width }}{% if object.height %}x{{ object.height }}{% endif %}px{% endif %}
    {% if object.length > 0 %}
        ({{ object.length }})
    {% endif %}

    <br/>

    {% if object.authorname is not empty %}
       {{ object.authorname }}
    {% endif %}

    {% if object.copyright is not empty and object.authorname is not empty %}
        ~
    {% endif %}

    {% if object.copyright is not empty %}
        &copy; {{ object.copyright }}
    {% endif  %}
{% endblock %}

{% block sonata_mosaic_description %}
    {% if admin.hasAccess('edit', object) and admin.hasRoute('edit') %}
        <a href="{{ admin.generateObjectUrl('edit', object) }}">{{ meta.title|u.truncate(40) }}</a>
    {% elseif admin.hasAccess('show', object) and admin.hasRoute('show') %}
        <a href="{{ admin.generateObjectUrl('show', object }) }}">{{ meta.title|u.truncate(40) }}</a>
    {% else %}
        {{ meta.title|u.truncate(40) }}
    {% endif %}
{% endblock %}


### Configurer le champs image a utilisé et les types de bloc de la route list, gestion imag administrateur 
sonata_mosaic_background: this block is the background value defined in the ObjectMetadata object.
sonata_mosaic_default_view: this block is used when the list is displayed.
sonata_mosaic_hover_view: this block is used when the mouse is over the tile.
sonata_mosaic_description: this block will be always on screen and should represent the entity’s name.
The ObjectMetadata object is returned by the related admin class, and can be used to define which image field from the entity wil.

//Configurations with SonataMediaBundle
>>> AbstractAdmin
use Sonata\AdminBundle\Object\MetadataInterface;
final class MediaAdmin extends AbstractAdmin
{
    //If your field image is a file
    public function getObjectMetadata(object $object): MetadataInterface
    {
        $provider = $this->pool->getProvider($object->getProviderName());

        $url = $provider->generatePublicUrl($object, $provider->getFormatName($object, 'admin'));

        return new Metadata($object->getName(), $object->getDescription(), $url);
    }


    //if your field image is a string
    use Sonata\AdminBundle\Object\MetadataInterface;
    public function getObjectMetadata(object $object): MetadataInterface
    {
        $media = $object->getMediaField();

        $provider = $this->pool->getProvider($media->getProviderName());

        $url = $provider->generatePublicUrl($media, $provider->getFormatName($media, 'admin'));

        return new Metadata($media->getName(), $media->getDescription(), $url);
    }

}
//Then add '@sonata.media.pool' to your service definition arguments:
>>>> config/services.yaml
services:
    app.admin.post:
        class: App\Admin\PostAdmin
        arguments:
            - '@sonata.media.pool'
        tags:
            -
                name: sonata.admin
                model_class: App\Entity\Post
                manager_type: orm
                group: 'Content'

>>> AbstractControlleur     
 //You will also have to use dependency injection. For this, first define the $pool variable and override the constructor:         
use Sonata\MediaBundle\Provider\Pool;
private Pool $pool;
    public function __construct(Pool $pool)
    {
    $this->pool = $pool;
    }

## Customize a route list with Row template *******
https://docs.sonata-project.org/projects/SonataAdminBundle/en/5.x/cookbook/recipe_row_templates/
/**
    The configuration takes place in the DIC by calling the setTemplates method. Two template keys need to be set:
    inner_list_row: The template for the row, which you will customize and extend @SonataAdmin/CRUD/base_list_flat_inner_row.html.twig
    base_list_field: The base template for the cell, the default of @SonataAdmin/CRUD/base_list_flat_field.html.twig.
 */
>>>config/service.yml
services:
    sonata.admin.comment:
        class: "%sonata.admin.comment.class%"
        call:
            method:"setTemplates"
        argument:
        -
        type:"collection"
            inner_list_row:
                - @App/Admin/inner_row_comment.html.twig
            base_list_field:
                - @SonataAdmin/CRUD/base_list_flat_field.html.twig
        tags:
            - { name: sonata.admin, model_class: %sonata.admin.comment.entity%, manager_type: orm, group: 'Content', label: 'Post', pager_type: 'simple', controller:"%sonata.admin.comment.controller%", label_translator_strategy:"sonata.admin.label.strategy.underscore" ,translation_domain="%sonata.admin.comment.translation_domain%"}

>>>twig/inner_row_comment.html.twig
{# @App/Admin/inner_row_comment.html.twig #}

{# Extend the default template, which provides batch and action cells #}
{#     as well as the valid colspan computation #}
{% extends '@SonataAdmin/CRUD/base_list_flat_inner_row.html.twig' %}

{% block row %}

    {# you can use fields defined in the the Admin class #}

    {{ object|render_list_element(admin.list['name']) }} -
    {{ object|render_list_element(admin.list['url']) }} -
    {{ object|render_list_element(admin.list['email']) }} <br/>

    <small>
        {# or you can use the object variable to render a property #}
        {{ object.message }}
    </small>

{% endblock %}


#

## WorkFlow with Sonata ******
//https://symfony.com/doc/current/components/workflow.html
composer require yokai/sonata-workflow

### Application
>>>>>> config/packages/workflow.yaml
framework:
    workflows:
        blog_post:
            type: state_machine
            marking_store:
                type: single_state
                arguments:
                    - status
            supports:
                - App\Entity\BlogPost
            places:
                - draft
                - pending_review
                - pending_update
                - published
            initial_place: draft
            transitions:
                start_review:
                    from: draft
                    to:   pending_review
                interrupt_review:
                    from: pending_review
                    to:   pending_update
                restart_review:
                    from: pending_update
                    to:   pending_review
                publish:
                    from: pending_review
                    to:   published

// Utilisation du workflow sur une extension.
>>>config/packages/sonata_admin.yaml
sonata_admin:
    extensions:
        admin.extension.workflow.blog_post:
            admins:
                - app.admin.blog_post
>>>config/packages/service.yaml
services:
    app.admin.blog_post:
        class: App\Admin\BlogPostAdmin
        tags:
            - { name: sonata.admin, model_class: App\Entity\BlogPost, controller: Yokai\SonataWorkflow\Controller\WorkflowController, manager_type: orm }

    app.admin.extension.workflow.blog_post:
        class: Yokai\SonataWorkflow\Admin\Extension\WorkflowExtension
        arguments:
            - '@workflow.registry'
            - transitions_icons:
                  start_review: fas fa-question
                  interrupt_review: fas fa-edit
                  restart_review: fas fa-question
                  publish: fas fa-check

## Performance de Sonata ******
### Context
Actuces pour améliorer les performances de Sonata.
Améliorer la performance d'un grande demande de donnés Administrateur.

### Virtual Field Descriptions
//ListMapper::NAME_ACTIONS ,ListMapper::NAME_BATCH, should have virtual_field option in order to prevent any side-effects when trying to 
//retrieve the value of this field (which doesn’t exist).

    protected function configureListFields(ListMapper $list): void
    {
        //action lié a l'entité
        $list
            ->add(ListMapper::NAME_ACTIONS, null, [
                'virtual_field' => true,
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
            ])
            ->add(ListMapper::NAME_BATCH, null, [
                'virtual_field' => true,
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

### Improve Performance of Large Datasets with Change default Pager to SimplePager
/*
If your database table contains thousands of records, the database queries generated by SonataAdmin may become very slow. 
Here are tips how to improve the performance of your admin.
Default Pager is counting all rows in the table, so the user can navigate to any page in the Datagrid. But counting thousands or millions of records can be slow operation. If you don’t need to know the number of all records, you can use SimplePager instead. It doesn’t count all rows, but gives user only information if there is next page or not.
*/

>>> config/services.yaml
services:
    app.admin.post:
        class: App\Admin\PostAdmin
        tags:
            - { name: sonata.admin, model_class: App\Entity\Post, manager_type: orm, group: 'Content', label: 'Post', pager_type: 'simple' }


## Overwrite Admin Configuration (overider) !Danger! *****
### Context
Overider les admins par défault de Sonata sonata_admin, ces actions sont très dangereuse.

### Appplication
//With these settings you will be able to change default services and templates used by the admin instances.
>>> config/package/Sonata_admin
sonata_admin:
    default_admin_services:
        # service configuration
        model_manager:              sonata.admin.manager.orm
        data_source:                sonata.admin.data_source.orm
        field_description_factory:  sonata.admin.field_description_factory.orm
        form_contractor:            sonata.admin.builder.orm_form
        show_builder:               sonata.admin.builder.orm_show
        list_builder:               sonata.admin.builder.orm_list
        datagrid_builder:           sonata.admin.builder.orm_datagrid
        translator:                 translator
        configuration_pool:         sonata.admin.pool
        route_generator:            sonata.admin.route.default_generator
        security_handler:           sonata.admin.security.handler
        menu_factory:               knp_menu.factory
        route_builder:              sonata.admin.route.path_info
        label_translator_strategy:  sonata.admin.label.strategy.native
        pager_type:                 default

## Gestion des medias et document

## Actions et CRUD

### Créer une action personnalisé pour l'administration.
>>>twig
//template du bouton du CRUD clone alias list_actionn_{{nom_du_crud}}.html.twig
{# templates/CRUD/list__action_clone.html.twig #}

<a class="btn btn-sm" href="{{ admin.generateObjectUrl('clone', object) }}">clone</a>

>>> CRUDCOntroller
//Action
namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController;

class CarAdminController extends CRUDController
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
        /**
        //Sivous voulez retourner le filtre utilisé
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));

         */
    }
}

>>>>twig
//Template page admin
{% extends '@SonataAdmin/standard_layout.html.twig' %}

{% block sonata_admin_content %}
    Your content here
{% endblock %}

//Déclarer mon action comme service dans un AbstractAdmin.
>>>config/services.yml
services:
    app.admin.car:
        class: App\Admin\CarAdmin
        tags:
            - { name: sonata.admin, model_class: App\Entity\Car, controller: App\Controller\CarAdminController, manager_type: orm, group: Demo, label: Car }

>>>AbstractController
//Ajout de l'action sur le controlleur ainsi il s'affichera sur la page list avec une configuration de la route
    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Route\RouteCollection;

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        //ajout d'une route pour l'action
        $collection
            ->add('clone', $this->getRouterIdParameter().'/clone');
    }

    protected function configureListFields(ListMapper $list): void
    {
        //Ajout du boutton sur chaque ligne de la page list
        $list
            ->addIdentifier('name')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'clone' => [
                        'template' => '@App/CRUD/list__action_clone.html.twig',
                    ]
                ]
            ]);
    }

### Rendre un CrudController dans un twig****
{{ render(controller('App\\Controller\\XxxxCRUDController::comment', {'_sonata_admin': 'sonata.admin.xxxx' })) }}
{{ render(controller('classname::function', {'_sonata_admin': 'MyAdminEntity' })) }}

### Action personnalisé sans Entité
use Sonata\AdminBundle\Route\RouteCollectionInterface;

protected function configureRoutes(RouteCollectionInterface $collection): void
{
    $collection->add('import');
}

// src/Controller/CarAdminController.php

namespace App\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CarAdminController extends CRUDController
{
    public function importAction(Request $request): Response
    {
        // do your import logic
    }
}

>>> AbstractAdmin
//Ajouter l'action dans le Add button de la page list
protected function configureActionButtons(array $buttonList, string $action, ?object $object = null): array
{
    $buttonList['import'] = [
        'template' => 'import_button.html.twig'];

    return $buttonList;
}

//bouton du tableau de bord
protected function configureDashboardActions(array $actions): array
{
    $actions['import'] = [
        'label' => 'import_action',
        'translation_domain' => 'SonataAdminBundle',
        //urt de l'action
        'url' => $this->generateUrl('import'),
        'icon' => 'level-up-alt',
        'template' => 'import_dashboard_button.html.twig'];

    return $actions;
}

>>>twig/import_button.html.twig
//template pour le bouton de la page list
<li>
    <a class="sonata-action-element" href="{{ admin.generateUrl('import') }}">
        <i class="fas fa-level-up-alt"></i> {{ 'import_action'|trans({}, 'SonataAdminBundle') }}
    </a>
</li>

>>>twig/import_dashboard_button.html.twig
<a class="btn btn-link btn-flat" href="{{ admin.generateUrl('import') }}">
    <i class="fas fa-level-up-alt"></i> {{ 'import_action'|trans({}, 'SonataAdminBundle') }}
</a>

### Action 

## Les filtres:

### Sauvegarder le filtre de l'utilisateur ********

#### 1-  Actvivation/Desactivation de la sauvagarde du filtre

##### Actvivation/Desactivation  du filtre Globallement.
>>>config/packages/sonata_admin.yaml
//Activation de la sauvegarder du firtre (false par défault)
sonata_admin:
    persist_filters: true

##### Actvivation/Desactivation  du filtre par Entité Administrateur
>>>config/services.yaml
//Désactiver le filtre par Entité Administrateur
services:
    app.admin.user:
        class: App\Admin\UserAdmin
        tags:
            - { name: sonata.admin, model_class: App\Entity\User,  manager_type: orm, persist_filters: false }

#### 2-  Utiliser un filtre de persistance 

##### Aplication Global du filtre de persistance
//Utiliser un filtre de persistance  Global
>>>config/packages/sonata_admin.yaml

sonata_admin:
    persist_filters: true
    filter_persister: filter_persister_service_id

##### Aplication par entité (User) du filtre de persistance
>>>> config/services.yaml
//Utiliser un filtre de persistance  par admministrateur
services:
    app.admin.user:
        class: App\Admin\UserAdmin
        tags:
            -
                name: sonata.admin
                model_class: App\Entity\User
                manager_type: orm
                filter_persister: filter_persister_service_id