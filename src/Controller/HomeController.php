<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Commercants;
use App\Entity\Region;
use App\Entity\User;
use App\Form\CommercantsType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class HomeController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em){
       $this->em=$em;
    }
    #[Route('/home/hello', name: 'app_home')]
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/newcommercant',name:'newcomm')]
    public function new(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher):Response{
        $commercants=new Commercants();
        $form=$this->createForm(CommercantsType::class,$commercants);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $commercants=$form->getData();
            $plaintextPassword = $commercants->getpassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $commercants,
                $plaintextPassword
            );
            $commercants->setPassword($hashedPassword);
            //dump($commercants);
            //die;
            $em->persist($commercants);
            $em->flush();
        }
        return new Response($this->render('login/newuser.html.twig',[
             'form'=>$form->createView()
        ]));
    }
    #[Route('/newuser',name:'newcomm1')]
    public function newuser(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher):Response{
        $user=new User();
        $form1=$this->createForm(UserType::class,$user);
        $form1->handleRequest($request);
        if($form1->isSubmitted() && $form1->isValid()){
            $plaintextPassword = $user->getpassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $em->persist($user);
            $em->flush();
        }
        return new Response($this->render('login/newuser1.html.twig',[
             'form'=>$form1->createView()
        ]));
    }
    #[Route('/region',name:'app_region')]
    public function homeregion():response{
         $region=$this->em->getRepository(Region::class)->findALL();
         dump($region);
        return $this->render('region/index.html.twig',[
            'regions'=>$region
        ]);
    }
    #[Route('/region/{id}',name:'show_region', methods:['GET'])]
    public function show_region($id):Response{
        $region=$this->em->getRepository(Region::class)->find($id);
        $langues=$this->em->getRepository(Langue::class)->findlangue($id);
        dump($langues);
        $regions=$this->em->getRepository(Region::class)->findALL();
       return $this->render('region/region.html.twig',[
        'region'=>$region,
        'regions'=>$regions,
        'langues'=>$langues
       ]);
    }
    #[Route('/langue/{id}',name:'show_langue',methods:'GET')]
    public function show_langue($id):Response{
        return $this->render('langue/langue.html.twig',[

        ]);
    }
}
