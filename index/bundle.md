
# Verifier si la documentationn correspond a Symfony 6

### Hasher un mot de passe
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

$user = new User();
$user->setUsername('admin');
$password = $this->hasher->hashPassword($user, 'pass_1234');
$user->setPassword($password);


### annotation 
$ composer require sensio/framework-extra-bundle
/*
@Route and @Method
@ParamConverter
@Template
@Cache
@Security & @IsGranted
*/

>>>controller.php 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


    #[Route('/{id}')]
    #[Method('GET')]
    //this with template with paramconverter is usefull for var post.
    #[ParamConverter('post', class: 'SensioBlogBundle:Post')]
    #[Template('@SensioBlog/annot/show.html.twig", vars: ['post'])]
    #[Cache(smaxage: 15, lastmodified: 'post.getUpdatedAt()', etag: "'Post' ~ post.getId() ~ post.getUpdatedAt()")]
    #[IsGranted('ROLE_SPECIAL_USER')]
    #[Security("is_granted('ROLE_ADMIN') and is_granted('POST_SHOW', post)")]
    public function show(Post $post /*the pramconverter*/)
    {

	//Template was return by asset.

    }

### Service (exemple charger un fichier)
- Define the content of tne service
>>> src/Service/className.php

namespace App\Service;
/**
    contruction de notre service
 */
class ClassName
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }
}

>>> config/services.yaml
/**
 - Déclaration de notre service
 - initialisation de l'arguemnt targetdirectory
 */

services:
    App\Service\ClassName:
        arguments:
            $targetDirectory: '%brochures_directory%'

>>> Abstractcontroller <<<
- utiliser le servcce dans un controller

use App\Service\ClassName;

public function UseService(ClassName $className)
{

}

### sécurity and authentification

#### bundle security

##### Formulaire d'authentification 
- authentification a  une interface admin
php bin/console make:auth
php bin/console make:registration-form
>>> config/packages/security.yaml
security:
    # ...

    firewalls:
        main:
            # Gestion des routes de connections
            form_login:
                # "app_login" is the name of the route  created for admin 
                login_path: app_login
                check_path: app_login
                enable_csrf: true
            logout:
                path: app_logout
    #Controller les permission sur les routes
    access_control:
        # require ROLE_ADMIN for /admin*
        - { path: '^/admin', roles: ROLE_ADMIN }

        # or require ROLE_ADMIN or IS_AUTHENTICATED_FULLY for /admin*
        - { path: '^/admin', roles: [IS_AUTHENTICATED_FULLY, ROLE_ADMIN] }

        # the 'path' value can be any valid regular expression
        # (this one will match URLs like /api/post/7298 and /api/comment/528491)
        - { path: ^/api/(post|comment)/\d+$, roles: ROLE_USER }
>>> controller.php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render('login/index.html.twig', [
             'controller_name' => 'LoginController',
             'last_username' => $lastUsername,
             'error'         => $error,
          ]);
    }
}
>>> twig
{# templates/login/index.html.twig #}
{% extends 'base.html.twig' %}

{# ... #}

{% block body %}
    {% if error %}
        <div>{{ error.messageKey|trans(error.messageData, 'security') }}</div>
    {% endif %}

    <form action="{{ path('app_login') }}" method="post">
        <label for="username">Email:</label>
        <input type="text" id="username" name="_username" value="{{ last_username }}">

        <label for="password">Password:</label>
        <input type="password" id="password" name="_password">
        <input type="hidden" name="_csrf_token" value="{{ csrf_token('authenticate') }}">


        {# If you want to control the URL the user is redirected to on success
        <input type="hidden" name="_target_path" value="/account"> #}

        <button type="submit">login</button>
    </form>
{% endblock %}

##### Protection CSRF
/**
    Sécuriser un formulaire ou une authentification dans une session par un token, champs nom visible a valeur unique .

    CSRF - or Cross-site request forgery - is a method by which a malicious user attempts to make your legitimate users unknowingly submit data that they don't intend to submit.

    CSRF protection works by adding a hidden field to your form that contains a value that only you and your user know. This ensures that the user - not some other entity - is submitting the given data.
 */

composer require symfony/security-csrf

>>> config/packages/framework.yaml
framework:
    # ...
    csrf_protection: ~
###### Generer un token manuellement

>>> Abstractcontroller
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

public function delete(Request $request): Response
{
    $submittedToken = $request->request->get('token');

    // 'delete-item' is the same value used in the template to generate the token
    if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
        // ... do something, like deleting an object
    }
}
>>>twig
<form action="{{ url('admin_post_delete', { id: post.id }) }}" method="post">
    {# the argument of csrf_token() is an arbitrary string used to generate the token #}
    <input type="hidden" name="token" value="{{ csrf_token('delete-item') }}"/>

    <button type="submit">Delete item</button>
</form>

###### login form

###### formulaire
>>> AbstractType

use Symfony\Component\OptionsResolver\OptionsResolver;

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => Task::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'task_item',
        ]);
    }

>>> twig <<<
//Overide the theme csrf
{% block csrf_token_widget %} ... {% endblock %}

#### SchebTwoFactorBundle
##### Google authentificationn
https://symfony.com/bundles/SchebTwoFactorBundle/current/providers/google.html



### Email et notifications

### Base


# Front office

### webpack

#### Installer webpack
composer require symfony/webpack-encore-bundle

- Faire un watcher
 encore dev --watch;
 encore production --progress;

- npm install

- //Importer toute les librairie nécessaires par la ligne de commande.
// fontawesome, bootstrap ...

//Importer les librairies dans le scripts js .
>>>assets/app.js

//module Jquery, bootstrap, protocole ES6 
import $ from 'Jquery';
import 'Bootstrap';

//Importer le javascript dans le js.
import  '../myscript.js';
import './Mymodule.js';

//Importer le css.
//...

//Faire une variable global Jquery si nécessaire pour un script du template indépendant.
global.$=$;

>>>assets/app.css
//Importer le css du node_module/bootstrap
@import '~bootstrap';

>>> twig
//Réaliser les balise scripts et css avec les styles compiler de webpack..
<link rel="stylesheet" src="{{asset ('public/bundle/app.js')}}"

//

>>> webpack.config.js
// Déclarer le fichier javascript sur webpack.config.js
addEntry('app','./asset/app.js'); 


//Optimiser la tailles du css avec 
.splitEntryChunks()

// enables Sass/SCSS support
//.enableSassLoader()


// uncomment if you're having problems with a jQuery plugin
.autoProvidejQuery()

>>> build/
// Insérer les images dans le build/ folder vous pourrer alors utiliser le css et autres fonctionnalité.



#### Installer  Symfony UX (voir le bac-office pour les champs personnalisé CKeditor)

#  Back - office, champs personalisé et formulaire (ux)
https://symfony.com/doc/current/reference/forms/types/

### formulaires
Realisation d'un objet formulaire avec des champs/messages dynamiques non ajax  selon la requete (event), et des champs relationnelle a d'autre entité one to many (collection) des formulaire embarqué dans un champs (embarqué) et une sécurité csrf.
Se fromulaire est utilisé pour créer, et mettre ajour une entité.

