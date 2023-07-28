<?php

namespace App\Controller\Admin;

use App\Entity\PlannedSlotCategory;
use App\Form\PlannedSlotCategoryType;
use App\Repository\PlannedSlotCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/planned_slot_category')]
class AdminPlannedSlotCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_planned_slot_category_index', methods: ['GET'])]
    public function index(PlannedSlotCategoryRepository $plannedSlotCategoryRepository): Response
    {
        return $this->render('admin/planned_slot_category/index.html.twig', [
            'planned_slot_categories' => $plannedSlotCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_planned_slot_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlannedSlotCategoryRepository $plannedSlotCategoryRepository): Response
    {
        $plannedSlotCategory = new PlannedSlotCategory();
        $form = $this->createForm(PlannedSlotCategoryType::class, $plannedSlotCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plannedSlotCategoryRepository->save($plannedSlotCategory, true);

            return $this->redirectToRoute('app_admin_planned_slot_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/planned_slot_category/new.html.twig', [
            'planned_slot_category' => $plannedSlotCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_planned_slot_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlannedSlotCategory $plannedSlotCategory, PlannedSlotCategoryRepository $plannedSlotCategoryRepository): Response
    {
        $form = $this->createForm(PlannedSlotCategoryType::class, $plannedSlotCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plannedSlotCategoryRepository->save($plannedSlotCategory, true);

            return $this->redirectToRoute('app_admin_planned_slot_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/planned_slot_category/edit.html.twig', [
            'planned_slot_category' => $plannedSlotCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_planned_slot_category_delete', methods: ['POST'])]
    public function delete(Request $request, PlannedSlotCategory $plannedSlotCategory, PlannedSlotCategoryRepository $plannedSlotCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plannedSlotCategory->getId(), $request->request->get('_token'))) {
            $plannedSlotCategoryRepository->remove($plannedSlotCategory, true);
        }

        return $this->redirectToRoute('app_admin_planned_slot_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
