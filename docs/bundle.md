# Methode
## Projets
Voulez vous faire une application Symfony ou un CMS SYmfony?
- CMS Symfony (Système de gestion de contenu) basé sur le Sonatapagebundle avec une gestion de templates format grid aera personnalisé et du SEO.
- Application symfony utilisant les bundles externes sans pagebundle pour un maximun d'efficacité (voir les bundles ci-dessous) avec  CMFRoutingBundle pour la gestion des routes.

## Astuce
lancer chaque bundle symfony par un test php pour tester le fonctionnement de l'application.

## Définir une Enité
| nom | type | contrainte | ux
-------------------------------
## Question
    - il y a t'il des champs reelationnel
    - il y a t'il des champs date
    - il y a t'il de media (MediaBundle)
    - il y a t il un administration (Sonata/EasyAdmin)
    - il y a t'il des animation, libraries de design a désactivé.

## Administration
Page:
    preview
    edit
    exportation
    Action sur entité
    element enfant
    page de recherche
    type de champs
    Renommer, désactivé et gérer les routes.
    Question?
    il y a t'il des actions de filtrage sur entité pour page list
    il y a til un menu workflow
    Doit on sauvegarder les filtres utilisateurs
    il y a til des performance dans l'application
    Doit on utilisé ckeditor Formatter (bundle sonataFormatter) ou ckeditor simple.

## Aide et service
https://aws.amazon.com/fr/
https://app.slack.com/client/T39U3FUKV/C3GC7MKM5
https://app.slack.com/client/T39U3FUKV/C3EQ7S3MJ/thread/C3EQ7S3MJ-1671782813.278209
https://github.com/symfony/demo/tree/pr/1284

## Définir les roles
    - page visible
    - action permis
    - Matrix de roles

## Définr les pages
    - bundle page/ SonataPageBundle
    -   seo

# Verifier si la documentation correspond a Symfony 6
### Base
Installer la bonne version php.
symfony new my_project_directory --version="6.2.*@dev" --webapp
or
composer create-project symfony/skeleton:"6.2.*@dev" my_project_directory
cd my_project_directory
composer require webapp

composer create-project symfony/skeleton project_name --full
Symfony new project_name --full

and 
composer require module_name --with-all-dependencies

ou
composer update

### Hasher un mot de passe
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
public function(UserPasswordHasherInterface $hasher)
$user = new User();
$user->setUsername('admin');
$password = $this->hasher->hashPassword($user, 'pass_1234');
$user->setPassword($password);

>>> config/packages/security.yaml
security:
    # ...
    password_hashers:
        # Use native password hasher, which auto-selects and migrates the best
        # possible hashing algorithm (which currently is "bcrypt")
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'

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
 s'assurer que les parefeu soit définie:
 
#### bundle security
composer require symfony/security-bundle

##### Formulaire d'authentification 
- authentification a  une interface admin
//Entité d'authentification
php bin/console make:user
//Configuration du Formulaire et de security.yml
php bin/console make:auth
//Formulaire d'enregistrement
php bin/console make:registration-form
>>> config/packages/security.yaml
security:
    # ...

    firewalls:
        main:
            # Autorisation au utilisateur anonyme
            anonymous: true
            # Gestion des routes de connections
            form_login:
                # "app_login" is the name of the route  created for admin 
                login_path: app_login
                check_path: app_login
                enable_csrf: true
            logout:
                path: app_logout
        # firewal for my admin
        admin:
            lazy: true
            pattern: /admin(.*)
            provider: sonata_user_bundle
            context: user
            form_login:
                login_path: app_register
                check_path: sonata_user_admin_security_check
                default_target_path: sonata_admin_dashboard
            logout:
                path: sonata_user_admin_security_logout
                target: sonata_user_admin_security_login
            remember_me:
                secret: '%env(APP_SECRET)%'
                lifetime: 2629746
                path: /admin
            entry_point: App\Security\UserSonataAuthenticator
            custom_authenticator: App\Security\UserSonataAuthenticator

            # activate different ways to authenticate
            # https://symfony.com/doc/current/security.html#the-firewall

            # https://symfony.com/doc/current/security/impersonating_user.html
            # switch_user: true

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
# -------- Application Symfony --------#
- Front -office (webpack)
- Back-office (Sonata ou EasyAdmin ou Session)

# Front office

### webpack

#### Installer webpack
composer require symfony/webpack-encore-bundle
npm install --save-dev @fortawesome/fontawesome-free

composer require components/jquery
composer require components/font-awesome
composer require twbs/bootstrap

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
use Symfony\Component\HttpFoundation\Request;

   public function contact(Request $request){

        $defaultData = ['message' => 'Type your message here'];
        //Don't forget that $form =  $formbuilder->add(field)->getForm();
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
>>>twig

{{ form(form) }}

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
>>>config/packages/twig
    form_themes:['bootstrap_5_layout.html.twig']

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


### CKeditor & SonataFormatterBundle & Mediabundle
https://docs.sonata-project.org/projects/SonataMediaBundle/en/5.x/reference/installation/
https://docs.sonata-project.org/projects/SonataFormatterBundle/en/5.x/reference/ckeditor_medias/

#### **CKeditor**
##### Context
CKEditor pour symfony ou webpack
- CKEditor Sonata, easyAdmin, front-office
avec un chargement en javascript ou sans,
configuration de la barre de navigation.

##### Configurer CKEDITOR
- Ivory ckeditorbundle was abondonned

###### 1-Installation de ckeditor symfony
composer require friendsofsymfony/ckeditor-bundle
php bin/console ckeditor:install
php bin/console assets:install public

---instalation de ckeditor avec release -> full, standar, custom et basic
php bin/console ckeditor:install --release=basic

--- ne pas afficher la barre de progression 
php bin/console ckeditor:install --no-progress-bar
>>>> composer.json

        "auto-scripts": {
            "cache:clear": "symfony-cmd",
            "ckeditor:install --clear=drop": "symfony-cmd",
            "assets:install --symlink --relative %PUBLIC_DIR%": "symfony-cmd"
            }

###### 2-Installation de ckeditor sur Webpack
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

#####  utiliser ckeditor dans un formulaire avec un champs textaera
use FOS\CKEditorBundle\Form\Type\CKEditorType;

$builder->add('field', CKEditorType::class, array(
    'config' => array(
        'uiColor' => '#ffffff',
        //...
    ),
));

##### Afficher le formulaire dynamique ckeditor
>>> config/ckeditor.yaml
    autoload: false
    async: true

>>> twig
{{ form_javascript(form) }}


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

#### **SonataFormatterBundle**
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

### image avec EasyAdmin
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



### fixtures
https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html#writing-fixtures

composer require --dev orm-fixtures
//composer require doctrine/doctrine-fixtures-bundle
php bin/console make:fixtures
php bin/console doctrine:fixtures:load

#### Context
Faire des données pour le developpement.
CE sont des instance que l'ont pour des entity.
Possibilité d'intégrer des services externes.

#### Mettre a jour le path des fixures
>>> config/services.php
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return function(ContainerConfigurator $container) : void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure();
    //Nouveau chemin : "fixtures"
    $services->load('DataFixtures\\', '../fixtures');
};

