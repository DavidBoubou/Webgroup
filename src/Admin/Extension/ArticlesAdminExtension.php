<?php
namespace App\Admin\Extension;

use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;

#[AutoconfigureTag(name: 'app.articles.extension', attributes: ['target' => 'admin.articles'])]
final class ArticlesAdminExtension extends AbstractAdminExtension
{
    public function configureFormFields(FormMapper $form): void
    {
        $form ->add('autheur',EntityType::class,[
            'class' => User::class,
            'choice_label' => 'email']);
    }
}