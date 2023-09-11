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
    #[Route('/admin/newlangue', name: 'new_langue')]
     public function add(Request $request):Response{
        $langue=new Langue();
        $form=$this->createForm(LangueType::class,$langue);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $langue=$form->getData();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            $this->em->persist($langue);
            $this->em->flush();
        }
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'LangueController',
            'form' => $form->createView()
        ]);
    }
}