Différencier les champs type collection (action de suppression et d'ajout sur des relation) et le champs type EntityType::Class (affichage de donées de class sans action spécifique)

- formulaire de base
- formulaire spécifique et réutilisable
- formulaire a entité de relation
- Evenement sur formulaire
- Champs relationnel d'un formulaire
- bloc de champs réutilisable dans different formuulaire
- Protection crsf d'un formulaire
- utilisation d'un theme (theme personnalisé, theme bootstrap, structure éphémère)

#### configurationn d'un formulaire réutilisable
composer require symfony/form
php bin/console make:form

>>> AbstractType.php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        //Champs avec contrainte
            ->add('task', TextType::class, [
            'help'=>'Type of task',
            'label'=>'taches', 
            //css fiel_row
             'row_attr' => ['class' => 'text-editor', 'id' => '...'],   
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 3]),
            ],)

            //champs non requis  de valeur John doe si le champs est vide
            ->add('Task_other_label', TextType::class,[
                    'required'   => false,
                    'empty_data' => 'John Doe',
                ])

            // Ajout d'un prefix/fragment définie comme '_prefix_ ' a la generation du dom du champs du formulaire a l'attribut 'id'
            ->add('dueDate', DateType::class,
                'block_prefix' => '_prefix_',)

            //Ajout d'un fichier pdf
            ->add('brochure', FileType::class, [
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
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    //Definition des bouton de validation
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // protection crsf ...
            //...

            //inherit_data, Faire de la classType champs réutilisabe
            //..

            //Set basic data for a form type blog with empty field            
            'empty_data' => function (FormInterface $form) {
                return new Blog($form->get('title')->getData());
            },

            // Definition des  group de validation de formualire bouton register
            //'validation_groups' => false,
            'validation_groups' => ['registration'],
        ]);
    }

>>> abstractController.php

use Symfony\Component\String\Slugger\SluggerInterface;

/** 
//Définition du formulaire voir Abstractype
       $form = $this->createFormBuilder($task, /*[
            'action' => $this->generateUrl('target_route'),
            'method' => 'GET',
        ]
        */)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->add('saveAndAdd', SubmitType::class, ['label' => 'Create Task And Add a ohter'])
            ->getForm();
*/


public functionn Myfunction(Request $request, SluggerInterface $slugger)
        {
                //Initialisation de la date du formulaire Task
                $task->setDueDate(new \DateTime('tomorrow'));

                //Construction le formualaire d'entité Tast et de class Tasktype
                $form = $this->createForm(TaskType::class, $task)
                            ->setAction($this->generateUrl('target_route'))
                            ->setMethod('GET');

                //Obtention de la requete du formulaire
                 $form->handleRequest($request);

                /**
                // use the form on a media already persist
                use Symfony\Component\HttpFoundation\File\File;

                    $product->setBrochureFilename(
                        new File($this->getParameter('brochures_directory').'/'.$product->getBrochureFilename())
                    );
                 */
                //Traitement des données du formulaire a sa soumission
                if ($form->isSubmitted() && $form->isValid()) {

                    
                     //set path of a pdf brochure
                        /** @var UploadedFile $brochureFile */
                        /*            $brochureFile = $form->get('brochure')->getData();

                                    // this condition is needed because the 'brochure' field is not required
                                    // so the PDF file must be processed only when a file is uploaded
                                    if ($brochureFile) {
                                        $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                                        // this is needed to safely include the file name as part of the URL
                                        $safeFilename = $slugger->slug($originalFilename);
                                        $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                                        // Move the file to the directory where brochures are stored
                                        try {
                                            $brochureFile->move(
                                            //parametre brochure_directory définie dans config/service.yaml
                                                $this->getParameter('brochures_directory'),
                                                $newFilename
                                            );
                                        } catch (FileException $e) {
                                            // ... handle exception if something happens during file upload
                                        }

                                        // updates the 'brochureFilename' property to store the PDF file name
                                        // instead of its contents
                                        $product->setBrochureFilename($newFilename);                    
                    
                    
                     */

                    // Obtentionn de la valeur de field_name_of_task du formulaire
                    $form->get('field_name_of_task')->getData();

                    // $form->getData() us a array holds the submitted values
                    // but, the original `$task` variable has also been updated
                    $task = $form->getData();

                    // ... perform some action, such as saving the task to the database

                    //Multiple button, if SaveAndAdd action else.
                    if ($form->getClickedButton() === $form->get('saveAndAdd')){
                        // ...
                    }

                    return $this->redirectToRoute('task_success');
                }


                //Construction du formulaire
                return $this->renderForm('task/new.html.twig', [
                    'form' => $form,
                ]);
        }

>>> twig

    {# templates/task/new.html.twig #}

    {{ form_start(form, {'method': 'GET'}) }}

        {{ form_label(form) }}
        {{ form_widget(form, {'attr': {'class': 'foo'}}) }}
        {{ form_help(form) }}
        {{ form_errors(form) }}

        or
            {{ form_errors(form.field_name_of_task) }}
        <div>
            {# a block of label, widget,help and errors together#}
            {{ form_row(form.field_name_of_task) }}
        </div>

        or

        {{ form_rest(form) }}
        

    {{ form_end(form) }}

>>> config/services.yaml <<<

//Definitioin du chemin de chargement de media (brochure) doit etre appelé a l'extérieur
parameters:
    brochures_directory: '%kernel.project_dir%/public/uploads/brochures'


#### Formulaire basique ( sans AbstractType )
>>> AbstractController

   public function contact(Request $request){

        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData,[
    'validation_groups' => ['send'],])
            ->add('name', TextType::class, [
                'help' => 'Add your name',
                'label' => 'name',
            ])
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();

                //Construction du formulaire
                return $this->renderForm('contact/new.html.twig', [
                    'form' => $form,
                ]);
            }

#### ** Soumettre un formualire a distance (AJAX)**
- Danger
>>>
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// ...

public function new(Request $request): Response
{
    $task = new Task();
    $form = $this->createForm(TaskType::class, $task);

    if ($request->isMethod('POST')) {
        $form->submit($request->request->get($form->getName()));

        if ($form->isSubmitted() && $form->isValid()) {
            // perform some action...
            
        // '$json' represents payload data sent by React/Angular/Vue
        // the merge of parameters is needed to submit all form fields
        $form->submit(array_merge($json, $request->request->all()));

        //Soumettre un champs spécifique du formulaire 
        $form->get('firstName')->submit('Fabien');

            return $this->redirectToRoute('task_success');
        }
    }

    return $this->renderForm('task/new.html.twig', [
        'form' => $form,
    ]);
}

#### bloc de champs réutilisable dans different formuulaire (innerith_data)
//Permet d'éviter la duplication de champs de différents formulaire

>>> AbstractType(1) (donné relationnel a utilisé dans un formlaire (2))

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextareaType::class)
            ->add('zipcode', TextType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }

>>> abstractType(2).php (formulaire avec champs relationnel)
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // ...

        $builder->add('foo', -ClassName of abstractType(1)-::class, [
            'data_class' => -ClassName of abstractType(2)- ::class,
        ]);
    }

#### Champs prédilection (afficher les donné des la BDD)

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

$builder->add('users', EntityType::class, [
    // class a affiché comme donné 
    'class' => User::class,

    //Requete personnalisé pour afficher les données
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('u')
            ->orderBy('u.username', 'ASC');
    },

    // uses the User.username property as the visible option string
    // champs de la classe a afficher
    'choice_label' => 'field_entity',

    // this method must return an array of User entities
    //on top of the list of the entity
    'preferred_choices' => $group->getPreferredUsers(),

    // used to render a select box, check boxes or radios
    // 'multiple' => true,
    // 'expanded' => true,


]);

