<?php

declare(strict_types=1);

namespace App\Admin;
use  App\Entity\SonataPageSite;
use  Sonata\PageBundle\Model\Site;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Sonata\PageBundle\Form\Type\TemplateChoiceType;
use Sonata\PageBundle\Model\PageInterface;
use Sonata\PageBundle\Model\PageManagerInterface;
use Sonata\PageBundle\Model\SiteInterface;
use Sonata\PageBundle\Model\SiteManagerInterface;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Security\Acl\Permission\AdminPermissionMap;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Sonata\PageBundle\Exception\InternalErrorException;
use Sonata\PageBundle\Form\Type\PageSelectorType;
use Sonata\PageBundle\Form\Type\PageTypeChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class ArticlesCustomAdmin extends AbstractAdmin
{

    protected $classnameLabel = 'Page';

    private PageManagerInterface $pageManager;

    private SiteManagerInterface $siteManager;

    public function __construct(
        PageManagerInterface $pageManager,
        SiteManagerInterface $siteManager
    ) {
        parent::__construct();

        $this->pageManager = $pageManager;
        $this->siteManager = $siteManager;
    }

        /**
     * @throws \RuntimeException
     */
    private function getSite(): ?SiteInterface
    {
        if (!$this->hasRequest()) {
            return null;
        }

        $siteId = null;

        if ('POST' === $this->getRequest()->getMethod()) {
            $values = $this->getRequest()->get($this->getUniqId());
            $siteId = $values['site'] ?? null;
        }

        $siteId ??= $this->getRequest()->get('siteId');

        if (null !== $siteId) {
            $site = $this->siteManager->findOneBy(['id' => $siteId]);

            if (null === $site) {
                throw new \RuntimeException('Unable to find the site with id='.$this->getRequest()->get('siteId'));
            }

            return $site;
        }

        return null;
    }

    protected function alterNewInstance(object $object): void
    {
        if (!$this->hasRequest()) {
            return;
        }

        $site = $this->getSite();
        $object->setSite($site);

        if (null !== $site && null !== $this->getRequest()->get('url')) {
            $slugs = explode('/', $this->getRequest()->get('url'));
            $slug = array_pop($slugs);

            $parent = $this->pageManager->getPageByUrl($site, implode('/', $slugs)) ??
                $this->pageManager->getPageByUrl($site, '/');

            if (null === $parent) {
                throw new InternalErrorException('Unable to find the root url, please create a route with url = /');
            }

            $object->setSlug(urldecode($slug));
            $object->setParent($parent);
            $object->setName(urldecode($slug));
        }
    }

    protected function configurePersistentParameters(): array
    {
        $parameters = [];
        $key = sprintf('%s.current_site', $this->getCode());

        if (!$this->hasRequest()) {
            return $parameters;
        }

        $request = $this->getRequest();

        $site = $request->get('site', null);

        if (null !== $site) {
            $request->getSession()->set($key, $site);
        }

        $site = $request->getSession()->get($key, null);

        if (null !== $site) {
            $parameters['site'] = $site;
        }

        return $parameters;
    }


    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('title')
            ->add('baniere_url')
            ->add('content')
            ->add('enabled')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('title')
            ->add('baniere_url')
            ->add('content')
            ->add('enabled')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {

        $form
        ->with('main', ['class' => 'col-md-6'])->end()
        ->with('seo', ['class' => 'col-md-6'])->end()
        ->with('advanced', ['class' => 'col-md-6'])->end();

       $page = $this->hasSubject() ? $this->getSubject() : null;
       $site = null !== $page ? $page->getSite() : null;

        //si la page n'est pas créer et qu'il n y a pas d erreur
       if (null === $page || (!$page->isInternal() && !$page->isError())) {
           $form
               ->with('main')
                   ->add('url', TextType::class, ['attr' => ['readonly' => true]])
               ->end();
       }

       //Si la page existe
       if (null !== $page && null === $page->getId()) {
           $form
               ->with('main')
                   ->add('site', null, ['required' => true, 'attr' => ['readonly' => true]])
               ->end();
       }

       $form
                ->with('main')
                ->add('title')
                ->add('site', EntityType::class, [
                      'class' => SonataPageSite::class,//SonataPageSite::class,
                        'expanded' => true,
                       //'multiple' => true   
                        ])
                        
                ->add('routeName')
                ->add('pageAlias')
                ->add('type')
                ->add('baniere_url')
                ->add('decorate')
                ->add('name')
                ->add('edited')
                ->add('content', SimpleFormatterType::class, [
                    'format' => 'richhtml',
                    'ckeditor_context' => 'default',
                    'ckeditor_image_format' => 'big',
                ])
                ->add('enabled')
               ->add('name', null, ['help' => 'help_page_name'])
               ->add('url')
               ->add('position')
           ->end();

        //si la page est créer et qu'elle est interne
       if (null !== $page && !$page->isInternal()) {
           $form
               ->with('main')
                   ->add('type', PageTypeChoiceType::class, ['required' => false])
               ->end();
       }

       $form
           ->with('main')
               ->add('templateCode', TemplateChoiceType::class, ['required' => true])
           ->end();

       if (null === $page || null === $page->getParent() || null === $page->getId()) {
         /*  $form
               ->with('main')
                   ->add('parent', PageSelectorType::class, [
                       'page' => $page,
                       'site' => $site,
                       'model_manager' => $this->getModelManager(),
                       'class' => $this->getClass(),
                       'required' => false,
                       'filter_choice' => ['hierarchy' => 'root'],
                   ], [
                       'admin_code' => $this->getCode(),
                       'link_parameters' => [
                           'siteId' => null !== $site ? $site->getId() : null,
                       ],
                   ])
               ->end();
        */
       }

       if (null === $page || !$page->isDynamic()) {
           $form
               ->with('main')
                   ->add('pageAlias', null, ['required' => false])
                 /*  ->add('parent', PageSelectorType::class, [
                       'page' => $page,
                       'site' => $site,
                       'model_manager' => $this->getModelManager(),
                       'class' => $this->getClass(),
                       'filter_choice' => ['request_method' => 'all'],
                       'required' => false,
                   ], [
                       'admin_code' => $this->getCode(),
                       'link_parameters' => [
                           'siteId' => null !== $site ? $site->getId() : null,
                       ],
                   ])
                   */
               ->end();
       }

       if (null === $page || !$page->isHybrid()) {
           $form
               ->with('seo')
                   ->add('slug', TextType::class, ['required' => false])
                   ->add('customUrl', TextType::class, ['required' => false])
               ->end();
       }

       $form
           ->with('seo', ['collapsed' => true])
               ->add('metaKeyword', TextareaType::class, ['required' => false])
               ->add('metaDescription', TextareaType::class, ['required' => false])
           ->end();

       if (null !== $page && !$page->isCms()) {
           $form
               ->with('advanced', ['collapsed' => true])
                   ->add('decorate', null, ['required' => false])
               ->end();
       }

        /*
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
            
      //  'ckeditor_context'=> Active and give CKEditor a context in order to customize routes used to browse and upload medias (see “Use CKEditor to select medias in SonataMediaBundle” chapter)
    
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
                */
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('title')
            ->add('baniere_url')
            ->add('content')
            ->add('enabled')
            ;
    }
}
