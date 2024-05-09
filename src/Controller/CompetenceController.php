<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetenceFilterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/competences'),isGranted('ROLE_USER')]
class CompetenceController extends AbstractController
{
    #[Route('/', name: 'app_competence')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $repository = $doctrine->getRepository(Competences::class);
        $qb = $repository->createQueryBuilder('c');
        $competenceFilter = new Competences();
        $competenceFilterForm = $this->createForm(CompetenceFilterType::class,$competenceFilter);
        $competenceFilterForm->handleRequest($request);
        if ($competenceFilterForm->isSubmitted() && $competenceFilterForm->isValid()) {
            $formData = $competenceFilterForm->getData();
            // Use query builder to construct the query
            if ($formData->getCompetence()) {
                $qb->andWhere('c.competence LIKE :competence')
                    ->setParameter('competence', $formData->getCompetence());
            }
            if ($formData->getNiveauCompetence()) {
                $qb->andWhere('c.niveauCompetence = :niveauCompetence')
                    ->setParameter('niveauCompetence', $formData->getNiveauCompetence());
            }
            if ($formData->getPrixEstime()) {
                $qb->andWhere('c.prixEstime >= :prixEstime')
                    ->setParameter('prixEstime', $formData->getPrixEstime());
            }

        }
        $competences = $qb->getQuery()->getResult();
        return $this->render('competence/index.html.twig', [
            'competences' => $competences,
            'filter' => $competenceFilterForm->createView(),
        ]);
    }
}