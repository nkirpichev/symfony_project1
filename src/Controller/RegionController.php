<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RegionRepository;
use App\Form\AddRegionType;
use App\Entity\Region;
use App\Entity\Visiteur;
use App\Entity\VisiteurRegion;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\RegionType;

class RegionController extends AbstractController
{
    #[Route('/region/{id<\d+>}', name: 'region')]
    public function index_id(RegionRepository $rp, $id, ManagerRegistry $doctrine): Response
    {
        $region = $rp->find($id);
        $vr = $region->getVisiteurRegions(); 
        $v = [];
        foreach ($vr as $visite){(string)
            $visiteurvisit = $visite->getVisiteur();
            $v[] =  array($visiteurvisit, $visite->getDateVisite()->format('Y/m/d'));// 
     
        }

        $visiteurs = $doctrine->getRepository(Visiteur::Class)->findAll();

        $form = $this->CreateFormBuilder()
            ->add('visiteurs', EntityType::Class,[ "label" => "Ajouter un visiteur", 'class'=>Visiteur::class,  'expanded'=>false])
//            ->add('visiteurs_id', ChoiceType::Class,[ 'choices' => $visiteurs , 'expanded'=>false])
            ->add('ajouter',SubmitType::Class)
            ->add('annuler',ResetType::Class)
            ->getForm();
         
            $request = Request::createFromGlobals();
        
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                $data = $form->getData();
                $v_add = $data["visiteurs"];
                $v_add = new VisiteurRegion;
                $v_add ->setVisiteur();
                $region->addVisiteurRegion($v_add);
                $rp->save($region, true);
                
                
                //return $this->render('region/apres_addUser.html.twig', [
                //    'data' => $v_add
                //]);
            }
    


        return $this->render('region/index1.html.twig', [
            'region' => $region,'visiteurs' => $v, 'form' => $form->createView()
        ]);
    }

    #[Route('/region/date/{id<\d+>}', name: 'region_date')]
    public function index_date(RegionRepository $rp, $id, ManagerRegistry $doctrine): Response
    {
        $r = $rp->find($id);
        $vr = $r->getVisiteurRegions();
        foreach ($vr as $visite){
            $v = $visite->getVisiteur(); 
        }
        
        $visiteurs = $doctrine->getRepository(Visiteur::Class)->findAll();

        $form = $this->CreateFormBuilder()
            ->add('visiteurs', EntityType::Class,[ "label" => "Ajouter un visiteur", 'class'=>Visiteur::class,  'expanded'=>false])
//            ->add('visiteurs_id', ChoiceType::Class,[ 'choices' => $visiteurs , 'expanded'=>false])
            ->add('ajouter',SubmitType::Class)
            ->add('annuler',ResetType::Class)
            ->getForm();
         
            $request = Request::createFromGlobals();
        
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                $data = $form->getData();
                $v_add = $data["visiteurs"];
                $r->addVisiteur($v_add);
                $rp->save($r, true);
                
                
                //return $this->render('region/apres_addUser.html.twig', [
                //    'data' => $v_add
                //]);
            }
    


        return $this->render('region/index1.html.twig', [
            'region' => $r,'visiteurs' => $v, 'form' => $form->createView()
        ]);
    }


    #[Route('/region/form', name: 'form_region')]
    public function index_form(): Response
    {
        
        $form = $this->CreateFormBuilder()
            ->add('libelle', TextType::Class)
            ->add('valider',SubmitType::Class)
            ->add('annuler',ResetType::Class)
            ->getForm();
        $request = Request::createFromGlobals();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();
            return $this->render('region/apres_add.html.twig', [
                'data' => $data
            ]);
        }

        return $this->render('region/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
       
    #[Route('/region/add', name: 'add_region')]
    public function index_add(RegionRepository $rp, Request $request): Response
    {
        
        $region = new Region();
        $form = $this->CreateFormBuilder($region)
            ->add('libelle', TextType::Class,array("label" => "Nom", "required" =>true))
            ->add('valider',SubmitType::Class)
            ->add('annuler',ResetType::Class)
            ->getForm();
        $form->handleRequest($request);    

        if($form->isSubmitted()){

            $rp->save($region, true);

            return $this->render('region/apres_add.html.twig', [
                'data' => $region
                ]);
        }
           
        return $this->render('region/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/region/del/{id<\d+>}', name: 'del_region')]
    public function index_del(RegionRepository $rp, Request $request, $id): Response
    {
        
        $r = $rp->find($id);
        $rp->remove($r, true);

        return $this->render('region/index.html.twig', [
            'regions' => $rp->findAll(),
        ]);
    }   
    #[Route('/region/edit/{id<\d+>}', name: 'edit_region')]
    public function index_edit(RegionRepository $rp, Request $request, $id): Response
    {
        
        $r = $rp->find($id);
        $form = $this->createForm(RegionType::class, $r);
        
        $form->handleRequest($request);    

        if($form->isSubmitted()){

            $rp->save($r, true);
            return $this->redirectToRoute('app_region');

        }

        return $this->render('region/edit.html.twig', [
            'form' => $form->createView()
        ]);
    } 
    
    
    #[Route('/region/{nom}', name: 'nom_region')]
    public function index_nom(RegionRepository $rp, $nom): Response
    {
        $r = $rp->findRegionByDQL($nom)[0];
        $v = $r->getVisiteurs();
        return $this->render('region/index1.html.twig', [
            'region' => $r,'visiteurs' => $v
        ]);
    } 
    
    
    #[Route('/region/all', name: 'all_region')]
    public function index_all(RegionRepository $rp): Response
    {
 
        return $this->render('region/index.html.twig', [
            'regions' => $rp->findRegionsByDQL()
        ]);
    }



    #[Route('/region', name: 'app_region')]
    public function index(RegionRepository $rp): Response
    {
        return $this->render('region/index.html.twig', [
            'regions' => $rp->findAll(),
        ]);
    }

        /**
         * Get the value of form
         */ 
        public function getForm()
        {
                return $this->form;
        }

        /**
         * Get the value of v
         */ 
        public function getV()
        {
                return $this->v;
        }

            /**
             * Set the value of r
             *
             * @return  self
             */ 
            public function setR($r)
            {
                        $this->r = $r;

                        return $this;
            }
}
