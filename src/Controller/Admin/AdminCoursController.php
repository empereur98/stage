<?php

namespace App\Controller\Admin;

use App\Entity\Cours;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminCoursController extends AbstractController
{
    #[Route('admin/newcours', name: 'new_cours')]
    public function index(Request $request): Response
    {
        $cours=new Cours();
        $formcours=$this->createForm(CoursType::class,$cours);
        $formcours->handleRequest($request);
        if ($formcours->isSubmitted() && $formcours->isValid()  ) {
           // $cours=$formcours->getData();
            dump($formcours);
            die;
        }
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
            'form'=>$formcours->createView()
        ]);
    }
}
