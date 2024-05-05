<?php
// src/Controller/ContratController.php

namespace App\Controller;

use App\Repository\CompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContratsRepository;
use App\Entity\Contrats; // Importez la classe Contrat
use App\Repository\PrestationsRepository;
use App\Entity\Prestations;


class PrestationController extends AbstractController
{
    #[Route('/traiter_prestation/{id}', name: 'traiter_prestation')]
    public function traiterPrestation($id, PrestationsRepository $prestationRepository,CompetencesRepository $competencesRepository)
    {
        // Ajoutez ici la logique pour traiter la prestation avec l'ID donné
        // Par exemple, récupérez la prestation à partir de son ID
//        $prestation = $prestationRepository->findById($id);
        $prestation = $prestationRepository->find($id);

        // Votre logique de traitement de prestation ici

        // Redirection vers une autre page ou affichage d'un message de succès

        return $this->render('traiter_prestation.html.twig', [
            'prestation' => $prestation,
            'competencesRepository' => $competencesRepository,
        ]);
    }
}
