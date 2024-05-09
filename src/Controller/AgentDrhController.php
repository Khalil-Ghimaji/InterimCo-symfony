<?php

namespace App\Controller;

use App\Entity\AgentsDrh;
use App\Form\AgentDrhFilterType;
use App\Form\AgentDrhFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


#[Route('/agentdrh'),isGranted('ROLE_USER')]
class AgentDrhController extends AbstractController
{
    #[Route('/delete/{id}', name: 'app_agent_drh_delete')]
    public function delete(AgentsDrh $agent = null, ManagerRegistry $doctrine):RedirectResponse{
        if($agent){
            $manager = $doctrine->getManager();
            $manager->remove($agent);
            $manager->flush();
            $this->addFlash('success','L\'agent DRH a été supprimé avec succès');
        }
        else{
            $this->addFlash('error','Agent DRH inexistant');
        }
        return $this->redirectToRoute('app_agent_drh');
    }
    #[Route('/', name: 'app_agent_drh')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $repository = $doctrine->getRepository(AgentsDrh::class);
        $qb = $repository->createQueryBuilder('ag');
        $agentDrhFilter = new AgentsDrh();
        $agentDrhFilterForm = $this->createForm(AgentDrhFilterType::class,$agentDrhFilter);
        $agentDrhFilterForm->handleRequest($request);
        if ($agentDrhFilterForm->isSubmitted() && $agentDrhFilterForm->isValid()) {
            $formData = $agentDrhFilterForm->getData();
            // Use query builder to construct the query
            if ($formData->getUsername()) {
                $qb->andWhere('ag.username LIKE :username')
                    ->setParameter('username', $formData->getUsername());
            }
            if ($formData->getNom()) {
                $qb->andWhere('ag.nom LIKE :nom')
                    ->setParameter('nom', $formData->getNom());
            }
            if ($formData->getPrenom()) {
                $qb->andWhere('ag.prenom LIKE :prenom')
                    ->setParameter('prenom', $formData->getPrenom());
            }
            if ($formData->getNumeroTelephone()){
                $qb->andWhere('ag.numeroTelephone LIKE :numeroTelephone')
                    ->setParameter('numeroTelephone', $formData->getNumeroTelephone());
            }

            if ($formData->getEmail()){
                $qb->andWhere('ag.email LIKE :email')
                    ->setParameter('email', $formData->getEmail());
            }
        }
        $agents = $qb->getQuery()->getResult();
        return $this->render('agent_drh/index.html.twig', [
            'agents' => $agents,
            'filter' => $agentDrhFilterForm->createView(),
        ]);
    }
    #[Route('/new', name: 'app_agent_drh_new')]
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, EntityManagerInterface $entityManager): Response
    {
        $agentdrh = new AgentsDrh();
        $form = $this->createForm( AgentDrhFormType::class, $agentdrh);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $agentdrh->setPassword(
                $userPasswordHasher->hashPassword(
                    $agentdrh,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($agentdrh);
            $entityManager->flush();
            $this->addFlash('succes','Agent DRH ajouté avec succès');
            return $this->redirectToRoute('app_agent_drh');
        }

        return $this->render('agent_drh/new.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
