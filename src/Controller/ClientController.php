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
    #[Route('/all', name: 'app_client')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
//        $repository = $doctrine->getRepository(Clients::class);
//        $qb = $repository->createQueryBuilder('c');
//        $clientFilter = new Clients();
//        $clientFilterForm = $this->createForm(ClientFilterType::class,$clientFilter);
//        $clientFilterForm->handleRequest($request);
//        if ($clientFilterForm->isSubmitted() && $clientFilterForm->isValid()) {
//                $formData = $clientFilterForm->getData();
//                // Use query builder to construct the query
//                if ($formData->getNomUtilisateur()) {
//                    $qb->andWhere('c.nomUtilisateur = :username')
//                        ->setParameter('username', $formData->getNomUtilisateur());
//                }
//                if ($formData->getNom()) {
//                    $qb->andWhere('c.nom = :nom')
//                        ->setParameter('nom', $formData->getNom());
//                }
//                if ($formData->getLocale()) {
//                    $qb->andWhere('c.locale = :locale')
//                        ->setParameter('locale', $formData->getLocale());
//                }
//        }
//        $clients = $qb->getQuery()->getResult();
//        $temp =$clients;
        //dd($request->request->has('nomUtilisateur'));
//        if($request->request->has('nomUtilisateur')) {
//            return $this->render('home/index.html.twig/');
//            dd('hello');
//        }
//        if($clientFilterForm->isSubmitted()){dd($clients);}
        return $this->render('client/index.html.twig', [
                'clients' => [],
        ]);
    }
}
