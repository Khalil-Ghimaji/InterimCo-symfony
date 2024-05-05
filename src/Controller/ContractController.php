<?php

namespace App\Controller;

use App\Entity\Contrats;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/contract'), ]

class ContractController extends AbstractController
{
    private $contractRepo;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->contractRepo=$doctrine->getRepository(Contrats::class);
    }
    #[Route('/', name: 'app_contract')]
    public function index(): Response
    {
        $contrats = $this->contractRepo->findBy(['client' => $this->getUser()]);
        return $this->render('contract/index.html.twig', [
            'contrats'=>$contrats,
        ]);
    }

}