>>> Composer.json
"autoload-dev": {
    "psr-4": {
        "...": "...",
        //Nouveau chemin : "fixtures"
        "DataFixtures\\": "fixtures"
    }
}

#### Faire le script pour l'entité spécifique product
>>>> fixure.php (class AppFixtures extends Fixture)
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

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

>>console
php bin/console doctrine:fixtures:load
// pour vider les table et repartir de zéro
php bin/console doctrine:fixtures:load --append

#### Exécuter une fixure spécifique de class UserFixtures
php bin/console doctrine:fixtures:load --group=UserFixtures


#### En cas de multiple fichier de fixure : créer le lien entre les fixures
>>>Fixture.php(1) contenu
    public const ADMIN_USER_REFERENCE = 'admin-user';

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User('admin', 'pass_1234');
        $manager->persist($userAdmin);
        $manager->flush();

        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
    }

>>>Fixture.php(2)  implements DependentFixtureInterface 

use App\DataFixtures\Fixture.php(1);
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

    public function load(ObjectManager $manager)
    {
        $userGroup = new Group('administrators');
        // this reference returns the User object created in UserFixtures
        $userGroup->addUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));

        $manager->persist($userGroup);
        $manager->flush();
    }

    //Exécuter les fixures dans l'ordre en listant les dépendance
  public function getDependencies()
    {
        return [
            //Class fixures a éxécuté avant notre class.
            Fixture.php(2)::class,
        ];
    }

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


#### utiliser des fixures par group /indépendant
//Insérer FixtureGroupInterface
>>> fixure.php implements FixtureGroupInterface
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
  public static function getGroups(): array
     {
         return ['group1', 'group2'];
     }

>>> console
php bin/console doctrine:fixtures:load --group=ClassNameFixure
or
php bin/console doctrine:fixtures:load --group=group1
//Multiple group
php bin/console doctrine:fixtures:load --group=group1 --group=group2

#### Purger une base de données ********
//customize purging behavior significantly 
>>> src/Purger/CustomPurger.php
namespace App\Purger;

use Doctrine\Common\DataFixtures\Purger\PurgerInterface;

// ...
class CustomPurger implements PurgerInterface
{
    public function purge() : void
    {
        // ...
    }
}

>>> src/Purger/CustomPurgerFactory.php
namespace App\Purger;
// ...
use Doctrine\Bundle\FixturesBundle\Purger\PurgerFactory;

class CustomPurgerFactory implements PurgerFactory
{
    public function createForEntityManager(?string $emName, EntityManagerInterface $em, array $excluded = [], bool $purgeWithTruncate = false) : PurgerInterface
    {
        return new CustomPurger($em);
    }
}
>>>config/services.yaml
services:
    App\Purger\CustomPurgerFactory:
        tags:
            - { name: 'doctrine.fixtures.purger_factory', alias: 'my_purger' }

>>>console
php bin/console doctrine:fixtures:load --purger=my_purger --purge-exclusions
//--purger Vider les tables
//--purge-exclusions exclude Table to be purge
//--purge-with-truncate Tronquer la table


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

## MakerBundle
https://github.com/symfony/maker-bundle/tree/main/src/Maker
- Faire sa propre ligne de commande php bin/console maker:Mymakerbun
- Faire un namespace personnalisé

composer require --dev symfony/maker-bundle
### Créer un name space personallisé remplacant App\
>>> config/packages/dev/maker.yaml
    # create this file if you need to configure anything
maker:
    # tell MakerBundle that all of your classes live in an
    # Acme namespace, instead of the default App
    # (e.g. Acme\Entity\Article, Acme\Command\MyCommand, etc)
    root_namespace: 'Acme'

### Créer son bundle (ligne de commande)******
// (voir)https://github.com/symfony/maker-bundle/tree/main/src/Maker
>>>src/Maker/ extends AbstractMaker.
final class MakeUser extends AbstractMaker
{
    // Ajouter les hooks
 }   

>>>config/services.yml
services:
    app.menu_builder:
        class: App\Maker\MyMaker
        tags:
            - { name: maker.command} 
 


## CMFRoutingBundle (Dangereux et abondonné) ****************
Symfony bundle to provide the CMF chain router to handle multiple routers, and the dynamic router to load routes from a database or other sources

## Context
Fournit deux routes pour symfony: les routes dynamique stocké dans les base de données et les routes compilé par Symfony

## Tour rapide


## DoctrineBundle******

### context:
- gestion de la connection de multiple base de données (dbal).
- gestion des entity orm managers
- gestion de oracle
- Definition d'un ID d'entité personnalisé ou existant

### Configuration du serveur et de la connection
https://symfony.com/bundles/DoctrineBundle/current/configuration.html

