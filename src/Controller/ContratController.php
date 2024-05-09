<?php

namespace App\Controller;

use App\Entity\Contrats;
use App\Form\ContractFilterType;
use App\Form\ContratFilterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contrats'),isGranted('ROLE_USER')]
class ContratController extends AbstractController
{
    #[Route('/', name: 'app_contract')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $repository = $doctrine->getRepository(Contrats::class);
        $qb = $repository->createQueryBuilder('c');
        $contractFilter = new Contrats();
        $contractFilterForm = $this->createForm(ContratFilterType::class, $contractFilter);
        $contractFilterForm->handleRequest($request);
        if ($contractFilterForm->isSubmitted() && $contractFilterForm->isValid()) {
            $formData = $contractFilterForm->getData();
            // Use query builder to construct the query
            if ($formData->getLibelle()) {
                $qb->andWhere('c.libelle LIKE :libelle')
                    ->setParameter('libelle', '%'.$formData->getLibelle().'%');
            }
            if ($formData->getDateSoumission()) {
                $qb->andWhere('c.dateSoumission = :dateSoumission')
                    ->setParameter('dateSoumission', $formData->getDateSoumission());
            }
            if ($formData->getDateReponse()) {
                $qb->andWhere('c.dateReponse = :dateReponse')
                    ->setParameter('dateReponse', $formData->getDateReponse());
            }
            if ($formData->getEtatContrat()) {
                $qb->andWhere('c.etatContrat = :etatContrat')
                    ->setParameter('etatContrat', $formData->getEtatContrat());
            }
            if ($formData->getPrix()) {
                $qb->andWhere('c.prix = :prix')
                    ->setParameter('prix', $formData->getPrix());
            }

        }
        $contracts = $qb->getQuery()->getResult();
        return $this->render('contrat/index.html.twig', [
            'contrats' => $contracts,
            'filter' => $contractFilterForm->createView(),
        ]);
    }
}
