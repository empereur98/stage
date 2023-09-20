<?php

namespace App\Controller\Admin;

use App\Entity\Vocabulaire;
use App\Form\VocabulaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVocabulaireController extends AbstractController
{
    public $em;
    public function __construct(EntityManagerInterface $em){
       $this->em=$em;
    }
    #[Route('admin/newvocabulaire', name: 'new_vocabulaire')]
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        $mot=new Vocabulaire();
        $form=$this->createForm(VocabulaireType::class,$mot);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mot=$form->getData();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            $em->persist($mot);
            $em->flush();
        }
        return $this->render('admin/vocabulaire.html.twig', [
            'controller_name' => 'VocabulaireController',
            'form'=>$form->createView()
        ]);
    }
    #[Route('/admin/mot/edit/{id}', name:'edit_vocabulaire')]
     public function editRegion(Vocabulaire $mot,Request $request):Response{
      $form=$this->createForm(VocabulaireType::class,$mot);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $this->em->flush();
         $this->addFlash('success','modification reussie');
         return $this->redirectToRoute('admin');
      }
      return $this->render('admin/edit-mot.html.twig',[
        'form'=>$form->createView()
      ]);
     }

     #[Route('/admin/delete/{id}',name:'delete',methods:'DELETE|POST')]
     public function delete(Vocabulaire $mot): Response
     {
       $local=$this->em->getRepository(Vocabulaire::class);
       $local->delete($mot);
       $this->addFlash('success','mot supprimer avec succes');
        return $this->redirectToRoute('admin');
        return new Response($this->render('pages/admin.html.twig',[
         'mots'=>$mot
     ]));
     }
}
