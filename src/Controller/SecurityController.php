<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Vérifier si l'utilisateur a été supprimé
       

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
        // Symfony will intercept this route and handle the logout automatically
    }

    #[Route(path: '/logout-message', name: 'app_logout_message')]
    public function logoutMessage(): void
    {
        /** @var Session */
        $session = $this->container->get('request_stack')->getSession();
        // dd($session->get('deletedAccount'));
        if($session->get('deletedAccount')){
           
        }
        // verifier si on vient d'une suppression de compte
        // $this->addFlash()
        // $this->redirectToRoute('app_home');


        //on est dans profile
        //cette ligne envoie les datas
        //cette ligne deco
    }

    
}