#### full configuration
doctrine:
    dbal:
        default_connection:           default

        # A collection of custom types
        types:
            # example
            some_custom_type:
                class:                Acme\HelloBundle\MyCustomType

        connections:
            # A collection of different named connections (e.g. default, conn2, etc)
            default:
                dbname:               ~
                host:                 localhost
                port:                 ~
                user:                 root
                password:             ~

                # RDBMS specific; Refer to the manual of your RDBMS for more information
                charset:              ~

                dbname_suffix:        ~

                # SQLite specific
                path:                 ~

                # SQLite specific
                memory:               ~

                # MySQL specific. The unix socket to use for MySQL
                unix_socket:          ~

                # IBM DB2 specific. True to use as persistent connection for the ibm_db2 driver
                persistent:           ~

                # IBM DB2 specific. The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
                protocol:             ~

                # Oracle specific. True to use SERVICE_NAME as connection parameter instead of SID for Oracle
                service:              ~

                # Oracle specific. Overrules dbname parameter if given and used as SERVICE_NAME or SID connection
                # parameter for Oracle depending on the service parameter.
                servicename:          ~

                # oci8 driver specific. The session mode to use for the oci8 driver.
                sessionMode:          ~

                # SQL Anywhere specific (ServerName). The name of a running database server to connect to for SQL Anywhere.
                server:               ~

                # PostgreSQL specific (default_dbname).
                # Override the default database (postgres) to connect to.
                default_dbname:       ~

                # PostgreSQL specific (LIBPQ-CONNECT-SSLMODE).
                # Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
                sslmode:              ~

                # PostgreSQL specific (LIBPQ-CONNECT-SSLROOTCERT).
                # The name of a file containing SSL certificate authority (CA) certificate(s).
                # If the file exists, the server's certificate will be verified to be signed by one of these authorities.
                sslrootcert:          ~

                # PostgreSQL specific (LIBPQ-CONNECT-SSLCERT).
                # The name of a file containing the client SSL certificate.
                sslcert:              ~

                # PostgreSQL specific (LIBPQ-CONNECT-SSLKEY).
                # The name of a file containing the private key for the client SSL certificate.
                sslkey:               ~

                # PostgreSQL specific (LIBPQ-CONNECT-SSLCRL).
                # The name of a file containing the SSL certificate revocation list (CRL).
                sslcrl:               ~

                # Oracle specific (SERVER=POOLED). True to use a pooled server with the oci8/pdo_oracle driver
                pooled:               ~

                # pdo_sqlsrv driver specific. Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
                MultipleActiveResultSets:  ~

                # Enable savepoints for nested transactions
                use_savepoints: true

                driver:               pdo_mysql
                platform_service:     ~
                auto_commit:          ~

                # If set to "/^sf2_/" all tables, and any named objects such as sequences
                # not prefixed with "sf2_" will be ignored by the schema tool.
                # This is for custom tables which should not be altered automatically.
                schema_filter:        ~

                # When true, queries are logged to a "doctrine" monolog channel
                logging:              "%kernel.debug%"

                profiling:            "%kernel.debug%"
                # When true, profiling also collects a backtrace for each query
                profiling_collect_backtrace: false
                # When true, profiling also collects schema errors for each query
                profiling_collect_schema_errors: true

                server_version:       ~
                driver_class:         ~
                # Allows to specify a custom wrapper implementation to use.
                # Must be a subclass of Doctrine\DBAL\Connection
                wrapper_class:        ~
                shard_choser:         ~
                shard_choser_service: ~
                keep_replica:           ~

                # An array of options
                options:
                    # example
                    # key:                  value

                # An array of mapping types
                mapping_types:
                    # example
                    # enum:                 string

                default_table_options:
                    # Affects schema-tool. If absent, DBAL chooses defaults
                    # based on the platform. Examples here are for MySQL.
                    # charset:      utf8mb4
                    # collate:      utf8mb4_unicode_ci # When using doctrine/dbal 2.x
                    # collation:    utf8mb4_unicode_ci # When using doctrine/dbal 3.x
                    # engine:       InnoDB

                replicas:
                    # A collection of named replica connections (e.g. replica1, replica2)
                    replica1:
                        dbname:               ~
                        host:                 localhost
                        port:                 ~
                        user:                 root
                        password:             ~
                        charset:              ~
                        dbname_suffix:        ~
                        path:                 ~
                        memory:               ~

                        # MySQL specific. The unix socket to use for MySQL
                        unix_socket:          ~

                        # IBM DB2 specific. True to use as persistent connection for the ibm_db2 driver
                        persistent:           ~

                        # IBM DB2 specific. The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
                        protocol:             ~

                        # Oracle specific. True to use SERVICE_NAME as connection parameter instead of SID for Oracle
                        service:              ~

                        # Oracle specific. Overrules dbname parameter if given and used as SERVICE_NAME or SID connection
                        # parameter for Oracle depending on the service parameter.
                        servicename:          ~

                        # oci8 driver specific. The session mode to use for the oci8 driver.
                        sessionMode:          ~

                        # SQL Anywhere specific (ServerName). The name of a running database server to connect to for SQL Anywhere.
                        server:               ~

                        # PostgreSQL specific (default_dbname).
                        # Override the default database (postgres) to connect to.
                        default_dbname:       ~

                        # PostgreSQL specific (LIBPQ-CONNECT-SSLMODE).
                        # Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
                        sslmode:              ~

                        # PostgreSQL specific (LIBPQ-CONNECT-SSLROOTCERT).
                        # The name of a file containing SSL certificate authority (CA) certificate(s).
                        # If the file exists, the server's certificate will be verified to be signed by one of these authorities.
                        sslrootcert:          ~

                        # PostgreSQL specific (LIBPQ-CONNECT-SSLCERT).
                        # The name of a file containing the client SSL certificate.
                        sslcert:              ~

                        # PostgreSQL specific (LIBPQ-CONNECT-SSLKEY).
                        # The name of a file containing the private key for the client SSL certificate.
                        sslkey:               ~

                        # PostgreSQL specific (LIBPQ-CONNECT-SSLCRL).
                        # The name of a file containing the SSL certificate revocation list (CRL).
                        sslcrl:               ~

                        # Oracle specific (SERVER=POOLED). True to use a pooled server with the oci8/pdo_oracle driver
                        pooled:               ~

                        # pdo_sqlsrv driver specific. Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
                        MultipleActiveResultSets:  ~

                shards:
                    id:                   ~ # Required
                    dbname:               ~
                    host:                 localhost
                    port:                 ~
                    user:                 root
                    password:             ~
                    charset:              ~
                    path:                 ~
                    memory:               ~

                    # MySQL specific. The unix socket to use for MySQL
                    unix_socket:          ~

                    # IBM DB2 specific. True to use as persistent connection for the ibm_db2 driver
                    persistent:           ~

                    # IBM DB2 specific. The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
                    protocol:             ~

                    # Oracle specific. True to use SERVICE_NAME as connection parameter instead of SID for Oracle
                    service:              ~

                    # Oracle specific. Overrules dbname parameter if given and used as SERVICE_NAME or SID connection
                    # parameter for Oracle depending on the service parameter.
                    servicename:          ~

                    # oci8 driver specific. The session mode to use for the oci8 driver.
                    sessionMode:          ~

                    # SQL Anywhere specific (ServerName). The name of a running database server to connect to for SQL Anywhere.
                    server:               ~

                    # PostgreSQL specific (default_dbname).
                    # Override the default database (postgres) to connect to.
                    default_dbname:       ~

                    # PostgreSQL specific (LIBPQ-CONNECT-SSLMODE).
                    # Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
                    sslmode:              ~

                    # PostgreSQL specific (LIBPQ-CONNECT-SSLROOTCERT).
                    # The name of a file containing SSL certificate authority (CA) certificate(s).
                    # If the file exists, the server's certificate will be verified to be signed by one of these authorities.
                    sslrootcert:          ~

                    # PostgreSQL specific (LIBPQ-CONNECT-SSLCERT).
                    # The name of a file containing the client SSL certificate.
                    sslcert:              ~

                    # PostgreSQL specific (LIBPQ-CONNECT-SSLKEY).
                    # The name of a file containing the private key for the client SSL certificate.
                    sslkey:               ~

                    # PostgreSQL specific (LIBPQ-CONNECT-SSLCRL).
                    # The name of a file containing the SSL certificate revocation list (CRL).
                    sslcrl:               ~

                    # Oracle specific (SERVER=POOLED). True to use a pooled server with the oci8/pdo_oracle driver
                    pooled:               ~

                    # pdo_sqlsrv driver specific. Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
                    MultipleActiveResultSets:  ~

    orm:
        default_entity_manager: ~ # The first defined is used if not set

        # Auto generate mode possible values are: "NEVER", "ALWAYS", "FILE_NOT_EXISTS", "EVAL", "FILE_NOT_EXISTS_OR_CHANGED"
        auto_generate_proxy_classes:  false
        proxy_dir:                    "%kernel.cache_dir%/doctrine/orm/Proxies"
        proxy_namespace:              Proxies

        entity_managers:

            # A collection of different named entity managers (e.g. some_em, another_em)
            default:
                connection: default
                naming_strategy: doctrine.orm.naming_strategy.underscore_number_aware
                auto_mapping: true
                mappings:
                    App:
                        is_bundle: false
                        dir: '%kernel.project_dir%/src/Entity'
                        prefix: 'App\Entity'
                        alias: App
            some_em:
                query_cache_driver:
                    type: ~
                    id:   ~
                    pool: ~
                metadata_cache_driver:
                    type: ~
                    id:   ~
                    pool: ~
                result_cache_driver:
                    type: ~
                    id:   ~
                    pool: ~
                entity_listeners:
                    entities:

                        # example
                        Acme\HelloBundle\Entity\Author:
                            listeners:

                                # example
                                Acme\HelloBundle\EventListener\ExampleListener:
                                    events:
                                        type:                 preUpdate
                                        method:               preUpdate

                # The name of a DBAL connection (the one marked as default is used if not set)
                connection:           ~
                class_metadata_factory_name:  Doctrine\ORM\Mapping\ClassMetadataFactory
                default_repository_class:     Doctrine\ORM\EntityRepository
                auto_mapping:                 false
                naming_strategy:              doctrine.orm.naming_strategy.default
                quote_strategy:               doctrine.orm.quote_strategy.default
                entity_listener_resolver:     ~
                repository_factory:           ~
                second_level_cache:
                    region_cache_driver:
                        type: ~
                        id:   ~
                        pool: ~
                    region_lock_lifetime: 60
                    log_enabled:          true
                    region_lifetime:      0
                    enabled:              true
                    factory:              ~
                    regions:

                        # Prototype
                        name:
                            cache_driver:
                                type: ~
                                id:   ~
                                pool: ~
                            lock_path:            '%kernel.cache_dir%/doctrine/orm/slc/filelock'
                            lock_lifetime:        60
                            type:                 default
                            lifetime:             0
                            service:              ~
                            name:                 ~
                    loggers:

                        # Prototype
                        name:
                            name:                 ~
                            service:              ~

                # An array of hydrator names
                hydrators:

                    # example
                    ListHydrator: Acme\HelloBundle\Hydrators\ListHydrator

                mappings:
                    # An array of mappings, which may be a bundle name or something else
                    mapping_name:
                        mapping:              true
                        type:                 ~
                        dir:                  ~
                        alias:                ~
                        prefix:               ~
                        is_bundle:            ~

                dql:
                    # A collection of string functions
                    string_functions:

                        # example
                        # test_string: Acme\HelloBundle\DQL\StringFunction

                    # A collection of numeric functions
                    numeric_functions:

                        # example
                        # test_numeric: Acme\HelloBundle\DQL\NumericFunction

                    # A collection of datetime functions
                    datetime_functions:

                        # example
                        # test_datetime: Acme\HelloBundle\DQL\DatetimeFunction

                # Register SQL Filters in the entity manager
                filters:

                    # An array of filters
                    some_filter:
                        class:                Acme\HelloBundle\Filter\SomeFilter # Required
                        enabled:              false

                        # An array of parameters
                        parameters:

                            # example
                            foo_param:              bar_value

                schema_ignore_classes:
                    - Acme\AppBundle\Entity\Order
                    - Acme\AppBundle\Entity\PhoneNumber

        # Search for the "ResolveTargetEntityListener" class for a cookbook about this
        resolve_target_entities:

            # Prototype
            Acme\InvoiceBundle\Model\InvoiceSubjectInterface: Acme\AppBundle\Entity\Customer

