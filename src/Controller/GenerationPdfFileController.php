<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\GenerationPdfFile;
use App\Form\GenerationPdfFileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\GenerationPdfFileRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/generation/pdf/file')]
class GenerationPdfFileController extends AbstractController
{
    #[Route('/', name: 'app_generation_pdf_file_index', methods: ['GET'])]
    public function index(GenerationPdfFileRepository $generationPdfFileRepository): Response
    {
        return $this->render('generation_pdf_file/index.html.twig', [
            'generation_pdf_files' => $generationPdfFileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_generation_pdf_file_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $generationPdfFile = new GenerationPdfFile();
        $form = $this->createForm(GenerationPdfFileType::class, $generationPdfFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($generationPdfFile);
            $entityManager->flush();

            return $this->redirectToRoute('app_generation_pdf_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('generation_pdf_file/new.html.twig', [
            'generation_pdf_file' => $generationPdfFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_generation_pdf_file_show', methods: ['GET'])]
    public function show(GenerationPdfFile $generationPdfFile): Response
    {
        return $this->render('generation_pdf_file/show.html.twig', [
            'generation_pdf_file' => $generationPdfFile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_generation_pdf_file_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GenerationPdfFile $generationPdfFile, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GenerationPdfFileType::class, $generationPdfFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_generation_pdf_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('generation_pdf_file/edit.html.twig', [
            'generation_pdf_file' => $generationPdfFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_generation_pdf_file_delete', methods: ['POST'])]
    public function delete(Request $request, GenerationPdfFile $generationPdfFile, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $generationPdfFile->getId(), $request->request->get('_token'))) {
            $entityManager->remove($generationPdfFile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_generation_pdf_file_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/pdf', name: 'app_generationPdfFile_pdfFile', methods: ['GET'])]
    public function pdf(Request $request, GenerationPdfFile $generationPdfFile, GenerationPdfFileRepository $generationPdfFileRepository)
    {
        // Générer le contenu HTML du PDF
        $html = $this->renderView('generation_pdf_file/filePdf.html.twig', [
            'generationPdfFile' => $generationPdfFile,
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
}
