<?php

namespace App\Controller\Admin;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminExerciceController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    #[Route('admin/newexercice', name: 'new_exercice')]
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        $exercice=new Exercice();
        $form=$this->createForm(ExerciceType::class,$exercice);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $exercice=$form->getData();
            $em->persist($exercice);
            $em->flush();
            $this->addFlash('success','votre Exercice a ete modifier');
            return  $this->redirectToRoute('admin');
        }
        $tab=explode(',',$exercice->getChoixDeReponse(),4);
        dump($tab);
        return $this->render('admin/exercice.html.twig', [
            'controller_name' => 'ExerciceController',
            'form'=>$form->createView()
        ]);
    }
     #[Route('/admin/exercice/edit/{id}', name:'edit_exercice')]
     public function editExercice(Exercice $exercice,Request $request):Response{
      $form=$this->createForm(ExerciceType::class,$exercice);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $this->em->flush();
         $this->addFlash('success','modification reussie');
         return $this->redirectToRoute('admin');
      }
      return $this->render('admin/edit-exercice.html.twig',[
        'form'=>$form->createView()
      ]);
     }

     #[Route('/admin/delete/{id}',name:'delete',methods:'DELETE|POST')]
     public function delete(Exercice $exercice): Response
     {
       $local=$this->em->getRepository(Exercice::class);
       $local->delete($exercice);
       $this->addFlash('success','exercice supprimer avec succes');
        return $this->redirectToRoute('admin');
        return new Response($this->render('pages/admin.html.twig',[
         'Exercice'=>$exercice
     ]));
     }
}
