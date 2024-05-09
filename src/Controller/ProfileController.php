<?php

namespace App\Controller;

use App\Entity\Agentsdrh;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'profile')]
    public function index(Request $request): Response
    {
        $username = $request->getSession()->get('_security.last_username');
        $agentDrh = $this->entityManager->getRepository(Agentsdrh::class)->findOneBy(['username' => $username]);

        if (!$agentDrh) {
            throw $this->createNotFoundException('Agent DRH non trouvé pour le nom d\'utilisateur ' . $username);
        }

        return $this->render('profil.html.twig', [
            'agentDrh' => $agentDrh,
        ]);
    }
}