#### *** champs relationel de formulaire (collection) /relation dentité /formulaire embarqué ***
https://symfony.com/doc/current/form/form_collections.html

- Dangeureux--------------------------------------------------------------------------------------------------------------------
// Formulaire, entity, controleur, javascript (create html element and curl)
// Ajout d'item dynamiquement en javascript dans le dom puis sauvegarder leur valeur dans l'orm.
// Suppression d'ellement dans le dom puis sur serveur via un curl javascript
// Entité de relation manytomany ou oneToMany

>>> Entity (1) contenant

//Entité (2) de relation
#[ORM\ManyToMany(targetEntity: Tag::class, cascade: ['persist'])]
protected $tags;

public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

//fonction de l'entité(2) de relation
public function getTags(): Collection
    {
        return $this->tags;
    }


    //function for add Entity2 in the database
    public function addEntity2(Entity2 $tag): void
    {
        $this->tags->add($tag);
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }
>>> Entity (2) cible
// Put your entity ORM there

>>>> Entity(2)AbstractType
//Put your form structure 

>>> AbstractType/AbstarctController (Entity1 )(contenant)

$builder->add('emails', CollectionType::class, [
    // each entry in the array will be an "email" field
    'entry_type' => - Entity2Type EmailType -::class,

    // these options of entrytype (emailType) are passed to each "email" type
    'entry_options' => [
        'help' => 'You can edit this name here.',
        'attr' => ['class' => 'email-box'],
    ],

    //Autoriser l'ajout de nouveau contenu accompagner d'un bouton javascript
    'allow_add' => true,

    //Autoriser la suppression d'un item de collection
    'allow_delete' => true,

    //Is true with allow_add for generate template with var __name__
    'prototype' => true,

    //Valeur par défaut de l'entryType (email)
    'prototype_data' => 'Ncontact@gmail.com',


    // Supprimer tout la collection
    'delete_empty' => function (User $user = null) {
        return null === $user || empty($user->getFirstName());
    },

]);

>>> js
// add-collection-widget.js

jQuery(document).ready(function () {
    jQuery('.add-another-collection-widget').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list-selector'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
});

>>> twig
// Ajout de nouveau item de collection en javascript sur le tableau


{% endfor %}
{{ form_start(form) }}
    {# ... #}

    {# store the prototype on the data-prototype attribute #}
    <ul id="email-fields-list"
        data-prototype="{{ form_widget(form.emails.vars.prototype)|e }}"
        data-widget-tags="{{ '<li></li>'|e }}"
        data-widget-counter="{{ form.emails|length }}">
    {% for emailField in form.emails %}
        <li>
            {{ form_errors(emailField) }}
            {{ form_widget(emailField) }}
        </li>
    {% endfor %}
    /**
    or
    {{ form_row(form.emails) }}
    */
    </ul>

    <button type="button"
        class="add-another-collection-widget"
        data-list-selector="#email-fields-list">Add another email</button>

    {# ... #}
{{ form_end(form) }}

<script src="add-collection-widget.js"></script>


#### Evenement de formulaire / Ajout dynamique de champs si chekbox
/**
// All event 

PRE_SET_DATA :event is dispatched at the beginning of the Form::setData() method. It can be used to: Modify the data given during pre-population,Modify a form adding or removing fields dynamically).

SET_DATA:

POST_SET_DATA :This event is mostly here for reading data after having pre-populated the form.

PRE_SUBMIT: Manage data and field before submit.

SUBMIT: 

POST_SUBMIT: At this point, you cannot add or remove fields to the current form and its children.

 */
##### Enregistrer un Evenement 

- Définir l'évènement.
>>> (implements) EventSubscriberInterface

// src/Form/EventListener/AddEmailFieldListener.php
namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddEmailFieldListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
        $user = $event->getData();
        $form = $event->getForm();

        // checks whether the user from the initial data has chosen to
        // display their email or not.
        if (true === $user->isShowEmail()) {
            $form->add('email', EmailType::class);
        }
    }

    public function onPreSubmit(FormEvent $event): void
    {
        //Obtention des utlisateur
        $user = $event->getData();

        //obtention du formulaire
        $form = $event->getForm();

        //Si l'utilisateur n'existe pas
        if (!$user || null === $user->getId()) {
            return;
        }

        // checks whether the user has chosen to display their email or not.
        // If the data was submitted previously, the additional value that
        // is included in the request variables needs to be removed.
        if (isset($user['showEmail']) && $user['showEmail']) {
            //Ajout du champs email
            $form->add('email', EmailType::class);
        } else {
            unset($user['email']);
            //Sauvegarde des donné user
            $event->setData($user);
        }
    }
}


>>>AbstractType/AbstractControleur - appeler l'évènement
use App\Form\EventListener\MyEventListerner_from_EventSubscriberInterface;


$form = $formFactory->createBuilder()
    ->add('username', TextType::class)
    ->add('showEmail', CheckboxType::class)
    //Appel de l'évènement
    ->addEventSubscriber(new AddEmailFieldListener())
    ->getForm();



##### Definir un evenement dans un formulaire.
>>> AbstractController <<<
- Evenement de formulaire dans un controlleur

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

$listener = function (FormEvent $event) {
    // ...
     $user = $event->getData();
        $form = $event->getForm();

        if (!$user) {
            return;
        }

        // checks whether the user has chosen to display their email or not.
        // If the data was submitted previously, the additional value that is
        // included in the request variables needs to be removed.
        if (isset($user['showEmail']) && $user['showEmail']) {
            $form->add('email', EmailType::class);
        } else {
            unset($user['email']);
            $event->setData($user);
        }
    })
};

$form = $formFactory->createBuilder()
    // Ajout d'un evenement de type PRE8submit
    ->addEventListener(FormEvents::PRE_SUBMIT, $listener)
    ->getForm();


>>> AbstractType <<<
- Evenement dans un AbstractType

// src/Form/SubscriptionType.php
namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

// ...
class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class)
            ->add('showEmail', CheckboxType::class)
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )
        ;
    }

    public function onPreSetData(FormEvent $event): void
    {
        // ...
    }
}

##### chapitre 1 : Formulzire embarqué dans un formulaire (entité lié a une entité)
//Suppose that each Task belongs to a Category object. Start by creating the Category class:
>>> Entity(1).php
- // Definir une entié

>>> Entity(2).php
-    //Définir une entité contenant avec une variable ClassName de l'Entité(1) protégé et les fonctions associés et les assert ci-dessous 

    #[Assert\Type(type: Category::class)]
    #[Assert\Valid]
    protected $category;


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category)
    {
        $this->category = $category;
    }

>>> AbstractType (cible) use with Entity(1)
 // Define the structure of the form entity(1)

>>> AbstractType (contenant) use with Entity(2)

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    // ...

    $builder->add('Mon_entité_orm_lié_a_cette_entité_du_formulaire', -ClassNameAbstractType(cible) -::class);
}

>>> twig 

    {{ form_row(form.field_Entity_relationship_field.field) }}

##### chapitre 2 : Collection de champs de formulaire
>>> twig
 -overrider un template de collection
{% block collection_row %} ... {% endblock %}
{% block collection_label %} ... {% endblock %}
{% block collection_widget %} ... {% endblock %}
{% block collection_help %} ... {% endblock %}
{% block collection_errors %} ... {% endblock %}

#### Champs personnalisé (donné static)
//créer un champs basé sur un type de champs permettant d'éviter la rendendance de création du même type de champs a configuration complex.

