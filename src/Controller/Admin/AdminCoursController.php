<?php

namespace App\Controller\Admin;

use App\Entity\Cours;
use App\Entity\Langue;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class AdminCoursController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    #[Route(path:'/admin/newcours', name:'new_cours')]
     public function add(Request $request):Response{
        $cours=new Cours();
        $form=$this->createForm(CoursType::class,$cours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cours=$form->getData();
            $this->em->persist($cours);
            $this->em->flush();
            $this->addFlash('success','votre cours a ete modifier');
            return  $this->redirectToRoute('admin');
        }
        return $this->render('admin/cours.html.twig',[
            'controller_name'=>'AdminCoursController',
           'form'=>$form->createView()
        ]);
     }
     #[Route('/admin/cours/edit/{id}', name:'edit_cours')]
     public function editCours(Cours $cours,Request $request):Response{
      $form=$this->createForm(CoursType::class,$cours);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $this->em->flush();
         $this->addFlash('success','modification reussie');
         return $this->redirectToRoute('admin');
      }
      return $this->render('admin/edit-cours.html.twig',[
        'form'=>$form->createView()
      ]);
     }

     #[Route('/admin/delete/{id}',name:'delete',methods:'DELETE|POST')]
     public function delete(Cours $cours): Response
     {
       $local=$this->em->getRepository(Cours::class);
       $local->delete($cours);
       $this->addFlash('success','cours supprimer avec succes');
        return $this->redirectToRoute('admin');
        return new Response($this->render('pages/admin.html.twig',[
         'cours'=>$cours
     ]));
     }
}
