<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Cours;
use App\Entity\Exercice;
use App\Entity\Exercicesearch;
use App\Entity\Region;
use App\Entity\User;
use App\Entity\Vocabulaire;
use App\Enum\NiveauEnum;
use App\Form\ExercicesearchType;
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
        $post=[];
        $score=0;
        $point=0;
        $cours=null;
        $exemple=$this->em->getRepository(Exercice::class)->findOneBy(['cours'=>$id]);
        $cours=$exemple->getCours();
        $courssuivant=$this->em->getRepository(Cours::class)->findBy(['id'=>$cours->getID()+1,'langue'=>$cours->getLangue()]);
        dump($courssuivant);
        $exercices=$this->em->getRepository(Exercice::class)->findBy(['cours'=>$id]);
        $user=$this->em->getRepository(User::class)->findOneBy(['email'=>$this->getUser()->getUserIdentifier()]);
        foreach ($exercices as $key=>$exercice) {
            $cours=$exercice->getCours();
        if (isset($_POST['options'.$key])) {
            $post[]=$_POST['options'.$key];
        if ($exercice->getReponse()===$post[$key]) {
            $score=$user->getScore();
            $point+=3;
            $score+=$point;
            $user->setScore($score);
           // $this->em->flush();
            $this->addFlash('success','bonne reponse');
        }else{
            $this->addFlash('danger','mauvaise reponse');
        }
        }
    }
        //$tab=$exercice->getChoixDeReponse();
        dump($exercices,$user,$post);
        return $this->render('exercice/exercice.html.twig',[
         'id'=>$id,
         'exercices'=>$exercices,
         'scores'=>$point,
         'cours'=>$courssuivant
        ]);
    }
    #[Route('/do',name:'do_exercice')]
      public function doexercice():Response{
        
         return $this->render('exercice/exercice1.html.twig',[

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