>>> src/Form/Type/MyCustomFieldType extends AbstractType.php   (field cible)
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    //1-configuration des options du champs (choiceType)
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [
                'Standard Shipping' => 'standard',
                'Expedited Shipping' => 'expedited',
                'Priority Shipping' => 'priority',
            ],
        ]);
    }

    //1-Obtention du champs parent
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    //2- Definition d'un champs multiple (si recontruction de formulaire de 0 sans getParent())
 /*    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addressLine1', TextType::class, [
                'help' => 'Street address, P.O. box, company name',
            ])
            ->add('addressLine2', TextType::class, [
                'help' => 'Apartment, suite, unit, building, floor',
            ])
            ->add('city', TextType::class)
            ->add('state', TextType::class, [
                'label' => 'State',
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'ZIP Code',
            ])
        ;
    }
*/



    // .It sets any extra variables you'll need when rendering the field in a template.
/*
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        // pass the form type option directly to the template
        $view->vars['isExtendedAddress'] = $options['is_extended_address'];

        // make a database query to find possible notifications related to postal addresses (e.g. to
        // display dynamic messages such as 'Delivery to XX and YY states will be added next week!')
        $view->vars['notification'] = $this->entityManager->find('...');
    }
*/

//Intégratation du champs dans un formulaire
>>> src/Form/Type/AbstractType (formulaire ou contenant)
namespace App\Form\Type;

use App\Form\Type\MyCustomFieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ...
            ->add('My Custom Field Type', MyCustomFieldType::class)
        ;
    }

