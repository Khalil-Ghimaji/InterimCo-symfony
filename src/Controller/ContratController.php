<?php
// src/Controller/ContratController.php

namespace App\Controller;

use App\Repository\CompetencesRepository;
use App\Service\PdfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContratsRepository;
use App\Entity\Contrats;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// Importez la classe Contrat

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
        // Ajoutez ici la logique pour traiter le contrat.html.twig avec l'ID donné
        // Par exemple, récupérez le contrat.html.twig à partir de son ID
        $contrat = $contratsRepository->findById($id);


        return $this->render('traiter_contrat.html.twig', [
            'contrat' => $contrat,
            'competencesRepository' => $competencesRepository,

        ]);
    }
//    #[Route('/contrat.html.twig/{id}', name: 'afficher_contrat')]
//    public function afficherContrat($id, ContratsRepository $contratsRepository,CompetencesRepository $competencesRepository)
//    {
//        $contrat.html.twig = $contratsRepository->findById($id);
//
//        if (!$contrat.html.twig) {
//            throw $this->createNotFoundException('Contrat non trouvé pour l\'ID ' . $id);
//        }
//
//        // Récupérer les prestations associées au contrat.html.twig
//        $prestations = $contrat.html.twig->getPrestations();
//
//        return $this->render('afficher_contrat.html.twig', [
//            'contrat.html.twig' => $contrat.html.twig,
//            'prestations' => $prestations,
//        ]);
//    }

//    #[Route('/contrat/pdf/{id}', name: 'contrat_pdf')]
//    public function contratToPdf($id, ContratsRepository $contratsRepository, PdfService $pdfService)
//    {
//        // Récupérer le contrat depuis l'ID
//        $contrat = $contratsRepository->find($id);
//
//        // Vérifier si le contrat existe
//        if (!$contrat) {
//            throw $this->createNotFoundException('Contrat non trouvé pour l\'ID ' . $id);
//        }
//
//        // Générer le contenu HTML du contrat (vous devrez créer le template Twig correspondant)
//        $htmlContent = $this->renderView('contrat.html.twig', [
//            'contrat' => $contrat,
//        ]);
//
//        // Générer le PDF à partir du contenu HTML
//        $pdfContent = $pdfService->generateBinaryPDF($htmlContent);
//
//        // Créer une réponse avec le contenu PDF
//        $response = new Response($pdfContent);
//
//        // Définir les en-têtes pour indiquer au navigateur que le fichier est un PDF à télécharger
//        $response->headers->set('Content-Type', 'application/pdf');
//        $response->headers->set('Content-Disposition', 'attachment; filename="contrat.pdf"');
//
//        return $response;
//    }
    #[Route('/contrat/pdf/{id}', name: 'contrat_pdf')]
    public function generatePdfPersonne($id,PdfService $pdf,ContratsRepository $contratsRepository): Response
    {
        $contrat = $contratsRepository->find($id);

        // Rendu de la vue Twig et récupération du contenu HTML
        $html = $this->renderView('contrat.html.twig', ['contrat' => $contrat]);

        // Génération du PDF à partir du contenu HTML
        $pdf->showPdfFile($html);

        // Retourner une réponse vide, car showPdfFile() affiche directement le PDF
        return new Response();
    }
    #[Route('/contrat_succes/{id}', name: 'succes_contrat')]
    public function succees_contrat($id){

    }
    #[Route('/contrat_echec/{id}', name: 'echec_contrat')]
    public function echec_contrat($id){

    }
}








