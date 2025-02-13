<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $router;
    private RequestStack $requestStack;


    public function __construct(RouterInterface $router,RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
         /** @var Session $session */
         $session = $this->requestStack->getSession();

         /** @var FlashBag $flashBag */
         $flashBag = $session->getFlashBag();

        $roles = $token->getRoleNames();

       

           
    

      if (in_array('ROLE_RECRUTEUR', $roles, true) || in_array('ROLE_ADMIN', $roles, true)) {
            $response = new RedirectResponse($this->router->generate('admin'));
        } else {
            $response = new RedirectResponse($this->router->generate('app_home'));
        }

        return $response;
    }
}