>>> twig <<<< (si champs multiple)
{# templates/form/custom_types.html.twig #}
{% block postal_address_row %}
    {% for child in form.children|filter(child => not child.rendered) %}
        <div class="form-group">
            {{ form_label(child) }}
            {{ form_widget(child) }}
            {{ form_help(child) }}
            {{ form_errors(child) }}
        </div>
    {% endfor %}
{% endblock %}


#### **** class pour deviné un champs de formulaire (Guesser) ****
- Très dengereux

>>>> implements FormTypeGuesserInterface
namespace App\Form\TypeGuesser;

use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\Guess\ValueGuess;

class ClassNameForGuesser implements FormTypeGuesserInterface
{
    //1-Tries to guess the type of a field;
    public function guessType(string $class, string $property): ?TypeGuess
    {
         $annotations = $this->readPhpDocAnnotations($class, $property);

        if (!isset($annotations['var'])) {
            return null; // guess nothing if the @var annotation is not available
        }

        // otherwise, base the type on the @var annotation
        return match($annotations['var']) {
            // there is a high confidence that the type is text when
            // @var string is used
            'string' => new TypeGuess(TextType::class, [], Guess::HIGH_CONFIDENCE),

            // integers can also be the id of an entity or a checkbox (0 or 1)
            'int', 'integer' => new TypeGuess(IntegerType::class, [], Guess::MEDIUM_CONFIDENCE),

            'float', 'double', 'real' => new TypeGuess(NumberType::class, [], Guess::MEDIUM_CONFIDENCE),

            'boolean', 'bool' => new TypeGuess(CheckboxType::class, [], Guess::HIGH_CONFIDENCE),

            // there is a very low confidence that this one is correct
            default => new TypeGuess(TextType::class, [], Guess::LOW_CONFIDENCE)
        };
    }

    //2-Tries to guess the value of the required option;
    public function guessRequired(string $class, string $property): ?ValueGuess
    {
    }

    //3-Tries to guess the value of the maxlength input attribute;
    public function guessMaxLength(string $class, string $property): ?ValueGuess
    {
    }

    //4-Tries to guess the value of the pattern input attribute.
    public function guessPattern(string $class, string $property): ?ValueGuess
    {
    }

    //My custom funvtion optionnaly
     $annotations = $this->readPhpDocAnnotations($class, $property);

        if (!isset($annotations['var'])) {
            return null; // guess nothing if the @var annotation is not available
        }

        // otherwise, base the type on the @var annotation
        return match($annotations['var']) {
            // there is a high confidence that the type is text when
            // @var string is used
            'string' => new TypeGuess(TextType::class, [], Guess::HIGH_CONFIDENCE),

            // integers can also be the id of an entity or a checkbox (0 or 1)
            'int', 'integer' => new TypeGuess(IntegerType::class, [], Guess::MEDIUM_CONFIDENCE),

            'float', 'double', 'real' => new TypeGuess(NumberType::class, [], Guess::MEDIUM_CONFIDENCE),

            'boolean', 'bool' => new TypeGuess(CheckboxType::class, [], Guess::HIGH_CONFIDENCE),

            // there is a very low confidence that this one is correct
            default => new TypeGuess(TextType::class, [], Guess::LOW_CONFIDENCE)
        };
}
>>> config/services.yaml
services:
    //Déclaration de notre guesser personnalisé
    App\Form\TypeGuesser\clanameGuesser:
        tags: [form.type_guesser]


>>>Abstaract
use App\Form\TypeGuesser\ClassNameGuesser;
use Symfony\Component\Form\Forms;

$formFactory = Forms::createFormFactoryBuilder()
    //  Ajout du Guess pour deviner le type du champs.
    ->addTypeGuesser(new ClassNameGuesser())
    ->getFormFactory();


#### application de theme (bootstrap , custom) au formulaire 

#### Theme personnalisé

{# templates/form/my_theme.html.twig #}
{% use 'form_div_layout.html.twig' %}

{# ... override only the blocks you are interested in #}

{# widget with field integer #}
{% block integer_widget %}
    <div class="some-custom-class">
        {{ parent() }}
    </div>
{% endblock %}

{% block form_errors %}
    {% if errors|length > 0 %}
        {% if compound %}
            {# ... display the global form errors #}
            <ul>
                {% for error in errors %}
                    <li>{{ error.message }}</li>
                {% endfor %}
            </ul>
        {% else %}
            {# ... display the errors for a single field #}
        {% endif %}
    {% endif %}
{% endblock form_errors %}

#### Appliquer un theme a tout les formulaire
>>> config/packages/twig.yaml
twig:
//mettre le theme le plus important a la fin de la liste pour overider les autres themes
    form_themes: ['bootstrap_5_horizontal_layout.html.twig']

#### Appliquer un theme au formulaire spécifique
>>> twig
- bootrap 5
{# this form theme will be applied only to the form of this template #}
{% form_theme form 'foundation_5_layout.html.twig' %}

- Multiple theme
{# apply multiple form themes but only to the form of this template #}
{% form_theme form with [
    'foundation_5_layout.html.twig',
    'form/my_custom_theme.html.twig'
] %}

- theme unique
{# apply the form themes  only form.a_child_form  form element #}
{% form_theme form.a_child_form 'form/my_other_theme.html.twig' %}

- Appliquer un thme sur champs spécifique avec fragment du formulaire form
{% extends 'base.html.twig' %}
{% form_theme form _self %}

{# this overrides the widget of any field of type integer, but only in the
   forms rendered inside this template #}
{% block integer_widget %}
    <div class="...">
        {# ... render the HTML element to display this field ... #}
    </div>
{% endblock %}

{# this overrides the entire row of the field whose "id" = "product_stock" (and whose
   "name" = "product[stock]") but only in the forms rendered inside this template #}
{% block _product_stock_row %}
    <div class="..." id="...">
        {# ... render the entire field contents, including its errors ... #}
    </div>
{% endblock %}

#### debuguer un formulaire
php bin/console debug:form FooType
- La génération HTML d'un formulaire construit au niveau du controller laisse un signature dans les attributd des éléments.
  Le préfix de cette signature se modifie par  'block_name' => '_préfixe_', de builderInterface.
    ex:id="form_age" name="form[age]"





#### validation
- use with group_validation form

>>> src/Validation/V
namespace App\Validation;

use Symfony\Component\Form\FormInterface;
/**
 __invoke and __contruct function are called at begin  when the class is called
 */

class ValidationGroupResolver
{
    private $service1;

    private $service2;

    public function __construct($service1, $service2)
    {
        $this->service1 = $service1;
        $this->service2 = $service2;
    }

    public function __invoke(FormInterface $form): array
    {
        $groups = [];

        // ... determine which groups to apply and return an array

        return $groups;
    }
}
>>> AbstractType
    private $groupResolver;

    public function __construct(ValidationGroupResolver $groupResolver)
    {
        $this->groupResolver = $groupResolver;
    }

    // ...
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'validation_groups' => $this->groupResolver,
        ]);
    }


### CKeditor

#### Configurer le champs de formulaire CKEDITOR
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

#### ne pas afficher la barre de progression 
php bin/console ckeditor:install --no-progress-bar


####  utiliser ckeditor dans un formulaire avec un champs textaera
use FOS\CKEditorBundle\Form\Type\CKEditorType;

$builder->add('field', CKEditorType::class, array(
    'config' => array(
        'uiColor' => '#ffffff',
        //...
    ),
));

#### Installation de ckeditor sur Webpack

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

#### Faire une configuration ckeditor
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

#### Faire une configuration spécifique.
    use FOS\CKEditorBundle\Form\Type\CKEditorType;

    $builder->add('field', CKEditorType::class, array(
        'config' => array(
            //some config
        ),
    ));

#### Afficher le formulaire dynamique ckeditor
>>> config/ckeditor.yaml

    autoload: false
    async: true
>>> twig
{{ form_javascript(form) }}


#### possibilité d 'utiliser un template personnalisé.

####  Possibilité de stylysé les composants de CKEditor.

#### CKEditor et easyAdmin
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

#### Construire un json pour ckeditor
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


### image
>>>twig
<!-- when loading the page this is transformed into a dynamic widget via JavaScript -->
<input type="file">
>>>crudcontroller
yield ImageField::new('...')
->setBasePath('chemin d'enregistrement');
->setUploadedFileNamePattern('[year]/[month]/[day]/[slug]-[contenthash].[extension]');



### Dropzone
composer require symfony/ux-dropzone
npm install --force
npm run watch

>>>controller.php
use Symfony\UX\Dropzone\Form\DropzoneType;
//formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('photo', DropzoneType::class)
            // ...
        ;
    }
///Stylisé le css de dropzone et configurer les hook
>>> assets/controllers.json

### chartjs
https://symfony.com/bundles/ux-chartjs/current/index.html
composer require symfony/ux-chartjs
npm install --force
npm run watch

>>>controller.php
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('home/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}

>>>>twig
{{ render_chart(chart) }}

{# You can pass HTML attributes as a second argument to add them on the <canvas> tag #}
{{ render_chart(chart, {'class': 'my-chart'}) }}

{# Avec Stimulus #}
{{ stimulus_controller('@symfony/ux-chartjs/chart') }}

>>>mychart_controller.js
// Il est possible de configurer des évènements du charjs .



### fixures
https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html#writing-fixtures
Faire de fausse données
composer require --dev orm-fixtures
composer require doctrine/doctrine-fixtures-bundle
php bin/connsole make:fixtures

*Faire le script pour l'entité spécifique product
>>>> fixure.php (class AppFixtures extends Fixture)
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

  public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
//Put your code there
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }

*Exécuter le script
>>console
php bin/console doctrine:fixtures:load
**Exécuter une fixure spécifique de class UserFixtures
php bin/console doctrine:fixtures:load --group=UserFixtures


**En cas de multiple fichier de fixure , pour créer le lien entre les fixures
insérer 
$this->getReference({{MyClassNameClassName}}::{{MyKeyName}} ), 

puis créer l'instance de l'entité de référence dans la class spécifique avec
$this->addReference(self:: {{MyKeyName}}, {{MyCompleteInstanceEntity}});

** Ordonné les fixures
**Sur les élements enfants implements DependentFixtureInterface et utliser la fonction getDependencies pour lister les fixures de dépendances de la class
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupFixtures extends Fixture implements DependentFixtureInterface
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }


**utiliser des fixures d un autres répertoires

# Tableau de bord
### Administration (EasyAdmin , ea_url , ea_template)

#### Page d'accueil interface d'administrationn
composer require easycorp/easyadmin-bundle
- Créer une interface administrateur avec l'affichage des vues et formulaire ainsi que les boutons d'action ainsi que chart.js.
 ##### Admin accueil
- la class de l'accueil administratif extends AbstractDashboardController
php bin/console make:admin:dashboard
 ##### Dashboard Configuration.
- configuration du titre de l'icone, localisation de l'interface administrateur.
 public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('ACME Corp.')

            // translation, the argument is the name of any valid Symfony translation domain
            ->setTranslationDomain('admin');

            // you can include HTML contents too (e.g. to link to an image)
            ->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')

            // by default EasyAdmin displays a black square as its default favicon;
            // use this method to display a custom favicon: the given path is passed
            // "as is" to the Twig asset() function:
            // <link rel="shortcut icon" href="{{ asset('...') }}">
            ->setFaviconPath('favicon.svg')

            // the domain used by default is 'messages'
            ->setTranslationDomain('my-custom-domain')

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr')

            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
            ->renderContentMaximized()

            // set this option if you prefer the sidebar (which contains the main menu)
            // to be displayed as a narrow column instead of the default expanded design
            ->renderSidebarMinimized()

            // by default, users can select between a "light" and "dark" mode for the
            // backend interface. Call this method if you prefer to disable the "dark"
            // mode for any reason (e.g. if your interface customizations are not ready for it)
            ->disableDarkMode()

            // by default, all backend URLs are generated as absolute URLs. If you
            // need to generate relative URLs instead, call this method
            ->generateRelativeUrls()

            // set this option if you want to enable locale switching in dashboard.
            // IMPORTANT: this feature won't work unless you add the {_locale}
            // parameter in the admin dashboard URL (e.g. '/admin/{_locale}').
            // the name of each locale will be rendered in that locale
            // (in the following example you'll see: "English", "Polski")
            ->setLocales(['en', 'pl'])
            // to customize the labels of locales, pass a key => value array
            // (e.g. to display flags; although it's not a recommended practice,
            // because many languages/locales are not associated to a single country)
            ->setLocales([
                'en' => '🇬🇧 English',
                'pl' => '🇵🇱 Polski'
            ])
            // to further customize the locale option, pass an instance of
            // EasyCorp\Bundle\EasyAdminBundle\Config\Locale
            ->setLocales([
                'en', // locale without custom options
                Locale::new('pl', 'polski', 'far fa-language') // custom label and icon
            ])
        ;
    }
}

 ###### Configuration du menu administrateur.
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

/**
setCssClass(string $cssClass), sets the CSS class or classes applied to the <li> parent element of the menu item;

setLinkRel(string $rel), sets the rel HTML attribute of the menu item link (check out the allowed values for the "rel" attribute);

setLinkTarget(string $target), sets the target HTML attribute of the menu item link (_self by default);

setPermission(string $permission), sets the Symfony security permission that the user must have to see this menu item. Read the menu security reference for more details.

setBadge($content, string $style='secondary'), renders the given content as a badge of the menu item. It's commonly used to show notification counts. The first argument can be any value that can be converted to a string in a Twig template (numbers, strings, stringable objects, etc.) 

The second argument is one of the predefined Bootstrap styles (primary, secondary, success, danger, warning, info, light, dark) or an arbitrary string content which is passed as the value of the style attribute of the HTML element associated to the badge.

 */
   public function configureMenuItems(): iterable
    {
        /**
        //Génerate automatically Links with condition.
         if ('... some complex expression ...') 
            {
            yield MenuItem::section('Blog');
            yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class);
            yield MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', BlogPost::class);
            }

        //Set permission
        if ($this->isGranted('ROLE_EDITOR') && '...') {
                yield MenuItem::linkToCrud('Blog Posts', null, BlogPost::class);
            }
         */
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            //Si Role editor alors lien accessible
            MenuItem::linkToCrud('Blog Posts', null, BlogPost::class)
            ->setPermission('ROLE_EDITOR'),

            //Separation visuel sur le menu pour afficher Blog
            MenuItem::section('Blog'),
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class),
            MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', BlogPost::class),

            //Sous menu 
            MenuItem::subMenu('Blog', 'fa fa-article')->setSubItems([
                        MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class),
                        MenuItem::linkToCrud('Posts', 'fa fa-file-text', BlogPost::class),
                        MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
                    ]),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),

            // links to a different CRUD action
            MenuItem::linkToCrud('Add Category', 'fa fa-tags', Category::class)
                ->setAction('new'),

            MenuItem::linkToCrud('Show Main Category', 'fa fa-tags', Category::class)
                ->setAction('detail')
                ->setEntityId(1),

            // if the same Doctrine entity is associated to more than one CRUD controller,
            // use the 'setController()' method to specify which controller to use
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class)
                ->setController(LegacyCategoryCrudController::class),

            // uses custom sorting options for the listing
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class)
                ->setDefaultSort(['createdAt' => 'DESC']),

            // Lien de route
            MenuItem::linkToRoute('Visite my route ', 'fa ...', 'route_name'),

            // Déconnection de l'interface administration
            MenuItem::linkToLogout('Logout', 'fa fa-exit'),

            //The link where the user can stop impersonnate user.
            MenuItem::linkToExitImpersonation('Stop impersonation', 'fa fa-exit'),
        ];
    }

 ###### Configuration du menu pour un utilisateur authentifié.

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFullName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(false)

            // you can return an URL with the avatar image
            ->setAvatarUrl('https://...')
            ->setAvatarUrl($user->getProfileImageUrl())
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false)
            // you can also pass an email address to use gravatar's service
            ->setGravatarEmail($user->getMainEmailAddress())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }

 ###### Context administrateur
    /**
        EasyAdmin initializes a variable of type EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext automatically on each backend request. This object implements the context object design pattern and stores all the information commonly needed in different parts of the backend.

        This context object is automatically injected in every template as a variable called ea (the initials of "EasyAdmin"):
    */
    >>> admin/Admin-extends-AbstractDashboardController.php
    use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

        public function someMethod(AdminContext $context)
        {
            // ...
        }
    >>> twig
    <h1>{{ ea.dashboardTitle }}</h1>

    {% for menuItem in ea.mainMenu.items %}
    {# ... #}
    {% endfor %}

#### Gestion du cahier de charge admin 

##### Les base de l'interface admin (Dashboard et CrudController)
###### create, show, update, delete content by admin and role.
/**
The design of the backend is ready for any kind of application. It's been created with Bootstrap 5, Font Awesome icons and some custom CSS and JavaScript code; all managed by Webpack via Symfony's Webpack Encore.

Like any other Symfony bundle, assets are copied to (or symlinked from) the public/bundles/ directory of your application when installing or updating the bundle. If this doesn't work for any reason, your backend won't display the proper CSS/JS styles. In those cases, run this command to install those assets manually:
 */

 php bin/console make:admin:crud

     // it must return a FQCN (fully-qualified class name) of a Doctrine ORM entity
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

   public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('...')
            ->setDateFormat('...')

        /**
         Design
         */
        // set this option if you prefer the page content to span the entire
        // browser width, instead of the default design which sets a max width
        ->renderContentMaximized()

        // set this option if you prefer the sidebar (which contains the main menu)
        // to be displayed as a narrow column instead of the default expanded design
        ->renderSidebarMinimized()

        /**
        Entity option
         */
        // the labels used to refer to this entity in titles, buttons, etc.
        ->setEntityLabelInSingular('Product')
        ->setEntityLabelInPlural('Products')

        // in addition to a string, the argument of the singular and plural label methods
        // can be a closure that defines two nullable arguments: entityInstance (which will
        // be null in 'index' and 'new' pages) and the current page name
        ->setEntityLabelInSingular(
            fn (?Product $product, ?string $pageName) => $product ? $product->toString() : 'Product'
        )
        ->setEntityLabelInPlural(function (?Category $category, ?string $pageName) {
            return 'edit' === $pageName ? $category->getLabel() : 'Categories';
        })

        // the Symfony Security permission needed to manage the entity
        // (none by default, so you can manage all instances of the entity)
        ->setEntityPermission('ROLE_EDITOR')


        /**
         Set title for type CRUD (new,page_details,page_edit, page_index)
         */
         // the visible title at the top of the page and the content of the <title> element
        // it can include these placeholders:
        //   %entity_name%, %entity_as_string%,
        //   %entity_id%, %entity_short_id%
        //   %entity_label_singular%, %entity_label_plural%
        ->setPageTitle('index', '%entity_label_plural% listing')

        // you can pass a PHP closure as the value of the title
        ->setPageTitle('new', fn () => new \DateTime('now') > new \DateTime('today 13:00') ? 'New dinner' : 'New lunch')

        // in DETAIL and EDIT pages, the closure receives the current entity
        // as the first argument
        ->setPageTitle('detail', fn (Product $product) => (string) $product)
        ->setPageTitle('edit', fn (Category $category) => sprintf('Editing <b>%s</b>', $category->getName()))

        // the help message displayed to end users (it can contain HTML tags)
        ->setHelp('edit', '...')

        /**
         Date time
         */

          // the argument must be either one of these strings: 'short', 'medium', 'long', 'full', 'none'
        // (the strings are also available as \EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField::FORMAT_* constants)
        // or a valid ICU Datetime Pattern (see https://unicode-org.github.io/icu/userguide/format_parse/datetime/)
        ->setDateFormat('...')
        ->setTimeFormat('...')

        // first argument = datetime pattern or date format; second optional argument = time format
        ->setDateTimeFormat('...', '...')

        ->setDateIntervalFormat('%%y Year(s) %%m Month(s) %%d Day(s)')
        ->setTimezone('...')

        // this option makes numeric values to be rendered with a sprintf()
        // call using this value as the first argument.
        // this option overrides any formatting option for all numeric values
        // (e.g. setNumDecimals(), setRoundingMode(), etc. are ignored)
        // NumberField and IntegerField can override this value with their
        // own setNumberFormat() methods, which works in the same way
        ->setNumberFormat('%.2d');

        /**
        Search, order, pagin    ation option
         */
           // the names of the Doctrine entity properties where the search is made on
        // (by default it looks for in all properties)
        ->setSearchFields(['name', 'description'])
        // use dots (e.g. 'seller.email') to search in Doctrine associations
        ->setSearchFields(['name', 'description', 'seller.email', 'seller.address.zipCode'])
        // set it to null to disable and hide the search box
        ->setSearchFields(null)
        // call this method to focus the search input automatically when loading the 'index' page
        ->setAutofocusSearch()

        // defines the initial sorting applied to the list of entities
        // (user can later change this sorting by clicking on the table columns)
        ->setDefaultSort(['id' => 'DESC'])
        ->setDefaultSort(['id' => 'DESC', 'title' => 'ASC', 'startsAt' => 'DESC'])
        // you can sort by Doctrine associations up to two levels
        ->setDefaultSort(['seller.name' => 'ASC'])

        // the max number of entities to display per page
        ->setPaginatorPageSize(30)
        // the number of pages to display on each side of the current page
        // e.g. if num pages = 35, current page = 7 and you set ->setPaginatorRangeSize(4)
        // the paginator displays: [Previous]  1 ... 3  4  5  6  [7]  8  9  10  11 ... 35  [Next]
        // set this number to 0 to display a simple "< Previous | Next >" pager
        ->setPaginatorRangeSize(4)

        // these are advanced options related to Doctrine Pagination
        // (see https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/tutorials/pagination.html)
        ->setPaginatorUseOutputWalkers(true)
        ->setPaginatorFetchJoinCollection(true)

        /**
        template and form option
        */
        // this method allows to use your own template to render a certain part
        // of the backend instead of using EasyAdmin default template
        // the first argument is the "template name", which is the same as the
        // Twig path but without the `@EasyAdmin/` prefix and the `.html.twig` suffix
        ->overrideTemplate('crud/field/id', 'admin/fields/my_id.html.twig')

        // the theme/themes to use when rendering the forms of this entity
        // (in addition to EasyAdmin default theme)
        ->addFormTheme('foo.html.twig')
        // this method overrides all existing form themes (including the
        // default EasyAdmin form theme)
        ->setFormThemes(['my_theme.html.twig', 'admin.html.twig'])

        // this sets the options of the entire form (later, you can set the options
        // of each form type via the methods of their associated fields)
        // pass a single array argument to apply the same options for the new and edit forms
        ->setFormOptions([
            'validation_groups' => ['Default', 'my_validation_group']
        ]);

        // pass two array arguments to apply different options for the new and edit forms
        // (pass an empty array argument if you want to apply no options to some form)
        ->setFormOptions(
            ['validation_groups' => ['my_validation_group']],
            ['validation_groups' => ['Default'], '...' => '...'],
        );

        ;
    }

    //Overide the order of the index page taht can work with detail, edit and new delete.
    createIndexQueryBuilder(){}

    // Overide Entity hook for custom them.
    /**
    createEntity(){} 
    updateEntity(){} 
    persistEntity(){} 
    deleteEntity(){} 
     */
    public function createEntity(string $entityFqcn)
                    {
                        $product = new Product();
                        $product->createdBy($this->getUser());

                        return $product;
                    }

    //Passer une variable dans un CRUD de type details
    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        if (Crud::PAGE_DETAIL === $responseParameters->get('pageName')) {
            $responseParameters->set('foo', '...');

            // keys support the "dot notation", so you can get/set nested
            // values separating their parts with a dot:
            $responseParameters->setIfNotSet('bar.foo', '...');
            // this is equivalent to: $parameters['bar']['foo'] = '...'
        }

        return $responseParameters;
    }

    //Faire une redirection apres un click sur page de details apres un click sur le boutton d'action ' 'saveviewdetails'
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
            {
                $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

                if ('saveAndViewDetail' === $submitButtonName) {
                    $url = $this->get(AdminUrlGenerator::class)
                        ->setAction(Action::DETAIL)
                        ->setEntityId($context->getEntity()->getPrimaryKeyValue())
                        ->generateUrl();

                    return $this->redirect($url);
                }

                return parent::getRedirectResponseAfterSave($context, $action);
            }
   

