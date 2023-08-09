<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use App\Repository\ContratRepository;
use App\Service\YousignService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Contrat')]
class ContratController extends AbstractController
{
    #[Route('/', name: 'app_contrat_index', methods: ['GET'])]
    public function index(ContratRepository $contratRepository): Response
    {
        return $this->render('contrat/index.html.twig', [
            'contrats' => $contratRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contrat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contrat);
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrat/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrat_show', methods: ['GET'])]
    public function show(Contrat $contrat): Response
    {
        return $this->render('contrat/show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

// Génération du document HTML du PDF
#[Route('/{id}/pdf', name: 'app_contrat_pdf', methods: ['GET'])]
public function pdf(Request $request, Contrat $contrat, ContratRepository $contratRepository)
{
    // Générer le contenu HTML du PDF
    $html = $this->renderView('contrat/pdf.html.twig', [
        'contrat' => $contrat,
    ]);

    // Créer une instance de Dompdf et charger le contenu HTML
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // Rendre le PDF
    $dompdf->render();

    // Renvoyer le contenu du PDF dans la réponse HTTP
    return new Response($dompdf->output(), 200, array(
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="document.pdf"'
    ));
}

    #[Route('/{id}/signature', name: 'app_contrat_signature', methods: ['GET'])]
    public function signature(Contrat $contrat, ContratRepository $contratRepository, YousignService $yousignService): Response
            {
                // 1 - Création de la démande de signature
                $yousignSignatureRequest = $yousignService->signatureRequest();
                $contrat->setSignatureId($yousignSignatureRequest['id']);
                //$contratRepository->save($contrat, true);
                
                // 2 - Upload document  
                $uploadDocument = $yousignService->uploadDocument($contrat->getSignatureId(), $contrat->getPdfSansSignature());
                $contrat->setSignatureId($yousignSignatureRequest['id']);
                //$contratRepository->save($contrat, true);

                // 3 - Add des signatures
                $signerId = $yousignService->addSigner(
                    $contrat->getSignatureId(),
                    $contrat->getDocumentId(),
                    $contrat->getMail(),
                    $contrat->getPrenom(),
                    $contrat->getName()
                );
                $contrat->setSignerId($signerId['id']);
                //$contratRepository->save($contrat, true);

                // 4 - Envoi de la demande de signature
                $yousignService->activateSignatureRequest($contrat->getSignatureId());

                return $this->redirectToRoute('app_contrat_show', ['id' => $contrat->getId()], Response::HTTP_SEE_OTHER);
            }
        
}
