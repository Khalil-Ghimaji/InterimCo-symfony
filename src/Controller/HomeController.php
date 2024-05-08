<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    #[Route('/home', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $authenticatedUser=$this->getUser();
        return $this->render('home/index.html.twig', [
            'authenticatedUser'=>$authenticatedUser,
            'notifications'=> parent::getAllNotifications($doctrine)
        ]);
    }
}
