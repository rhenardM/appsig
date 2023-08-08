<?php

namespace App\Controller;

use App\Entity\DocLettre;
use App\Form\DocLettreType;
use App\Repository\DocLettreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/doc/lettre')]
class DocLettreController extends AbstractController
{
    #[Route('/', name: 'app_doc_lettre_index', methods: ['GET'])]
    public function index(DocLettreRepository $docLettreRepository): Response
    {
        return $this->render('doc_lettre/index.html.twig', [
            'doc_lettres' => $docLettreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_doc_lettre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $docLettre = new DocLettre();
        $form = $this->createForm(DocLettreType::class, $docLettre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($docLettre);
            $entityManager->flush();

            return $this->redirectToRoute('app_doc_lettre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('doc_lettre/new.html.twig', [
            'doc_lettre' => $docLettre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_doc_lettre_show', methods: ['GET'])]
    public function show(DocLettre $docLettre): Response
    {
        return $this->render('doc_lettre/show.html.twig', [
            'doc_lettre' => $docLettre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_doc_lettre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DocLettre $docLettre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DocLettreType::class, $docLettre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_doc_lettre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('doc_lettre/edit.html.twig', [
            'doc_lettre' => $docLettre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_doc_lettre_delete', methods: ['POST'])]
    public function delete(Request $request, DocLettre $docLettre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$docLettre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($docLettre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_doc_lettre_index', [], Response::HTTP_SEE_OTHER);
    }
}
