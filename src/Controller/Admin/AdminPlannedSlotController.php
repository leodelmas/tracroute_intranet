<?php

namespace App\Controller\Admin;

use App\Repository\PlannedSlotCategoryRepository;
use App\Repository\PlannedSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/planned_slot')]
class AdminPlannedSlotController extends AbstractController
{
    #[Route('/', name: 'app_admin_planned_slot_index', methods: ['GET'])]
    public function index(PlannedSlotRepository $plannedSlotRepository, PlannedSlotCategoryRepository $plannedSlotCategoryRepository): Response
    {
        return $this->render('admin/planned_slot/index.html.twig', [
            'planned_slots' => $plannedSlotRepository->findAll(),
            'planned_slots_categories' => $plannedSlotCategoryRepository->findAll()
        ]);
    }
}