<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Repository\ServiceNoteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(NewsRepository $newsRepository, ServiceNoteRepository $serviceNoteRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'news' => $newsRepository->findLatestNews(),
            'service_note' => $serviceNoteRepository->findLatestServiceNote(),
        ]);
    }
}
