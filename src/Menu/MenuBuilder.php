<?php
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
            $menu = $this->factory->createItem('root')
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

            //$menu->addChild('Administration', ['route' => 'app_admin_register'])

            // create a menu item with drop-down
            $menu->addChild('Administration')->setAttribute('class', 'nav-item');
            $menu['Administration']->addChild('S inscrire', array('route' => 'app_admin_register'));
            $menu['Administration']->addChild('Se Conecter', array('route' => 'app_admin_register'));
            $menu['Administration']->setChildrenAttribute('class', 'dropdown-menu');
 

            return $menu;
        }

}
