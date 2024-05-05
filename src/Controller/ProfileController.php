<?php

namespace App\Controller;

use App\Entity\Agentsdrh;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; // Assurez-vous d'inclure cette directive use

class ProfileController extends AbstractController
{
    private $entityManager; // EntityManagerInterface

    // Injection de dépendance pour l'EntityManager
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'profile')]
    public function index(Request $request): Response
    {
        // Récupérer le nom d'utilisateur depuis _security.last_username
        $username = $request->getSession()->get('_security.last_username');

        // Récupérer l'agent DRH correspondant depuis la base de données
        $agentDrh = $this->entityManager->getRepository(Agentsdrh::class)->findOneBy(['username' => $username]);

        // Vérifier si l'agent DRH existe
        if (!$agentDrh) {
            throw $this->createNotFoundException('Agent DRH non trouvé pour le nom d\'utilisateur ' . $username);
        }

        // Passer les données de l'agent DRH au template Twig
        return $this->render('profil.html.twig', [
            'agentDrh' => $agentDrh,
        ]);
    }
}