>>> DashboardAbstarctController.php
    // Config for all Crudcontroller, they will have a paginationn of 30.
    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(30)
        ;
    }

###### Gestion des Route administrateur depuis le client
/**
    Gestionn des routes admin depuis une variable global php/twig.
    you can use twig or php
 */
>>> AbstractController.php<<<
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\ProductCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SomeSymfonyController extends AbstractController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function someMethod()
    {
        // if your application only contains one Dashboard, it's enough
        // to define the controller related to this URL
        $url = $this->adminUrlGenerator
            ->setController(ProductCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        // in applications containing more than one Dashboard, you must also
        // define the Dashboard associated to the URL
        $url = $this->adminUrlGenerator
            ->setDashboard(DashboardController::class)
            ->setController(ProductCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        // some actions may require to pass additional parameters
        $url = $this->adminUrlGenerator
            ->setController(ProductCrudController::class)
            ->setAction(Action::EDIT)
            ->setEntityId($product->getId())
            ->generateUrl();

        // ...
    }
}

>>>twig <<<
{# if your application defines only one Dashboard #}
{% set url = ea_url()
    .setController('App\\Controller\\Admin\\ProductCrudController')
    .setAction('index') %}
{# if you prefer PHP constants, use this:
   .setAction(constant('EasyCorp\\Bundle\\EasyAdminBundle\\Config\\Action::INDEX')) #}

{# if your application defines multiple Dashboards #}
{% set url = ea_url()
    .setDashboard('App\\Controller\\Admin\\DashboardController')
    .setController('App\\Controller\\Admin\\ProductCrudController')
    .setAction('index') %}

{# some actions may require to pass additional parameters #}
{% set url = ea_url()
    .setController('App\\Controller\\Admin\\ProductCrudController')
    .setAction('edit')
    .setEntityId(product.id) %}

##### Field

###### Afficher et traiter un Field
/**
 Gestion des champs de formulaires de traitement de donné
 */
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

/**
Some hooks on field  for display on form created page, liste page and details page:
hideOnIndex(): hide on list
hideOnDetail() : hide on details page
hideOnForm() (hides the field both in edit and new pages)
hideWhenCreating()
hideWhenUpdating()
onlyOnIndex()
onlyOnDetail()
onlyOnForms() (hides the field in all pages except edit and new)
onlyWhenCreating()
onlyWhenUpdating()

 */

public function configureFields(string $pageName): iterable
{
    /**
    //Return with condition
     if (Crud::PAGE_INDEX === $pageName) {
        return [$id, $firstName, $lastName, $phone];
    } elseif(Crud::PAGE_DETAIL === $pageName) {
        return ['...'];
    } else {
        return ['...'];
    }
    //or

       if ('... some expression ...') {
        yield TextField::new('firstName');
        yield TextField::new('lastName');
    }

     */
    return [
        TextField::new('title'),
        TextEditorField::new('description'),
        MoneyField::new('price')->setCurrency('EUR'),
        IntegerField::new('stock'),
        DateTimeField::new('publishedAt'),
        IdField::new('id')->hideOnForm(),        
        TextField::new('phone'),
        EmailField::new('email')->hideOnIndex(),
        DateTimeField::new('createdAt')->onlyOnDetail(),

        //CSS Style
        TextField::new('firstName')->setColumns(6),

        //add breakpoint beetween fields
        FormField::addRow('xl'),

        //Add panel section
        FormField::addPanel('User Details')
            ->setIcon('phone')->addCssClass('optional')
            ->setHelp('Phone number is preferred')
            //Render collapse par défault
            //->renderCollapsed()
            ->collapsible(),

        // Tabs can also define their icon, CSS class and help message
        FormField::addTab('Contact information Tab')
            ->setIcon('phone')->addCssClass('optional')
            ->setHelp('Phone number is preferred'),

        //Custom Widget for a field admin like ckeditor or dropzone    
        TextField::new('lastName')
        // use this method if your field needs a specific form theme to render properly
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        // you can add more than one form theme using the same method
        ->addFormTheme('theme1.html.twig', 'theme2.html.twig', 'theme3.html.twig'),
        // CSS class/classes are applied to the field contents (in the 'index' page)
        // or to the row that wraps the contents (in the 'detail', 'edit' and 'new' pages)

        // use this method to add new classes to the ones applied by EasyAdmin
        ->addCssClass('text-large text-bold')
        // use this other method if you want to remove any CSS class added by EasyAdmin
        ->setCssClass('text-large text-bold')

        // this defines the Twig template used to render this field in 'index' and 'detail' pages
        // (this is not used in the 'edit'/'new' pages because they use Symfony Forms themes)
        ->setTemplatePath('admin/fields/my_template.html.twig')
        
        //Chargement du style.css
        TextField::new('firstName', 'Name')
        ->addCssFiles('bundle/some-bundle/foo.css', 'some-custom-styles.css')
        ->addJsFiles('admin/some-custom-code.js')
        ->addWebpackEncoreEntry('admin-maps')
        ->addHtmlContentToHead('<link rel="dns-prefetch" href="https://assets.example.com">')
        ->addHtmlContentToBody('<!-- generated at '.time().' -->')

        //Fonction de callback sur un champs
        IntegerField::new('stock', 'Stock')
        // callbacks usually take only the current value as argument
        ->formatValue(function ($value) {
            return $value < 10 ? sprintf('%d **LOW STOCK**', $value) : $value;
        });


    ];
}

###### Créer un field personnalisé (Mapfield)
namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class MapField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)

            // this template is used in 'index' and 'detail' pages
            ->setTemplatePath('admin/field/map.html.twig')

            // this is used in 'edit' and 'new' pages to edit the field contents
            // you can use your own form types too
            ->setFormType(TextareaType::class)
            ->addCssClass('field-map')

            // loads the CSS and JS assets associated to the given Webpack Encore entry
            // in any CRUD page (index/detail/edit/new). It's equivalent to calling
            // encore_entry_link_tags('...') and encore_entry_script_tags('...')
            ->addWebpackEncoreEntries('admin-field-map')

            // these methods allow to define the web assets loaded when the
            // field is displayed in any CRUD page (index/detail/edit/new)
            ->addCssFiles('js/admin/field-map.css')
            ->addJsFiles('js/admin/field-map.js')
        ;
    }
}

//Insérer le field dans le CRUDController

##### action (bouton d'action de formulaire)
/**
! alerte
 */
/**

Page Crud::PAGE_INDEX ('index'):

Added by default globally: Action::NEW
Added by default per entry: Action::EDIT, Action::DELETE
Other available actions per entry: Action::DETAIL
Page Crud::PAGE_DETAIL ('detail'):

Added by default: Action::EDIT, Action::DELETE, Action::INDEX
Other available actions: -
Page Crud::PAGE_EDIT ('edit'):

Added by default: Action::SAVE_AND_RETURN, Action::SAVE_AND_CONTINUE
Other available actions: Action::DELETE, Action::DETAIL, Action::INDEX
Page Crud::PAGE_NEW ('new'):

Added by default: Action::SAVE_AND_RETURN, Action::SAVE_AND_ADD_ANOTHER
Other available actions: Action::SAVE_AND_CONTINUE, Action::INDEX

 */

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

    public function configureActions(Actions $actions): Actions
    {
         return $actions

         //Ajouter une action au CRUD
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)

        //Désactivé une action
        ->disable(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)

        // Mettre a jour l'action durant le processus
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
            return $action->setIcon('fa fa-file-alt')->setLabel(false);
        })

        // Supprimer si le Role est super admin
        ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
    }

