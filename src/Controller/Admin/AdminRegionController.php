<?php
namespace App\Controller\Admin;

use App\Entity\Cours;
use App\Entity\Exercice;
use App\Entity\Langue;
use App\Entity\Region;
use App\Entity\User;
use App\Entity\Vocabulaire;
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
    #[Route('/admin',name:'admin')]
    public function admin(Request $request):Response{
      $regions=$this->em->getRepository(Region::class)->findAll();
      $langues=$this->em->getRepository(Langue::class)->findAll();
      $cours=$this->em->getRepository(Cours::class)->findAll();
      $exercices=$this->em->getRepository(Exercice::class)->findAll();
      $users=$this->em->getRepository(User::class)->findByRole('["ROLE_ADMIN"]');
      $vocabulaires=$this->em->getRepository(Vocabulaire::class)->findAll();
       return $this->render('admin/index.html.twig',[
           'regions'=>$regions,
           'langues'=>$langues,
           'cours'=>$cours,
           'exercices'=>$exercices,
           'usersadmin'=>$users,
           'mots'=>$vocabulaires
       ]);
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
            $this->addFlash('success','votre region a ete modifier');
            return  $this->redirectToRoute('admin');
        }
        return $this->render('admin/region.html.twig',[
            'controller_name'=>'AdminRegionController',
           'form'=>$form->createView()
        ]);
     }
     #[Route('/admin/region/edit/{id}', name:'edit_region')]
     public function editRegion(Region $region,Request $request):Response{
      $form=$this->createForm(RegionType::class,$region);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $this->em->flush();
         $this->addFlash('success','modification reussie');
         return $this->redirectToRoute('admin');
      }
      return $this->render('admin/edit-region.html.twig',[
        'form'=>$form->createView()
      ]);
     }

     #[Route('/admin/delete/{id}',name:'delete',methods:'DELETE|POST')]
     public function delete(Region $region): Response
     {
       $local=$this->em->getRepository(Region::class);
       $local->delete($region);
       $this->addFlash('success','region supprimer avec succes');
        return $this->redirectToRoute('admin');
        return new Response($this->render('pages/admin.html.twig',[
         'region'=>$region
     ]));
     }
}