<?php

namespace App\Controller;

use App\Entity\Commercants;
use App\Form\CommercantsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class LoginSalerController extends AbstractController
{
    #[Route('/admin/login', name: 'app_login_sale')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
         // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('login/index1.html.twig', [
           'last_username' => $lastUsername,
            'error'         => $error,
          ]);
    }
    
}