##### Evènement sur une actionn ORM .
/**
! alerte
 */
>>> src/EventSubscriber/EasyAdminSubscriber.php
/**

Events related to Doctrine entities:
    AfterEntityBuiltEvent
    AfterEntityDeletedEvent
    AfterEntityPersistedEvent
    AfterEntityUpdatedEvent
    BeforeEntityDeletedEvent
    BeforeEntityPersistedEvent
    BeforeEntityUpdatedEvent

Events related to resource admins:
    AfterCrudActionEvent
    BeforeCrudActionEvent

 */

namespace App\EventSubscriber;

use App\Entity\BlogPost;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;

    public function __construct($slugger)
    {
        $this->slugger = $slugger;
    }


    public function setBlogPostSlug(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof BlogPost)) {
            return;
        }

        $slug = $this->slugger->slugify($entity->getTitle());
        $entity->setSlug($slug);
    }
}

# All bundle

CMFRoutingBundle
Symfony bundle to provide the CMF chain router to handle multiple routers, and the dynamic router to load routes from a database or other sources

DoctrineBundle
Symfony Bundle for Doctrine ORM and DBAL

DoctrineFixturesBundle
Symfony integration for the doctrine/data-fixtures library

DoctrineMigrationsBundle
Symfony integration for the doctrine/migrations library

