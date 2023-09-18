<?php

namespace App\Controller\Admin;

use App\Entity\Langue;
use App\Form\LangueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLangueController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em){
       $this->em=$em;
    }
    #[Route(path:'/admin/newlangue', name:'new_langue')]
     public function add(Request $request):Response{
        $langue=new Langue();
        $form=$this->createForm(LangueType::class,$langue);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $region=$form->getData();
            $this->em->persist($region);
            $this->em->flush();
            $this->addFlash('success','votre region a ete modifier');
            return  $this->redirectToRoute('admin');
        }
        return $this->render('admin/langue.html.twig',[
            'controller_name'=>'AdminRegionController',
           'form'=>$form->createView()
        ]);
     }
     #[Route('/admin/langue/edit/{id}', name:'edit_langue')]
     public function editRegion(Langue $langue,Request $request):Response{
      $form=$this->createForm(LangueType::class,$langue);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $this->em->flush();
         $this->addFlash('success','modification reussie');
         return $this->redirectToRoute('admin');
      }
      return $this->render('admin/edit-langue.html.twig',[
        'form'=>$form->createView()
      ]);
     }

     #[Route('/admin/delete/{id}',name:'delete',methods:'DELETE|POST')]
     public function delete(Langue $langue): Response
     {
       $local=$this->em->getRepository(Langue::class);
       $local->delete($langue);
       $this->addFlash('success','langue supprimer avec succes');
        return $this->redirectToRoute('admin');
        return new Response($this->render('pages/admin.html.twig',[
         'region'=>$langue
     ]));
     }
}
