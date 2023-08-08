<?php

namespace App\Controller;

use App\Entity\DocFinance;
use App\Form\DocFinanceType;
use App\Repository\DocFinanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/doc/finance')]
class DocFinanceController extends AbstractController
{
    #[Route('/', name: 'app_doc_finance_index', methods: ['GET'])]
    public function index(DocFinanceRepository $docFinanceRepository): Response
    {
        return $this->render('doc_finance/index.html.twig', [
            'doc_finances' => $docFinanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_doc_finance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $docFinance = new DocFinance();
        $form = $this->createForm(DocFinanceType::class, $docFinance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($docFinance);
            $entityManager->flush();

            return $this->redirectToRoute('app_doc_finance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('doc_finance/new.html.twig', [
            'doc_finance' => $docFinance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_doc_finance_show', methods: ['GET'])]
    public function show(DocFinance $docFinance): Response
    {
        return $this->render('doc_finance/show.html.twig', [
            'doc_finance' => $docFinance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_doc_finance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DocFinance $docFinance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DocFinanceType::class, $docFinance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_doc_finance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('doc_finance/edit.html.twig', [
            'doc_finance' => $docFinance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_doc_finance_delete', methods: ['POST'])]
    public function delete(Request $request, DocFinance $docFinance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$docFinance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($docFinance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_doc_finance_index', [], Response::HTTP_SEE_OTHER);
    }
}
