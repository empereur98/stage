<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em){
      $this->em=$em;  
    }

    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
      {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();
           return $this->render('login/index.html.twig', [
                 'last_username' => $lastUsername,
                 'error'         => $error,
              ]);
            }

    #[Route('/inscription', name: 'app_inscription')]
    public function add(Request $request ,UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        dump($user);
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$form->getData();
            $plaintextPassword = $user->getPassword();

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setRole('ROLE_USER');
        $this->em->persist($user);
        $this->em->flush();
        $this->addFlash('success','vous ete bien enregistrer dans la base de donnees');
        return $this->redirectToRoute('app_region');
        }
        
        return $this->render('login/inscription.html.twig', [
            'controller_name' => 'AdminLoginController',
            'form'=>$form
        ]);
    }
}
