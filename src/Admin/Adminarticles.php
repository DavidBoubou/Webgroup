<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class Adminarticles extends AbstractAdmin
{

/*Utliser la métode dun  forbuilder pour les arguements.*/

protected function configureFormFields(FormMapper $form):void 
    {
        // This method configures which fields are displayed on the edit and create actions. 
        //The FormMapper behaves similar to the FormBuilder of the Symfony Form component;
        $form->add('titre');

    }

protected function configureDatagridFilters(DatagridMapper $datagrid):void
    {
        // This method configures the filters, used to filter and sort the list of models;
        $datagrid->add('titre');

    }

protected function configureListFields(ListMapper $list):void 
    {
        //This method configures which fields are shown when all models are listed 
        //(the addIdentifier() method means that this field will link to the show/edit page of this particular
        // model);
        $list->add('titre');

    }

protected function configureShowFields(ShowMapper $show):void 
    {
        //This method configures which fields are displayed on the show action.
        $show->add('titre');

        
    }
}
