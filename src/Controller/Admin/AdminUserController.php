<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AdminUserController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em){
      $this->em=$em;  
    }

    #[Route('/admin/user', name: 'app_admin_user')]
    public function index(): Response
    {
        return $this->render('admin/user.html.twig', [
            'controller_name' => 'AdminUserController',
        ]);
    }
    #[Route('/admin/inscription', name: 'new_user')]
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
        $user->setRoles(['ROLE_ADMIN']);
        $this->em->persist($user);
        $this->em->flush();
        $this->addFlash('success','vous ete bien enregistrer dans la base de donnees');
        return $this->redirectToRoute('admin');
        }
        
        return $this->render('admin/user.html.twig', [
            'controller_name' => 'AdminLoginController',
            'form'=>$form->createView()
        ]);
    }

    #[Route('/admin/user/edit/{id}', name:'edit_user')]
    public function editRegion(User $user,Request $request):Response{
     $form=$this->createForm(UserType::class,$user);
     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
        $this->addFlash('success','modification reussie');
        return $this->redirectToRoute('admin');
     }
     return $this->render('admin/edit-user.html.twig',[
       'form'=>$form->createView()
     ]);
    }

    #[Route('/admin/delete/{id}',name:'delete',methods:'DELETE|POST')]
    public function delete(User $user): Response
    {
      $local=$this->em->getRepository(User::class);
      $local->delete($user);
      $this->addFlash('success','user supprimer avec succes');
       return $this->redirectToRoute('admin');
       return new Response($this->render('pages/admin.html.twig',[
        'user'=>$user
    ]));
    }
}