#### orm

##### Example of doctrine orm
doctrine:
    orm:
        auto_mapping: true
        # the standard distribution overrides this to be true in debug, false otherwise
        auto_generate_proxy_classes: false
        proxy_namespace: Proxies
        proxy_dir: "%kernel.cache_dir%/doctrine/orm/Proxies"
        default_entity_manager: default
        metadata_cache_driver: ~
        query_cache_driver: ~
        result_cache_driver: ~

##### use multiple EntityManager
use Doctrine\ORM\EntityManagerInterface;
    //use a entity MAnager call purchase_logs 
     public function __construct(EntityManagerInterface $purchaseLogsEntityManager)
    {
        $this->entityManager = $purchaseLogsEntityManager;
    }

##### Use cache pool with doctrine *******
doctrine:
    orm:
        auto_mapping: true
        # With no cache set, this defaults to a sane 'pool' configuration
        metadata_cache_driver: ~
        # the 'pool' type requires to define the 'pool' option and configure a cache pool using the FrameworkBundle
        result_cache_driver:
            type: pool
            pool: doctrine.result_cache_pool
        # the 'service' type requires to define the 'id' option too
        query_cache_driver:
            type: service
            id: App\ORM\MyCacheService

framework:
    cache:
        pools:
            doctrine.result_cache_pool:
                adapter: cache.app

##### filter*******
https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/filters.html
doctrine:
    orm:
        filters:
            myFilter:
                class: MyVendor\MyBundle\Filters\MyFilter
                enabled: true
                parameters:
                    myParameter: myValue
                    mySecondParameter: mySecondValue

#### dbal
https://www.doctrine-project.org/projects/doctrine-dbal/en/2.10/index.html
##### global
doctrine:
    dbal:
        url:                      mysql://user:secret@localhost:1234/otherdatabase # this would override the values below
        dbname:                   database
        host:                     localhost
        port:                     1234
        user:                     user
        password:                 secret
        dbname_suffix:            _test
        driver:                   pdo_mysql
        driver_class:             MyNamespace\MyDriverImpl
        options:
            foo: bar
        path:                     "%kernel.project_dir%/var/data.db" # SQLite specific
        memory:                   true                               # SQLite specific
        unix_socket:              /tmp/mysql.sock
        persistent:               true
        MultipleActiveResultSets: true                # pdo_sqlsrv driver specific
        pooled:                   true                # Oracle specific (SERVER=POOLED)
        protocol:                 TCPIP               # IBM DB2 specific (PROTOCOL)
        server:                   my_database_server  # SQL Anywhere specific (ServerName)
        service:                  true                # Oracle specific (SERVICE_NAME instead of SID)
        servicename:              MyOracleServiceName # Oracle specific (SERVICE_NAME)
        sessionMode:              2                   # oci8 driver specific (session_mode)
        default_dbname:           database            # PostgreSQL specific (default_dbname)
        sslmode:                  require             # PostgreSQL specific (LIBPQ-CONNECT-SSLMODE)
        sslrootcert:              postgresql-ca.pem   # PostgreSQL specific (LIBPQ-CONNECT-SSLROOTCERT)
        sslcert:                  postgresql-cert.pem # PostgreSQL specific (LIBPQ-CONNECT-SSLCERT)
        sslkey:                   postgresql-key.pem  # PostgreSQL specific (LIBPQ-CONNECT-SSLKEY)
        sslcrl:                   postgresql.crl      # PostgreSQL specific (LIBPQ-CONNECT-SSLCRL)
        wrapper_class:            MyDoctrineDbalConnectionWrapper
        charset:                  UTF8
        logging:                  "%kernel.debug%"
        platform_service:         MyOwnDatabasePlatformService
        auto_commit:              false
        schema_filter:            ^sf2_
        mapping_types:
            enum: string
        types:
            custom: Acme\HelloBundle\MyCustomType
        default_table_options:
            # Affects schema-tool. If absent, DBAL chooses defaults
            # based on the platform.
            charset:              utf8
            collate:              utf8_unicode_ci
            engine:               InnoDB

