<?php
namespace App\Controller\Admin;

use App\Entity\Region;
use App\Form\RegionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRegionController extends AbstractController{
    public $em;
    public function __construct(EntityManagerInterface $em){
       $this->em=$em;
    }
    #[Route(path:'/admin/newregion', name:'new_region')]
     public function add(Request $request):Response{
        $region=new Region();
        $form=$this->createForm(RegionType::class,$region);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $region=$form->getData();
            $this->em->persist($region);
            $this->em->flush();
        }
        return $this->render('admin/region.html.twig',[
            'controller_name'=>'AdminRegionController',
           'form'=>$form->createView()
        ]);
     }
}