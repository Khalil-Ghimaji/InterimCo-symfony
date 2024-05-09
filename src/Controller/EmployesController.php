<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/employes')]
class EmployesController extends AbstractController
{
    #[Route('/', name: 'app_employe')]
    public function index(): Response
    {
        $te = rand(0,10);
        return $this->render('employes/index.html.twig', [
            'te' => $te,
            'controller_name' => 'EmployesController',
        ]);
    }
}