##### connection mutiple
doctrine:
    dbal:
        default_connection:       default #Toujours vraie par défault
        connections:
            default:                        # doctrine.dbal.default_connection this is the tag you create
                dbname:           Symfony2
                user:             root
                password:         null
                host:             localhost
            customer:                        # doctrine.dbal.customer_connection this is the tag you create
                dbname:           customer
                user:             root
                password:         null
                host:             localhost

###### Utiliser une connection php
use Doctrine\DBAL\Connection;
//this args represent the Connection  withname purchase_logs
// '_' est remplacer par une Majuscule, et le nom est concaténé a Connection. 
public function __construct(Connection $purchaseLogsConnection)
    {
        $this->connection = $purchaseLogsConnection;
    }

//Avec ma connection 'customer'.
public function __construct(Connection $CustomerConnection)
    {
        $this->connection = $CustomerConnection;
    }

### type d' Identifiant unique
#### doctrine.uuid_generator 

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @Id
     * @Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator("doctrine.uuid_generator")
     */
    private $id;

}
#### doctrine.ulid_generator  
/**
 * @ORM\Entity
 */
class User
{
    /**
     * @Id
     * @Column(type="ulid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator("doctrine.ulid_generator  ")
     */
    private $id;

}

### Identifiant personalisé
>>>Doctrine\ORM\Id\AbstractIdGenerator
class Myidentifier extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity) 
                {

                }
}

### Configuration de Oracle DB
/**
If the environment format configured in oracle does not meet doctrine requirements, you need to use the OracleSessionInit listener so that doctrine is aware of the format used by Oracle DB.

 */
services:
    oracle.listener:
        class: Doctrine\DBAL\Event\Listeners\OracleSessionInit
        tags:
            - { name: doctrine.event_listener, event: postConnect }

/**
    NLS_TIME_FORMAT="HH24:MI:SS"
    NLS_DATE_FORMAT="YYYY-MM-DD HH24:MI:SS"
    NLS_TIMESTAMP_FORMAT="YYYY-MM-DD HH24:MI:SS"
    NLS_TIMESTAMP_TZ_FORMAT="YYYY-MM-DD HH24:MI:SS TZH:TZM"

 */

## DoctrineMigrationsBundle
Symfony integration for the doctrine/migrations library



##  LexikJWTAuthenticationBundle
JWT authentication for your Symfony API

##  LiipImagineBundle
Symfony Bundle to assist in imagine manipulation using the imagine library

## NelmioApiDocBundle
Generates documentation for your REST API from annotations

##  SchebTwoFactorBundle
Two-factor authentication for Symfony applications 


## StofDoctrineExtensionsBundle
Integration bundle for DoctrineExtensions by l3pp4rd in Symfony

## Doctrine MongoDB

Symfony UX Autocomplete
Javascript-powered auto-completion functionality for your Symfony forms!


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

## ZenstruckFoundryBundle
A model factory library for creating expressive, auto-completable, on-demand dev/test

# Alternative
- lien vers un media existant
   <a href="{{ asset('uploads/brochures/' ~ product.brochureFilename) }}">View brochure (PDF)</a>
- Exeption
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
- orm: php bin/console doctrine:migrations:generate
- Relationship function, choose my own side
    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

# Menu avec KNP bundle ***
 composer require knplabs/knp-menu-bundle

## Context
C'est un menu avec la library KNP. Ce menu peut etre un service sonataAdmin ,
un menu créé avec un knp menu provider(menu complex intégrant une logique basé sur des group) ou une route d'un controller personnalisé.
- on peut configurer un menu dans le twig a partir d un menu existant et y appliqué une logique avec injection
Elargir le menu conditionelement par des events
Menu->Event->EventListener -> Service->Modification du menu

## knp_menu configuration knp_menu.yaml
>>>config/packages/knp_menu.yaml
knp_menu:
    # use "twig: false" to disable the Twig extension and the TwigRenderer
    twig:
        template: KnpMenuBundle::menu.html.twig
    #  if true, enables the helper for PHP templates
    templating: false
    # the renderer to use, list is also available by default
    default_renderer: twig

## Route avec controller
//Ajout de la route du controller comme un item.
>>> config/packages/sonata_admin.yaml
sonata_admin:
    # overide the template use by knp_menu
    templates:
        knp_menu_template: '@ApplicationAdmin/Menu/custom_knp_menu.html.twig'
    dashboard:
        groups:
            news:
                label:                ~
                translation_domain:   ~
                # My menu (route and controller)
                items:
                    - sonata.news.admin.post #le service admin post
                    - route:        blog_home
                      label:        Blog
                      roles:        ['ROLE_FOO', 'ROLE_BAR']
                    - route:        blog_article
                      route_params: { articleId: 3 }
                      label:        Article
                      roles: ['ROLE_ADMIN', 'ROLE_SONATA_ADMIN']
>>>Controller/
use Symfony\Component\HttpFoundation\Response;

final class BlogController
{
    /**
     * @Route("/blog", name="blog_home")
     */
    public function blogAction(): Response
    {
        // ...
    }

    /**
     * @Route("/blog/article/{articleId}", name="blog_article")
     */
    public function ArticleAction(string $articleId): Response
    {
        // ...
    }
}

## 1-Utiliser un menu provider ****
>>>> config/packages/sonata_admin.yaml
sonata_admin:
    dashboard:
        groups:
            # First group menu
            my_group:
            # builder permettant de construire le menu 
                provider:        'MyBundle:MyMenuProvider:getMyMenu' # buider du menu ou alias service menu
                icon:            'fas fa-edit' # html is also supported
            # second group menu
            sonata.admin.group.content:
            # keep_open : the group menu will always be open
                keep_open:          true
                # Sans montrer les élement enfants sans arborescence
                on_top:             true
                label:              sonata_media
                translation_domain: SonataMediaBundle
                icon:               'fas fa-image' # html is also supported
                items:
                    - sonata.media.admin.media
                    - sonata.media.admin.gallery

## 2-Créer un menu avec builder

### ContainerAwareInterface
// src/Menu/MainBuilder.php

namespace App\Menu;
use App\Event\ConfigureMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MainBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function build(FactoryInterface $factory)
    {
        //Les items du menu
        $menu = $factory->createItem('root');

        //les enfant de l'item créer
        $menu->addChild('Dashboard', ['route' => '_acp_dashboard']);

        //Obtention des listener des event objet .
        $this->container->get('event_dispatcher')->dispatch(
            new ConfigureMenuEvent($factory, $menu),
            ConfigureMenuEvent::CONFIGURE
        );

        return $menu;
    }
}

ou/

### the best way without implements
>>> config/services.yaml
services:
    app.menu_builder:
        class: App\Menu\MenuBuilder
        # private argts of my class with will be instanciate
        arguments: ["@knp_menu.factory"]
        tags:
            - { name: knp_menu.menu_builder, method: createMainMenu, alias: main } # The alias is what is used to retrieve the menu
            - { name: knp_menu.menu_builder, method: createSidebarMenu, alias: sidebar } # Named "sidebar" this time
  
