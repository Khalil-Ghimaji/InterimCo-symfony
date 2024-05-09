<?php

namespace App\Controller;

use App\Entity\Notifications;
use App\Repository\CompetencesRepository;
use App\Repository\NotificationsRepository;
use App\Service\PdfService;
use Cassandra\Date;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContratsRepository;
use App\Entity\Contrats;

class ContratController extends AbstractController
{
    #[Route('/contrats/{etat}', name: 'afficher_contrats')]
    public function afficherContrats($etat, ContratsRepository $contratsRepository)
    {
        $contrats = $contratsRepository->findBy(['etat_contrat'=>$etat]);

        return $this->render('afficher_contrats.html.twig', [
            'contrats' => $contrats,
            'etat' => $etat,
        ]);
    }

    #[Route('/traiter_contrat/{id}', name: 'traiter_contrat')]
    public function traiterContrat($id, ContratsRepository $contratsRepository, CompetencesRepository $competencesRepository)
    {
        $contrat = $contratsRepository->find($id);

        return $this->render('traiter_contrat.html.twig', [
            'contrat' => $contrat,
            'competencesRepository' => $competencesRepository,
        ]);
    }

    #[Route('/contrat/pdf/{id}', name: 'contrat_pdf')]
    public function generatePdfPersonne($id, PdfService $pdf, ContratsRepository $contratsRepository): Response
    {
        $contrat = $contratsRepository->find($id);
        $html = $this->renderView('contrat.html.twig', ['contrat' => $contrat]);
        $pdf->showPdfFile($html);

        return new Response();
    }

    #[Route('/contrat_validation/{id}/{etat}', name: 'valider_contrat')]
    public function valider_contrat($id, $etat, ContratsRepository $contratsRepository, EntityManagerInterface $entityManager)
    {
        $contrat = $contratsRepository->find($id);
        $contrat->setDateReponse(new \DateTime());
        $contrat->setEtatContrat($etat);
        $notification = new Notifications();
        $notification->setContrat($contrat);
        $notification->setMessage("Votre Contrat de libelle " . $contrat->getLibelle() . " a été " . $etat);
        $notification->setDateEnvoi(new \DateTime());
        $entityManager->persist($notification);
        $entityManager->flush();
        return $this->redirectToRoute('emailSender', ['id' => $id, 'etat' => $etat]);
    }

    #[Route('/email/{id}/{etat}', name: 'emailSender')]
    public function generateAndSendPdf($id, $etat, PdfService $pdfService, MailerInterface $mailer, Filesystem $filesystem, ContratsRepository $contratsRepository): Response
    {
        $contrat = $contratsRepository->find($id);
        $email_client = $contrat->getClient()->getEmail();
        $subject = 'Sujet de l\'e-mail';
        $content = '';

        if ($etat == 'accepte') {
            $subject = 'Confirmation de contrat';
            $content = 'Votre contrat a été accepté. Vous trouverez ci-joint le contrat en PDF.';
            $htmlContent = $this->renderView('contrat.html.twig', ['contrat' => $contrat]);
            $pdfDirectory = $this->getParameter('kernel.project_dir') . '/public/pdfs';
            $pdfService->generatePdfFromHtml($htmlContent, $pdfDirectory . '/contrat.pdf');
            $email = (new Email())
                ->from('interimco@hotmail.com')
                ->to($email_client)
                ->subject($subject)
                ->text($content);
            $email->attachFromPath($pdfDirectory . '/contrat.pdf');
        } else {
            $subject = 'Demande de contrat refusée';
            $content = 'Malheureusement, nous ne pouvons pas satisfaire votre demande pour le contrat.';
            $email = (new Email())
                ->from('interimco@hotmail.com')
                ->to($email_client)
                ->subject($subject)
                ->text($content);
        }
        try {
            $mailer->send($email);
            $this->addFlash('success', 'E-mail envoyé avec succès.');
        } catch (TransportExceptionInterface $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }

        return $this->redirectToRoute('afficher_contrats', ['etat' => 'en_cours_de_traitement', 'id' => $id]);
    }
}
