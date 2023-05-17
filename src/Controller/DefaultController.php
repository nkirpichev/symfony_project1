<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MyService;

class DefaultController extends AbstractController
{
    #[Route('/default/', name: 'app_default')]
    
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
         ]);
    }
 
    #[Route('/default/{par1}/{par2}', name: 'app_default1')]
     public function index1($par1, $par2): Response
    {
        $srv = new MyService;
        return $this->render('default/index1.html.twig', [
            'controller_name' => 'DefaultController','par1' => $par1, 'par2' => $srv -> msg2()
         ]);
    }

    #[Route('/default/clients/', name: 'clients')]
    public function indexroute()
    {
        return $this->redirectToRoute("app_client_article");
    }
   
    #[Route('/default/srv/', name: 'srv')]
    public function new (MyService $srv): Response  ///
    {
       
        $msg = $srv -> msg();
        $msg2 = $srv -> msg2();
        $msg2 = $srv -> get_m();
        return $this->render('default/index1.html.twig', [
            'controller_name' => 'DefaultController', 'par1' => $msg, 'par2' => $msg2
         ]);
    }


}
