<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Modele\Artisan;


class ArtisanController extends AbstractController
{
    #[Route('/artisan', name: 'app_artisan')]
    public function index(): Response
    {
        $arrArtisan = array(
            new Artisan("Hugo","Victor","ecrivain"),
            new Artisan("Nik","Ivanov","tester"),
            new Artisan("Uriy","Gagarin","cosmonaute"),
        );

        $arrStag = array();
        
        return $this->render('artisan/index.html.twig', [
            'controller_name' => 'ArtisanController', 'arrArtisan' => $arrArtisan,
            'arrStag' => $arrStag
        ]);
    }
}