EasyAdminBundle
EasyAdmin is a fast, beautiful and modern admin generator for Symfony applications

FOSCKEditorBundle
Provides a CKEditor integration for your Symfony project

KnpMenuBundle
Object Oriented menus for your Symfony project

LexikJWTAuthenticationBundle
JWT authentication for your Symfony API

LiipImagineBundle
Symfony Bundle to assist in imagine manipulation using the imagine library

NelmioApiDocBundle
Generates documentation for your REST API from annotations

SchebTwoFactorBundle
Two-factor authentication for Symfony applications 🔐

SensioFrameworkExtraBundle
An extension to Symfony FrameworkBundle that adds annotation configuration for Controller classes

SonataAdminBundle
The missing Symfony Admin Generator

StofDoctrineExtensionsBundle
Integration bundle for DoctrineExtensions by l3pp4rd in Symfony

Symfony UX Autocomplete
Javascript-powered auto-completion functionality for your Symfony forms!

Symfony UX Chart.js
Chart.js integration for Symfony

Symfony UX Cropper.js
Cropper.js integration for Symfony

Symfony UX Dropzone
File input dropzones for Symfony Forms

Symfony UX LazyImage
Lazy image loader and utilities for Symfony

Symfony UX Live Components
Dynamic UI's with Twig and zero JavaScript

Symfony UX Notify
Symfony bundle integrating server-sent native notifications

Symfony UX React
Integrates React into Symfony applications

Symfony UX Swup
Swup integration for Symfony

Symfony UX Turbo
Hotwire Turbo integration for Symfony

Symfony UX Twig Components
Create reusable Twig components by combining a template + PHP class

Symfony UX Typed
Symfony bundle integrating Typed

Symfony UX Vue.js
Vue integration with Symfony UX

SymfonyMakerBundle
Symfony Maker Bundle

ZenstruckFoundryBundle
A model factory library for creating expressive, auto-completable, on-demand dev/test

# Alternative
- lien vers un media existant
   <a href="{{ asset('uploads/brochures/' ~ product.brochureFilename) }}">View brochure (PDF)</a>
- Exeption
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );