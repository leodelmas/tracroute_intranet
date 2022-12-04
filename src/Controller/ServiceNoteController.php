<?php

namespace App\Controller;

use App\Entity\ServiceNote;
use App\Form\ServiceNoteType;
use App\Repository\ServiceNoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/note')]
class ServiceNoteController extends AbstractController
{
    #[Route('/', name: 'app_service_note_index', methods: ['GET'])]
    public function index(ServiceNoteRepository $serviceNoteRepository): Response
    {
        return $this->render('service_note/index.html.twig', [
            'service_notes' => $serviceNoteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_note_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceNoteRepository $serviceNoteRepository): Response
    {
        $serviceNote = new ServiceNote();
        $form = $this->createForm(ServiceNoteType::class, $serviceNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceNoteRepository->save($serviceNote, true);

            return $this->redirectToRoute('app_service_note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_note/new.html.twig', [
            'service_note' => $serviceNote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_note_show', methods: ['GET'])]
    public function show(ServiceNote $serviceNote): Response
    {
        return $this->render('service_note/show.html.twig', [
            'service_note' => $serviceNote,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_note_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceNote $serviceNote, ServiceNoteRepository $serviceNoteRepository): Response
    {
        $form = $this->createForm(ServiceNoteType::class, $serviceNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceNoteRepository->save($serviceNote, true);

            return $this->redirectToRoute('app_service_note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_note/edit.html.twig', [
            'service_note' => $serviceNote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_note_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceNote $serviceNote, ServiceNoteRepository $serviceNoteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceNote->getId(), $request->request->get('_token'))) {
            $serviceNoteRepository->remove($serviceNote, true);
        }

        return $this->redirectToRoute('app_service_note_index', [], Response::HTTP_SEE_OTHER);
    }
}
