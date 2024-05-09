<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Entity\Employes;
use App\Form\EmployeFilterType;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/employes'),isGranted('ROLE_USER')]
class EmployeController extends AbstractController
{
    #[Route('/delete/{id}', name: 'app_employe_delete')]
    public function delete(Employes $employe = null, ManagerRegistry $doctrine):RedirectResponse{
        if($employe){
            $manager = $doctrine->getManager();
            $manager->remove($employe);
            $manager->flush();
            $this->addFlash('success','L\'employé a été supprimé avec succès');
        }
        else{
            $this->addFlash('error','Employé inexistant');
        }
        return $this->redirectToRoute('app_employe');
    }
    #[Route('/', name: 'app_employe')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $repository = $doctrine->getRepository(Employes::class);
        $qb = $repository->createQueryBuilder('c');
        $employeFilter = new Employes();

        //dd($competencesArray);
        $employeFilterForm = $this->createForm(EmployeFilterType::class,$employeFilter);
        $employeFilterForm->handleRequest($request);
        if ($employeFilterForm->isSubmitted() && $employeFilterForm->isValid()) {
            $formData = $employeFilterForm->getData();
            // Use query builder to construct the query
            if ($formData->getNom()) {
                $qb->andWhere('c.nom LIKE :nom')
                    ->setParameter('nom', $formData->getNom());
            }
            if ($formData->getPrenom()) {
                $qb->andWhere('c.prenom LIKE :prenom')
                    ->setParameter('prenom', $formData->getPrenom());
            }
            if ($formData->getNumeroTelephone()) {
                $qb->andWhere('c.numeroTelephone = :numeroTelephone')
                    ->setParameter('numeroTelephone', $formData->getNumeroTelephone());
            }
            if ($formData->getEmail()) {
                $qb->andWhere('c.email = :email')
                    ->setParameter('email', $formData->getEmail());
            }
        }
        $employes = $qb->getQuery()->getResult();
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
            'filter' => $employeFilterForm->createView(),
        ]);
    }

    #[Route('/new', name: 'app_employe_new')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employe = new Employes();
        $form = $this->createForm( EmployeFormType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employe);
            $entityManager->flush();
            $this->addFlash('success','Employé ajouté avec succès');
        }
        return $this->render('employe/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
