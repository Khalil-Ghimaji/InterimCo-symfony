<?php

namespace App\Controller;

use App\Entity\Competences;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TarifController extends BaseController
{
    private $competencesRepo;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->competencesRepo = $doctrine->getRepository(Competences::class);
    }
    #[Route('/tarifs', name: 'app_tarif')]
    public function index(): Response
    {
        $competences = $this->competencesRepo->findAll();
        return $this->render('tarif/index.html.twig', [
            'competences' => $competences,
            'notifications'=> parent::getAllNotifications($this->doctrine)
        ]);
    }
}
