<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientArticleController extends AbstractController
{
    #[Route('/clientarticle', name: 'app_client_article')]
    public function index(): Response
    {
        return $this->render('client_article/index.html.twig', [
            'controller_name' => 'ClientArticleController',
        ]);
    }
}
