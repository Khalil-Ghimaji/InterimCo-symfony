<?php
// src/Controller/ContratController.php

namespace App\Controller;
use App\Entity\Employes;
use App\Repository\CompetencesRepository;
use App\Repository\EmployesRepository;
use App\Service\EmployesAdequatsService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContratsRepository;
use App\Entity\Contrats;
use App\Repository\PrestationsRepository;
use App\Entity\Prestations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PrestationController extends AbstractController
{
    #[Route('/traiter_prestation/{id}', name: 'traiter_prestation')]
    public function traiterPrestation($id, PrestationsRepository $prestationRepository,EmployesAdequatsService $adequatsService)
    {

        $prestation = $prestationRepository->find($id);
        $id_competence = $prestation->getCompetence()->getId();

        $employes_adequats = $adequatsService->getEmployesAdequats($id);

        return $this->render('traiter_prestation.html.twig', [
            'prestation' => $prestation,
            'employes_adequats' => $employes_adequats,
        ]);
    }


    #[Route('/supprimer_employe/{id}/{id_prestation}', name: 'supprimer_employe')]
    public function supprimerEmploye($id, $id_prestation, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Récupérer l'employé et la prestation concernés
        $employe = $entityManager->getRepository(Employes::class)->find($id);
        $prestation = $entityManager->getRepository(Prestations::class)->find($id_prestation);

        // Supprimer l'employé de la prestation
        $prestation->removeEmploye($employe);

        // Mettre à jour la base de données
        $entityManager->flush();

        // Redirection vers la route 'traiter_prestation' avec l'ID de la prestation
        return $this->redirectToRoute('traiter_prestation', ['id' => $id_prestation]);
    }

    #[Route('/ajouter_employe/{id}/{id_prestation}', name: 'ajouter_employe')]
    public function ajouterEmploye($id, $id_prestation, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Récupérer l'employé et la prestation concernés
        $employe = $entityManager->getRepository(Employes::class)->find($id);
        $prestation = $entityManager->getRepository(Prestations::class)->find($id_prestation);


        // Ajouter l'employé à la prestation
        $prestation->addEmploye($employe);

        // Mettre à jour la base de données
        $entityManager->flush();

        // Redirection vers la route 'traiter_prestation' avec l'ID de la prestation
        return $this->redirectToRoute('traiter_prestation', ['id' => $id_prestation]);
    }
    #[Route('/test/{id}',name:'test')]
    public function test($id)
    {
        return $this->render('test.twig',['dateDebut'=>$id]);
    }
    #[Route('/valider_prestation', name: 'valider_prestation')]
    public function validerPrestation(Request $request, PrestationsRepository $prestationsRepository, EntityManagerInterface $entityManager): Response
    {
        $prestationId = $request->request->get('idPrestation');
        $dateDebut = $request->request->get('nouvelleDateDebut');
        $prestation = $prestationsRepository->find($prestationId);


        // Vérifier si la date de début est définie
        if ($dateDebut !== "") {

            $duree = $prestation->getDuree();

            $dateDebutObj = new \DateTime($dateDebut);

            $dateFinObj = clone $dateDebutObj;
            $dateFinObj->modify('+' . ($duree-1) . ' days');
            $dateFin = $dateFinObj->format('Y-m-d');

            $prestation->setDateDebut($dateDebutObj);
            $prestation->setDateFin($dateFinObj);

            $entityManager->flush();
        }


        return $this->redirectToRoute('traiter_contrat', ['id' => $prestation->getContrat()->getId()]);
    }

}
