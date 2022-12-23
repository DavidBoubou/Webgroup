<?php

namespace App\Controller;

use App\Entity\UserSonata;
use App\Form\UserSonataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;


use Doctrine\Persistence\ManagerRegistry;

class AdminController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route(path: '/admin/login', name: 'app_admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('sonata_admin_dashboard');
         }
        // dd( $authenticationUtils);
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/client-login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    #[Route('/admin/register', name: 'app_admin_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        // This method returns instead the "customer" entity manager
        $customerEntityManager = $doctrine;//->getManager('custom');

        if ($this->getUser()) {
            return $this->redirectToRoute('sonata_admin_dashboard');
        }
        
        $user = new UserSonata();
        $form = $this->createForm(UserSonataType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            //$date =  new \DateTime('@'.strtotime('now'));
            //$user->prePersist();
            //$user->preUpdate();

            //$entityManager->persist($user);
            //$entityManager->flush();

            $customerEntityManager->persist($user);
            $customerEntityManager->flush();


            // generate a signed url and email it to the user
            /*$this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@gmail.com', 'no-reply-bethannie'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            */

            return $this->redirectToRoute('sonata_admin_dashboard');
        }
        
        return $this->render('registration/admin-register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
        
    }


    #[Route(path: '/admin/logout', name: 'app_admin_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
