<?php

namespace App\Controller;

use App\Entity\PlannedSlot;
use App\Form\PlannedSlotType;
use App\Repository\PlannedSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/planned_slot')]
class PlannedSlotController extends AbstractController
{
    #[Route('/', name: 'app_planned_slot_index', methods: ['GET'])]
    public function index(PlannedSlotRepository $plannedSlotRepository): Response
    {
        return $this->render('planned_slot/index.html.twig', [
            'planned_slots' => $plannedSlotRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_planned_slot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlannedSlotRepository $plannedSlotRepository): Response
    {
        $plannedSlot = new PlannedSlot();
        $form = $this->createForm(PlannedSlotType::class, $plannedSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plannedSlotRepository->save($plannedSlot, true);

            return $this->redirectToRoute('app_planned_slot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planned_slot/new.html.twig', [
            'planned_slot' => $plannedSlot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planned_slot_show', methods: ['GET'])]
    public function show(PlannedSlot $plannedSlot): Response
    {
        return $this->render('planned_slot/show.html.twig', [
            'planned_slot' => $plannedSlot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planned_slot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlannedSlot $plannedSlot, PlannedSlotRepository $plannedSlotRepository): Response
    {
        $form = $this->createForm(PlannedSlotType::class, $plannedSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plannedSlotRepository->save($plannedSlot, true);

            return $this->redirectToRoute('app_planned_slot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planned_slot/edit.html.twig', [
            'planned_slot' => $plannedSlot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planned_slot_delete', methods: ['POST'])]
    public function delete(Request $request, PlannedSlot $plannedSlot, PlannedSlotRepository $plannedSlotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plannedSlot->getId(), $request->request->get('_token'))) {
            $plannedSlotRepository->remove($plannedSlot, true);
        }

        return $this->redirectToRoute('app_planned_slot_index', [], Response::HTTP_SEE_OTHER);
    }
}
