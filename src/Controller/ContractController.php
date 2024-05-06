<?php

namespace App\Controller;

use App\Entity\Contrats;
use App\Form\ContractFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/contract'), ]

class ContractController extends AbstractController
{
    private $contractRepo;
    private $manager;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->contractRepo=$doctrine->getRepository(Contrats::class);
        $this->manager = $this->doctrine->getManager();
    }
    #[Route('/', name: 'app_contract')]
    public function index(): Response
    {
        $contrats = $this->contractRepo->findBy(['client' => $this->getUser()]);
        return $this->render('contract/index.html.twig', [
            'contrats'=>$contrats,
        ]);
    }
    #[Route('/new',name:'ajout_contrat')]
    public function add(Request $request){
        $contrat = new Contrats();
        $form_contrat = $this->createForm(contractFormType::class,$contrat);
        $form_contrat->handleRequest($request);
        if ($form_contrat->isSubmitted() && $form_contrat->isValid()) {
            foreach($contrat->getPrestations()as $prestation){
                $prestation->setPrix($prestation->getCompetence()->getPrixEstime()*$prestation->getDuree());
                $this->manager->persist($prestation);
                $contrat->setPrix($contrat->getPrix()+$prestation->getPrix());
            }
            $contrat
                ->setClient($this->getUser())
                ->setEtatContrat("En attente de validation");
            $this->manager->persist($contrat);
            $this->manager->flush();
            return $this->redirectToRoute('app_contract');
        }

        return $this->render('contract/new_contract.html.twig', [
            'contractForm' => $form_contrat->createView(),
        ]);


    }
}
