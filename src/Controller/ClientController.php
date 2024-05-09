<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFilterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/clients')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $repository = $doctrine->getRepository(Clients::class);
        $qb = $repository->createQueryBuilder('c');
        $clientFilter = new Clients();
        $clientFilterForm = $this->createForm(ClientFilterType::class,$clientFilter);
        $clientFilterForm->handleRequest($request);
        if ($clientFilterForm->isSubmitted() && $clientFilterForm->isValid()) {
            $formData = $clientFilterForm->getData();
            // Use query builder to construct the query
            if ($formData->getUsername()) {
                $qb->andWhere('c.username LIKE :username')
                    ->setParameter('username', $formData->getUsername());
            }
            if ($formData->getNom()) {
                $qb->andWhere('c.nom LIKE :nom')
                    ->setParameter('nom', $formData->getNom());
            }
            if ($formData->getLocale()) {
                $qb->andWhere('c.locale LIKE :locale')
                    ->setParameter('locale', $formData->getLocale());
            }
            if ($formData->getNumeroTelephone()){
                $qb->andWhere('c.numeroTelephone LIKE :numeroTelephone')
                    ->setParameter('numeroTelephone', $formData->getNumeroTelephone());
            }

            if ($formData->getEmail()){
                $qb->andWhere('c.email LIKE :email')
                    ->setParameter('email', $formData->getEmail());
            }
        }
        $clients = $qb->getQuery()->getResult();
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'filter' => $clientFilterForm->createView(),
        ]);
    }
}