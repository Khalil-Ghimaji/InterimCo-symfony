<?php

namespace App\Controller;

use App\Entity\Contrats;
use App\Form\ContractFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\length;


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
    public function index(Request $request): Response
    {
        if ($request->request->has('formAction')) {
            $id = $request->request->get('contrat_id');
            $action = $request->request->get('formAction');
            if ($action === 'validate') {
                $this->validate($id);
            } elseif ($action === 'finalize') {
                $this->finalize($id);
            } elseif ($action === 'delete') {
                $this->delete($id);
            }
        }
        $contrats = $this->contractRepo->findBy(['client' => $this->getUser()]);
        return $this->render('contract/index.html.twig', [
            'contrats'=>$contrats,
        ]);
    }
    #[Route('/new',name:'ajout_contrat')]
    public function add(Request $request):Response
    {
        $contrat = new Contrats();
        $form_contrat = $this->createForm(contractFormType::class,$contrat);
        $form_contrat->handleRequest($request);
        if ($form_contrat->isSubmitted() && $form_contrat->isValid()) {
            foreach($contrat->getPrestations() as $prestation){
                $prestation
                    ->setPrix($prestation->getCompetence()->getPrixEstime()*$prestation->getDuree())
                    ->setPrixFinal($prestation->getPrix())
                    ->setDateDebFinale($prestation->getDateDebut())
                    ->setDateFinFinale($prestation->getDateFin());
                $this->manager->persist($prestation);
                $contrat->setPrix($contrat->getPrix()+$prestation->getPrix());
            }
            $contrat
                ->setPrixFinal($contrat->getPrix())
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
    #[Route('/details/{id}',name:'contract_details')]
    function details(int $id,Request $request):Response
    {
        $contract = $this->contractRepo->find($id);
        if ($contract->getEtatContrat()=="En attente de validation") {//le contrat n'est pas envoye. Il peut toujouts etre modifie
            $form = $this->createForm(ContractFormType::class, $contract);

            // Handle form submission
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $contract->setPrix(0);
                foreach($contract->getPrestations() as $prestation){
                    $prestation
                        ->setPrix($prestation->getCompetence()->getPrixEstime()*$prestation->getDuree())
                        ->setPrixFinal($prestation->getPrix())
                        ->setDateDebFinale($prestation->getDateDebut())
                        ->setDateFinFinale($prestation->getDateFin());
                    $this->manager->persist($prestation);
                    $contract->setPrix($contract->getPrix()+$prestation->getPrix());
                }
                $contract
                    ->setPrixFinal($contract->getPrix());
                $this->manager->persist($contract);
                $this->manager->flush();

                // Redirect to a success page or return a response
                return $this->redirectToRoute('app_contract');
            }

            // Render the form for editing
            return $this->render('contract/edit_contract.html.twig', [
                'contractForm' => $form->createView(),
                'existingContract' => $contract,
            ]);
        } elseif ($contract->getEtatContrat() == 'En cours de traitement'){ //le contrat a ete envoye mais n'a pas ete encore traite
            $form = $this->createForm(ContractFormType::class, $contract);
            $formView = $form->createView();
            $formView->children['libelle']->vars['attr']['disabled']='disabled';
//            dd($formView->children['prestations']->children);
            foreach ($formView->children['prestations']->children as $prestation) {
                foreach($prestation->children as $child) {
                    $child->vars['attr']['disabled'] = 'disabled';
                }
            }
            return $this->render('contract/sent_contract.html.twig', [
                'contractForm' => $formView,
                'existingContract' => $contract,
            ]);
        } else{//le contrat a ete traite
            return $this->render('contract/treated_contract.html.twig', [
                'existingContract' => $contract,
            ]);
        }
    }
    function delete(int $id): void
    {
        $contract = $this->contractRepo->find($id);
        $this->manager->remove($contract);
        $this->manager->flush();
    }
    function validate(int $id): void
    {
        $contract = $this->contractRepo->find($id);
        $contract
            ->setEtatContrat("En cours de traitement")
            ->setDateSoumission(new \DateTime());
        $this->manager->persist($contract);
        $this->manager->flush();

    }
    function finalize(int $id): void
    {
        $contract = $this->contractRepo->find($id);
        $contract->setEtatContrat("Finalisé");
        $this->manager->persist($contract);
        $this->manager->flush();
    }
}
