<?php
// src/Controller/ContratController.php

namespace App\Controller;

use App\Repository\CompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContratsRepository;
use App\Entity\Contrats; // Importez la classe Contrat

class ContratController extends AbstractController
{

    #[Route('/contrats/{etat}', name: 'afficher_contrats')]
    public function afficherContrats($etat, ContratsRepository $contratsRepository)
    {
        // Récupérer les contrats en fonction de l'état depuis le repository
        $contrats = $contratsRepository->findByEtat($etat);

        return $this->render('afficher_contrats.html.twig', [
            'contrats' => $contrats,
            'etat' => $etat,
        ]);
    }

    #[Route('/traiter_contrat/{id}', name: 'traiter_contrat')]
    public function traiterContrat($id,ContratsRepository $contratsRepository,CompetencesRepository $competencesRepository)
    {
        // Ajoutez ici la logique pour traiter le contrat avec l'ID donné
        // Par exemple, récupérez le contrat à partir de son ID
        $contrat = $contratsRepository->findById($id);


        return $this->render('traiter_contrat.html.twig', [
            'contrat' => $contrat,
            'competencesRepository' => $competencesRepository,

        ]);
    }
//    #[Route('/contrat/{id}', name: 'afficher_contrat')]
//    public function afficherContrat($id, ContratsRepository $contratsRepository,CompetencesRepository $competencesRepository)
//    {
//        $contrat = $contratsRepository->findById($id);
//
//        if (!$contrat) {
//            throw $this->createNotFoundException('Contrat non trouvé pour l\'ID ' . $id);
//        }
//
//        // Récupérer les prestations associées au contrat
//        $prestations = $contrat->getPrestations();
//
//        return $this->render('afficher_contrat.html.twig', [
//            'contrat' => $contrat,
//            'prestations' => $prestations,
//        ]);
//    }

}
