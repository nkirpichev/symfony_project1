<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Visiteur;
use App\Entity\RapportVisite;
use App\Entity\RapportMedicament;
use App\Entity\Medicament;

class RapportController extends AbstractController
{
    #[Route('/rapport', name: 'app_rapport')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
       /* $entityManager = $doctrine->getManager();
        $rapport = new RapportVisite;
        $visteur = $doctrine->getRepository(Visiteur::Class)->find(1);
        $rapport->setDateVisite(new \DateTime());
        $rapport->setVisiteur($visteur);
        $entityManager->persist($rapport);
        
        $med = new Medicament;
        $med->setNom("aspirin");
        $entityManager->persist($med);

        $med1 = new Medicament;
        $med1->setNom("doliprene");
        $entityManager->persist($med1);
  
        $rap_med = new RapportMedicament;
        $rap_med ->setRapportvisite($rapport);
        $rap_med ->setMedicaments($med);
        $rap_med ->setNombre(5);        
        $entityManager->persist($rap_med);
        
        $rap_med = new RapportMedicament;
        $rap_med ->setRapportvisite($rapport);
        $rap_med ->setMedicaments($med1);
        $rap_med ->setNombre(15);        
        $entityManager->persist($rap_med);

        $entityManager->flush();*/
        $rep = "";
        $rap = $this->getDoctrine()->getRepository(RapportMedicament::Class)->findAll();
        foreach ($rap as $r){
        
            $visite = $r->getRapportvisite();
            $v = $visite->getVisiteur();
            $m = $r->getMedicaments();   
            $rep = $rep.$visite->getId()." - ".$v->getNom()." ".$visite->getDateVisite()->format('d.m.Y')." ".$m->getNom()." - ".$r->getNombre()."<br>";
        }
        return new Response ($rep);
    }
}
