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
}
