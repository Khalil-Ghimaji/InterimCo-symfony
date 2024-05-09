<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetenceFilterType;
use App\Form\CompetenceFormType;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/new', name: 'app_competence_new')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competence = new Competences();
        $form = $this->createForm( CompetenceFormType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($competence);
            $entityManager->flush();
        }

        return $this->render('competence/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}