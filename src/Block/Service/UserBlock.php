<?php
declare(strict_types=1);

namespace App\Block\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\Form\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Environment;
//use App\Entity\UserSonata;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserBlock extends AbstractBlockService
{
    private TokenStorageInterface $token_storage;
    private Environment $twig;
    private int $four;
    function __construct(Environment $twig,TokenStorageInterface $token_storage) {
        parent::__construct($twig);
        $this->token_storage =  $token_storage;
    }

//1-configuration du blok
public function configureSettings(OptionsResolver $resolver):void
{
   // $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    //$this->denyAccessUnlessGranted('IS_AUTHENTICATED');
   // dd($this->token_storage);
    $user = $this->token_storage->getToken()->getUser();;
    //$user = $this->security->getUser();

    $resolver->setDefaults([
        'user' =>$user,
        //the block title
        'title' => 'Utilisateur connecté',
        //The template to render the block
        'template' => 'Block/user.html.twig',
    ]);
}



//4-hoook d'éxécution du formulaire pour un block rss
//Cette methode droit retourner une réponse objet pour rendre le tableau
public function execute(BlockContextInterface $blockContext, Response $response = null): Response
{
    // merge settings
    $settings = $blockContext->getSettings();
    return $this->renderResponse($blockContext->getTemplate(), [
        'block'     => $blockContext->getBlock(),
        'settings'  => $settings
    ], $response);


}

}