>>> src/Menu/MenuBuilder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private $factory;

    /**
     * Add any other dependency you need...
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
            //ul element
            ->setChildrenAttribute('class', 'navbar-nav mr-auto');
            //->setLinkAttribute('class', 'navbar-nav mr-auto');
            $menu->addChild('Home', ['route' => 'app_client_accueil'])
                //liste
                ->setAttribute('class', 'nav-item');
                //link
                //->setLinkAttribute('class', 'nav-item');
                //

            $menu->addChild('Se Conecter', ['route' => 'app_login_client'])
            ->setAttribute('class', 'nav-item')
            //icon
            ->setExtras([
            'icon' => 'fas fa-bar-chart', // html is also supported
            ]);
            
            $menu->addChild('S inscrire', ['route' => 'app_register_client', 'extras' => array(
                'icon' => 'icon-user',
            ),])
            ->setAttribute('class', 'nav-item')
            
            ->setExtra('translation_domain', 'AcmeAdminBundle');


            // create a menu item with drop-down
            $menu->addChild('Administration', ['route' => 'app_admin_register'])
            ->setAttribute('class', 'nav-item');
            $menu['Administration']->addChild('S inscrire', array('route' => 'app_admin_register'));
            $menu['Administration']->addChild('Se Conecter', array('route' => 'app_admin_register'));
            $menu['Administration']->setChildrenAttribute('class', 'dropdown-menu');
        $menu->addChild('Home', ['route' => 'homepage']);
        // ... add more children

        return $menu;
    }

    
    public function createSidebarMenu(array $options /*options is set in the twig*/): ItemInterface
    {
        $menu = $this->factory->createItem('sidebar');

        if (isset($options['include_homepage']) && $options['include_homepage']) {
            $menu->addChild('Home', ['route' => 'homepage']);
        }

        // ... add more children

        return $menu;
    }
}

>>>twig
//Appel de la du mznu sidebar avec les options configurer
{% set menu = knp_menu_get('sidebar', [], {include_homepage: false}) %}
//rendre le menu créer ci-dessus
{{ knp_menu_render(menu) }}
{{ knp_menu_render('AppBundle:Builder:mainMenu', {'template': 'AppBundle:Menu:knp_menu.html.twig'}) }}
>>>
{% extends 'knp_menu.html.twig' %}
     {% block list %}
        {% if item.hasChildren and options.depth is not same as(0) and item.displayChildren %}
            {% import _self as knp_menu %}
            <nav class="navbar navbar-light bg-light  navbar-expand-lg ">
            <ul{{ knp_menu.attributes(listAttributes) }}>
                {{ block('children') }}
            </ul>
            </nav>
        {% endif %}
    {% endblock %}

{% block label %}
    {% if item.extra('icon') is not null %}
        <i class="{{ item.extra('icon') }}"></i>
    {% endif %}
    {{ parent() }}
{% endblock %}

### the best way without implements v2
//My builder
>>>
// src/Menu/MenuBuilder.php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
            //ul element
            ->setChildrenAttribute('class', 'navbar-nav mr-auto');
            //->setLinkAttribute('class', 'navbar-nav mr-auto');
            $menu->addChild('Home', ['route' => 'app_client_accueil'])
                //liste
                ->setAttribute('class', 'nav-item');
                //link
                //->setLinkAttribute('class', 'nav-item');
                //

            $menu->addChild('Se Conecter', ['route' => 'app_login_client'])
            ->setAttribute('class', 'nav-item');
            
            $menu->addChild('S inscrire', ['route' => 'app_register_client'])
            ->setAttribute('class', 'nav-item');


            // create a menu item with drop-down
            $menu->addChild('Administration', ['route' => 'app_admin_register'])
            ->setAttribute('class', 'nav-item');
            $menu['Administration']->addChild('S inscrire', array('route' => 'app_admin_register'));
            $menu['Administration']->addChild('Se Conecter', array('route' => 'app_admin_register'));
            $menu['Administration']->setChildrenAttribute('class', 'dropdown-menu');
        $menu->addChild('Home', ['route' => 'homepage']);
        // ... add more children

        return $menu;
    }

        public function createSidebarMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('sidebar');

        $menu->addChild('Home', ['route' => 'homepage']);
        // ... add more children

        return $menu;
    }

}

//definition of my builder  and ohters menu
>>> config/services.yaml
services:
    //-important My builder
    app.menu_builder:
        class: App\Menu\MenuBuilder
        arguments: ["@knp_menu.factory"]
    //Menu 1: main_menu
    app.main_menu:
        class: Knp\Menu\MenuItem # the service definition requires setting the class
        //factory: spécifier le builder:@app.menu_builder et la funtion createSidebarMenu
        factory: ["@app.menu_builder", createMainMenu]
        arguments: ["@request_stack"]
        tags:
            - { name: knp_menu.menu, alias: main } # The alias is what is used to retrieve the menu
    //Menu 2: Sidebar
    app.sidebar_menu:
        class: Knp\Menu\MenuItem
        //factory: spécifier le builder:@app.menu_builder et la funtion createSidebarMenu
        factory: ["@app.menu_builder", createSidebarMenu]
        arguments: ["@request_stack"]
        tags:
            - { name: knp_menu.menu, alias: sidebar } # Named "sidebar" this time
>>>twig
//render a main
{{ knp_menu_render('sidebar') }}

## 3-Utiliser un (ecouteur d'évènement) évènement sur les menus
//Ajouter un ecouteeur d evenement  en tant que service
>>>config/services.yaml
services:
    app.menu_listener:
        class: App\EventListener\MenuBuilderListener
        tags:
            - { name: kernel.event_listener, event: sonata.admin.event.configure.menu.sidebar /*event liste*/, method: addMenuItems }

//création d'un eventlistener (ecouteur d evenement)
>>>> src/EventListener/MenuBuilderListener.php
namespace App\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

final class MenuBuilderListener
{
        //Execution a l'invocation de l'eventlistener
        public function __invoke(ConfigureMenuEvent $event)
        {
            //obtention du menu
            $menu = $event->getMenu();
             //Ajout d'un element enfant Match et enfant
            $menu->addChild('Matches', ['route' => 'versus_rankedmatch_acp_matches_index']);
            $menu->addChild('Participants', ['route' => 'versus_rankedmatch_acp_participants_index']);
        }

    public function addMenuItems(ConfigureMenuEvent $event ): void
        {
            //obtention du menu
            $menu = $event->getMenu();

            $child = $menu->addChild('reports', [
                'label' => 'Daily and monthly reports',
                'route' => 'app_reports_index',
            ])->setExtras([
                'icon' => 'fas fa-bar-chart', // html is also supported
            ]);
        }
}

//création d'un évènement
>> src/Event/ConfigureMenuEvent.php <<<

namespace App\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\Event;

class ConfigureMenuEvent extends Event
{
    //
    const CONFIGURE = 'app.menu_configure';

    private $factory;
    private $menu;

    public function __construct(FactoryInterface $factory, ItemInterface $menu)
    {
        $this->factory = $factory;
        $this->menu = $menu;
    }

    /**
     * @return \Knp\Menu\FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return \Knp\Menu\ItemInterface
     */
    public function getMenu()
    {
        return $this->menu;
    }
}

