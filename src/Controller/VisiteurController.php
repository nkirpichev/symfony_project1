<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Visiteur;
use App\Entity\Region;
use App\Repository\VisiteurRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class VisiteurController extends AbstractController
{
    #[Route('/visiteur/{id<\d+>}', name: 'visiteur')]
    public function show_visiteur(ManagerRegistry $doctrine, $id): Response
    {
        
        $visteur = $doctrine->getRepository(Visiteur::Class)->find($id);
        $regions = $visteur->getRegions();
        //$region = $doctrine->getRepository(Region::Class)->find(2);
    
        if(!$visteur){
            return new Response ('not found');
        }

        /*$entityManager = $doctrine->getManager();
        $visteur->addRegions($region);
        $entityManager->persist($region);
        $entityManager->flush();*/

        $rep = $visteur->getNom().' '.$visteur->getPrenom().' tel - '.$visteur->getTel().'<br> Visite :';
        if($regions->isEmpty()){
            $rep = $rep.' no regions';
            
        }
        else {
            foreach($regions as $r) {
                $rep = $rep.'<br>'.' '.$r->getLibelle();
        
            }
        }

        return new Response ($rep);
    }
             
    #[Route('/visiteur/add', name: 'add_visiteur')]
    public function index_add(VisiteurRepository $v, Request $request, ValidatorInterface $validator): Response
    {
        
        $visiteur = new Visiteur();
        $form = $this->CreateFormBuilder($visiteur)
            ->add('nom', TextType::Class,array("label" => "Nom", "required" =>true))
            ->add('prenom', TextType::Class,array("label" => "Prenom", "required" =>true))
            ->add('tel', TextType::Class,array("label" => "E-mail", "required" =>true))
            //->add('e-mail', TextType::Class,array("label" => "E-mail", "required" =>true))

            ->add('valider',SubmitType::Class)
            ->add('annuler',ResetType::Class)
            ->getForm();
        $form->handleRequest($request);    

        if($form->isSubmitted()){

            $errors = $validator->validate($visiteur);
            if (count($errors) > 0 ) 
                return new Response($errors[0]->getMessage(),400);
              
                //echo $errors[0]->getMessage();
              


            $v->save($visiteur, true);

            return $this->render('visiteur/apres_add.html.twig', [
                'data' => $visiteur
                ]);
        }
           
        return $this->render('visiteur/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    
    #[Route('/visiteur/{ville}', name: 'visiteur_ville')]
    public function show_visiteurVille(ManagerRegistry $doctrine, $ville): Response
    {
        
        $region = $doctrine->getRepository(Region::Class)->findOneByNom($ville);
        if(!$region){
            return new Response ('Region not found');
        }
        
        $visteurs = $region->getVisiteurs();
    

        return $this->render('region/index1.html.twig', [
            'region' => $region,'visiteurs' => $visteurs
        ]);

     }

     #[Route('/visiteur/del/{id<\d+>}', name: 'del_visiteur')]
     public function index_del(VisiteurRepository $vr, Request $request, $id): Response
     {
     
        $v = $vr->find($id);
        $vr->remove($v, true);
        return $this->redirectToRoute('app_visiteur');  
    
    }


    #[Route('/visiteur', name: 'app_visiteur')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
        /*$entityManager = $doctrine->getManager();
        $visteur = new Visiteur;
        $visteur->setNom("Petrov");
        $visteur->setPrenom("Petr");
        $visteur->setTel("552231");
        $entityManager->persist($visteur);
        $entityManager->flush();*/

       /* $entityManager = $doctrine->getManager();
        $region = new Region;
        $region->setLibelle("Vanves");
        $entityManager->persist($region);
        $entityManager->flush();*/

       $visiteurs = $doctrine->getRepository(Visiteur::Class)->findAll();
        
        return $this->render('visiteur/index.html.twig', [
            'controller_name' => 'VisiteurController', 'visiteurs' => $visiteurs
        ]);
    }
}
