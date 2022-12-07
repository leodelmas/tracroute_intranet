<?php

namespace App\Controller;

use App\Entity\ServiceNote;
use App\Repository\ServiceNoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service_note')]
class ServiceNoteController extends AbstractController
{
    #[Route('/', name: 'app_service_note_index', methods: ['GET'])]
    public function index(ServiceNoteRepository $serviceNoteRepository): Response
    {
        return $this->render('service_note/index.html.twig', [
            'service_notes' => $serviceNoteRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_service_note_show', methods: ['GET'])]
    public function show(ServiceNote $serviceNote): Response
    {
        return $this->render('service_note/show.html.twig', [
            'service_note' => $serviceNote,
        ]);
    }
}
