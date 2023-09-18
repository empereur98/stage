<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Cours;
use App\Entity\Exercice;
use App\Entity\Region;
use App\Entity\User;
use App\Entity\Vocabulaire;
use App\Enum\NiveauEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/langue/{id}-{slug}',name:'show_langue',methods:'GET')]
    public function show_langue($id):Response{

        return $this->render('langue/langue.html.twig',[

        ]);
    }
    #[Route('/cours/{langue}-{niveau}',name:'app_cours',methods:'GET')]
    public function facile($niveau,$langue):Response{
        if($niveau==='FACILE'){
            $cours=$this->em->getRepository(Cours::class)->findBy(['niveau'=>NiveauEnum::FACILE,'langue'=>$langue]);  
        }
        elseif ($niveau=='DIFFICILE') {
            $cours=$this->em->getRepository(Cours::class)->findBy(['niveau'=>NiveauEnum::DIFFICILE]);
            dump($cours);
            $resultat=$cours;
        }
       return $this->render('cours/index.html.twig',[
        'cours'=>$cours
       ]);
    }
    #[Route('/cours/{niveau}/{id}-{slug}',name:'show_lesson',methods:'GET')]
    public function show_cours($id,$slug):Response{
        $user=new User();
        $user=$this->getUser();
        dump($user);
        $lesson=$this->em->getRepository(Vocabulaire::class)->findBy(['lesson'=>$id]);
        dump($lesson,$id);
       return $this->render('cours/showcours.html.twig',[
        'lessons'=>$lesson,
        'slug'=>$slug,
        'id'=>$id
       ]);
    }
    #[Route('/exercice/{id}',name:'show_exercice')]
    public function exercice($id):Response{
        $exercice=$this->em->getRepository(Exercice::class)->findBy(['cours'=>$id]);
        dump($exercice);
        return $this->render('exercice/exercice.html.twig',[
         'exercice'=>$exercice
        ]);
    }
    #[Route('/niveau/{id}-{langue}',name:'niveau')]
    public function niveau(Request $request,$id):Response{
        $session=$request->getSession();
        $session->set('niveau','FACILE');
        dump($this->getUser(),$session->get('niveau'));
        return $this->render('slide/niveau.html.twig',[
            'controller'=>'la page des langues',
            'id'=>$id
        ]);
    }
}
