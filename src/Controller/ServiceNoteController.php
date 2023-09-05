<?php

namespace App\Controller;

use App\Entity\Reception;
use App\Entity\ServiceNote;
use App\Repository\ReceptionRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/service_note')]
class ServiceNoteController extends AbstractController
{
    #[Route('/', name: 'app_service_note_index', methods: ['GET'])]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('service_note/index.html.twig', [
            'service_notes' => $user->getServiceNotes(),
        ]);
    }

    #[Route('/{id}', name: 'app_service_note_show', methods: ['GET'])]
    public function show(ServiceNote $serviceNote): Response
    {
        return $this->render('service_note/show.html.twig', [
            'service_note' => $serviceNote,
        ]);
    }

    #[Route('/validate/{id}', name: 'app_service_note_validate', methods: ['POST'])]
    public function validate(ServiceNote $serviceNote, Security $security, ReceptionRepository $receptionRepository): Response
    {
        $reception = new Reception();
        $reception
            ->setServiceNote($serviceNote)
            ->setUser($security->getUser());
        $receptionRepository->save($reception, true);
        return $this->redirectToRoute('app_service_note_index');
    }
}