## Déclarer un menu en tant que service******
//Configuration du service
>>> config/service.yml
    my_menu_provider:
        class: MyBundle/MyDirectory/MyMenuProvider
        tags:
            - { name: knp_menu.menu,   
                alias: my_menu_alias
                 }

//Class du menu
>>>

## 4-Afficher un menu
>>>twig
{{ knp_menu_render('main', {}, 'custom') }}
//Afficher un menu avec son template
{{ knp_menu_render('AppBundle:Builder:mainMenu', {'template': 'AppBundle:Menu:knp_menu.html.twig'}) }}
>>>extends
{% extends 'knp_menu.html.twig' %}
     {% block list %}
        {% if item.hasChildren and options.depth is not same as(0) and item.displayChildren %}
            {% import _self as knp_menu %}
            <nav class="navbar navbar-light bg-light  navbar-expand-lg ">
            <ul{{ knp_menu.attributes(listAttributes) }}>
                {{ block('children') }}
            </ul>
            </nav>
        {% endif %}
    {% endblock %}

## créer et enregistrer son propre un provider ***
https://symfony.com/bundles/KnpMenuBundle/current/custom_provider.html

## Enregistrer son propre rendu ***
https://symfony.com/bundles/KnpMenuBundle/current/custom_renderer.html

## créer un template
{{ knp_menu_render('namespace:class:function') }}
//Afficher un menu
{% set menuItem = knp_menu_get('App:Builder:mainMenu') %}
{{ knp_menu_render(menuItem) }}
//passer depth et currentAsLink en argument de la function mainMenu du builder
{{ knp_menu_render('App:Builder:mainMenu', {'depth': 2, 'currentAsLink': false}) }}
//PAsser quelques options au t$builder
{% set menuItem = knp_menu_get('App:Builder:mainMenu', [], {'some_option': 'my_value'}) %}
{{ knp_menu_render(menuItem) }}

# Gérer des données CRUD Front-office 
>>> Controller
   public function show(ManagerRegistry $doctrine, int $id): Response
    {
        //produit  par categorie 
        $CustomProduct = $doctrine->getRepository(Product::class)->findOneByIdJoinedToCategory($id);
        //produit par id
        $product = $doctrine->getRepository(Product::class)->find($id);
        // ...

        //category du produit
        $categoryName = $product->getCategory()->getName();

    }


>>> repository
    public function findOneByIdJoinedToCategory(int $productId): ?Product
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, c
            FROM App\Entity\Product p
            INNER JOIN p.category c
            WHERE p.id = :id'
        )->setParameter('id', $productId);

        return $query->getOneOrNullResult();
    }

## Afficher un object 
>>>AbstractController

use App\Entity\Articles;
use Doctrine\Persistence\ManagerRegistry;
#[Route('/', name: 'app_client_accueil')]
public function index(ManagerRegistry $doctrine): Response
{
    $repository = $doctrine->getRepository(Articles::class);

    //All articles
    $articles = $repository->findAll();
    ->find($id);

        // look for a single Product by name
    $articles  = $repository->findOneBy(['name' => 'Keyboard']);
    // or find by name and price
    $articles  = $repository->findOneBy([
        'name' => 'Keyboard',
        'price' => 1999,
    ]);

    // look for multiple Product objects matching the name, ordered by price
    $articles  = $repository->findBy(
        ['name' => 'Keyboard'],
        ['price' => 'ASC']
    );
    //exeption
    if (!$articles) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }

    return $this->render('client/page-teaser.html.twig', [
        'controller_name' => 'ClientController',
        'articles'=>$articles,
    ]);
}

### Avec le repository
>>> AbstractController.php

use App\Entity\Product;
use App\Repository\ProductRepository;
    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository
            ->find($id);

        // ...
    }

### Afficher un produit cible directement sur une page
    #[Route('/product/{id}')]
    public function show(Product $product): Response
    {
        // use the Product!
        // ...
    }
>>>twig
<a href="{{ path('blog_index') }}">Homepage</a>

{# ... #}

{% for post in blog_posts %}
    <h1>
        <a href="{{ path('blog_post', {slug: post.slug}) }}">{{ post.title }}</a>
    </h1>

    <p>{{ post.excerpt }}</p>
{% endfor %}

# WorkFlow ******
//https://symfony.com/doc/current/components/workflow.html

# Questions:
- Quesqu'un workflow?
- Quesqu'un Menu provider?

# phpunit*******

## Context
Each test is a PHP class ending with "Test" (e.g. BlogControllerTest) that lives in the tests/ directory of your application.

PHPUnit is configured by the phpunit.xml.dist file in the root of your application. The default configuration provided by Symfony Flex will be enough in most cases. Read the PHPUnit documentation to discover all possible configuration options (e.g. to enable code coverage or to split your test into multiple "test suites").

Note

Symfony Flex automatically creates phpunit.xml.dist and tests/bootstrap.php. If these files are missing, you can try running the recipe again using composer recipes:install phpunit/phpunit --force -v.
Les types de test:
Unit Tests
These tests ensure that individual units of source code (e.g. a single class) behave as intended.
Integration Tests
These tests test a combination of classes and commonly interact with Symfony's service container. These tests do not yet cover the fully working application, those are called Application tests.
Application Tests
Application tests test the behavior of a complete application. They make HTTP requests (both real and simulated ones) and test that the response is as expected.

-créer des sous répertoire pour chaque class source et par chaque type de test.;

chaque Test est une classe php finissant par Test définie dans le répertoire tests/ de vos application.
PHPUnit est configuré par phpunit.xml.dist dans le root de votre application.La configuration par défaut fournit par Symfony Flex sera assez dans le meilleur des cas. 
Lire la documentation pour obtenir plus d'option.
https://phpunit.readthedocs.io/en/9.5/configuration.html

Il y a plusieurs types de tests automatique et de definitions precise  differ souventde projet to projet.
Les types utilisé dans symfony:
1- Test Unitaire : tester une seul class.
2- Tests d'intégration: Ces tests testent une combinaison de classe qui interragissent en commun avec le service container.

3- Tests d'application: Les tests d'application testent  the bahavior de l'application de test. Ils sont des requêtes HTTP (a la fois réel et simulé) et test si la réponse est attendu.

By convention, the tests/ directory should replicate the directory of your application for unit tests. So, if you're testing a class in the src/Form/ directory, put the test in the tests/Form/ directory. Autoloading is automatically enabled via the vendor/autoload.php file (as configured by default in the phpunit.xml.dist file).

## Lancement
//instalation
composer require --dev symfony/test-pack
//créer un test
php bin/console make:test
//Lancer tout les tests de cette application. 
php bin/phpunit
//obtention d'un test Bootstrap dans phpUnit.
composer recipes:install phpunit/phpunit --force -v
//run all test in the form directory
php bin/phpunit tests/Form
// Run a test of a class
php bin/phpunit tests/Form/class.php

## Application

#### clear manually le cache
as it significantly improves test performance. This disables clearing the cache. If your tests don't run in a clean environment each time, you have to manually clear it using for instance this code in

// ensure a fresh cache when debug mode is disabled
(new \Symfony\Component\Filesystem\Filesystem())->remove(__DIR__.'/../var/cache/test))


### Dépendance Mock

>>> tests/KernelTestCase
use App\Contracts\Repository\NewsRepositoryInterface;
use App\Service\NewsletterGenerator;

class NewsletterGeneratorTest extends KernelTestCase
{
    public function testSomething()
    {
        // (1) boot the Symfony kernel
        //self::bootKernel();
        self::bootKernel([
        'environment' => 'my_test_env',
        'debug'       => false,
        ]);

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) retrieve some NewsletterGenerator service & test the result
        $newsletterGenerator = $container->get(NewsletterGenerator::class);
        $newsletter = $newsletterGenerator->generateMonthlyNews(...);

        $this->assertEquals('...', $newsletter->getContent());
        // ... same bootstrap as the section above

        $newsRepository = $this->createMock(NewsRepositoryInterface::class);
        $newsRepository->expects(self::once())
            ->method('findNewsFromLastMonth')
            ->willReturn([
                new News('some news'),
                new News('some other news'),
            ])
        ;

        // the following line won't work unless the alias is made public
        $container->set(NewsRepositoryInterface::class, $newsRepository);

        // will be injected the mocked repository
        $newsletterGenerator = $container->get(NewsletterGenerator::class);

    }
}

//Rendre les services public pour etre accessible de puis container->get().
>>> config/services_test.yaml
services:
    # redefine the alias as it should be while making it public
    App\Contracts\Repository\NewsRepositoryInterface:
        alias: App\Repository\NewsRepository
        public: true


// Installer et configurer un environnement de test.
>>> config/packages/test/twig.yaml
twig:
    # Attrapper les erreurs avant de mettre le code en production.
    strict_variables: true


//overider les variables d'environnements
>>>.env.test: 
overriding/setting specific test values or vars;


### Configurer une base de données pour le tests
//1-Resetting the Database Automatically Before each Test
composer require --dev dama/doctrine-test-bundle
//2-create the test database
php bin/console --env=test doctrine:database:create
//3-create the table colonne in the database
php bin/console --env=test doctrine:schema:create
//Activer l'extension PHPUnit
>>><!-- phpunit.xml.dist -->
<phpunit>
    <!-- ... -->

    <extensions>
        <extension class="DAMA\DoctrineTestBundle\PHPUnit\PHPUnitExtension"/>
    </extensions>
</phpunit>

// Laisser doctrine 

### Test application et controler
/** Ce sont des class php qui vivent dans le chemin 'tests/Controller/' héritant d'une class  WebTestCase.   */

php bin/console make:test
Which test type would you like?:
 > WebTestCase

 The name of the test class (e.g. ControllerNameTest):
 > Controller\ControllerNameTest

 // tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        /**
        //custom header http
        $client = static::createClient([], [
                'HTTP_HOST'       => 'en.example.com',
                'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
            ]);

         */

        //operation that is supporte in browser
        $client->back();
        $client->forward();
        $client->reload();
        
        //redirection
        $client->followRedirects();

        // clears all cookies and the history
        $client->restart();

        // Request a specific page
        /**
            request(
                        string $method,
                        string $uri,
                        array $parameters = [],
                        array $files = [],
                        array $server = [],
                        string $content = null,
                        bool $changeHistory = true
                    ): Crawler

         */

        $crawler = $client->request('GET', '/');
        /**
        //overider la requete de http header
        //https://www.rfc-editor.org/rfc/rfc3875#section-4.1.18
        $client->request('GET', '/', [], [], [
            'HTTP_HOST'       => 'en.example.com',
            'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
        ]);
         */

        //Requêtes Ajax
        $client->xmlHttpRequest('POST', '/submit', ['name' => 'Fabien']);

        //Désactiver les exceptions dans le profiler
        $client->catchExceptions(false);

        //5.1 -obtention des données client.
        $history = $client->getHistory();
        $cookieJar = $client->getCookieJar();

        //5.2- obtention des données client de la requete
        //5.2 - the HttpKernel request instance
        $request = $client->getRequest();

        //5.2- the BrowserKit request instance
        $request = $client->getInternalRequest();

        //5.2- the HttpKernel response instance
        $response = $client->getResponse();

        //5.2- the BrowserKit response instance
        $response = $client->getInternalResponse();

        //5.2- the Crawler instance
        $crawler = $client->getCrawler();

        //6.0-Acéder au profiler
        // enables the profiler for the very next request
        $client->enableProfiler();

        // gets the profile
        $profile = $client->getProfile();


        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();

        //put some content in the page
        $this->assertSelectorTextContains('h1', 'Hello World');

        // for instance, count the number of ``.comment`` elements on the page, with the crawler you can manage the dom.
        $this->assertCount(4, $crawler->filter('.comment'))


        }
}

### Simulate Login
//une methode loginUser() pour simuler une authentification
>>> tests/Controller/ProfileControllerTest.php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{

    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('john.doe@example.com');

        // simulate $testUser qui hérite de userInterface being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/profile');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello John!');
    }
}

# Manager des media au front-Office

## charger un document*******
>>>src/Entity/Product.php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class Product
{
    /**
     * @ORM\Column(type="string")
     */
    private $brochureFilename;

    public function getBrochureFilename()
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename($brochureFilename)
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }
}
//Création du formulaire
>>>>src/Form/ProductType.php
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
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
                            'xml' => ['text/xml', 'application/xml'],
                            'txt' => 'text/plain',
                            'jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            // ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

//Code du controlleur
>>>>
// src/Controller/ProductController.php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/new", name="app_product_new")
     */
    public function new(Request $request, SluggerInterface $slugger)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();

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
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $product->setBrochureFilename($newFilename);
            }

            /**
            //Mise a jour de l'image sur un formulaire ayant des données déjà persister
            $product->setBrochureFilename(new File($this->getParameter('brochures_directory').'/'.$product->getBrochureFilename()));
             */

            // ... persist the $product variable or any other work

            return $this->redirectToRoute('app_product_list');
        }

        return $this->renderForm('product/new.html.twig', [
            'form' => $form,
        ]);
    }
}

//brochures_directory parameter that was used in the controller to specify the directory in which the brochures should be stored:
>>>config/services.yaml
parameters:
    brochures_directory: '%kernel.project_dir%/public/uploads/brochures'

>>>twig
//afficher le formulaire

//lien permettant la fichage du produit
<a href="{{ asset('uploads/brochures/' ~ product.brochureFilename) }}">View brochure (PDF)</a>

## Créer un service de chargement de document *****
//Réalisation du service upload
>>> src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}

>>> config/services.yaml
services:
    # ...

    App\Service\FileUploader:
        arguments:
            $targetDirectory: '%brochures_directory%'

//utilisation du service dans un controlleur
>>> src/Controller/ProductController.php
namespace App\Controller;

use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

// ...
public function new(Request $request, FileUploader $fileUploader)
{
    // ...

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $brochureFile */
        $brochureFile = $form->get('brochure')->getData();
        if ($brochureFile) {
            $brochureFileName = $fileUploader->upload($brochureFile);
            $product->setBrochureFilename($brochureFileName);
        }

        // ...
    }

    // ...
}


