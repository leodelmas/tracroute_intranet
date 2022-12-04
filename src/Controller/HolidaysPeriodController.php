<?php

namespace App\Controller;

use App\Entity\HolidaysPeriod;
use App\Form\HolidaysPeriodType;
use App\Repository\HolidaysPeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/holidays_period')]
class HolidaysPeriodController extends AbstractController
{
    #[Route('/', name: 'app_holidays_period_index', methods: ['GET'])]
    public function index(HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        return $this->render('holidays_period/index.html.twig', [
            'holidays_periods' => $holidaysPeriodRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_holidays_period_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        $holidaysPeriod = new HolidaysPeriod();
        $form = $this->createForm(HolidaysPeriodType::class, $holidaysPeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $holidaysPeriodRepository->save($holidaysPeriod, true);

            return $this->redirectToRoute('app_holidays_period_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('holidays_period/new.html.twig', [
            'holidays_period' => $holidaysPeriod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_holidays_period_show', methods: ['GET'])]
    public function show(HolidaysPeriod $holidaysPeriod): Response
    {
        return $this->render('holidays_period/show.html.twig', [
            'holidays_period' => $holidaysPeriod,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_holidays_period_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HolidaysPeriod $holidaysPeriod, HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        $form = $this->createForm(HolidaysPeriodType::class, $holidaysPeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $holidaysPeriodRepository->save($holidaysPeriod, true);

            return $this->redirectToRoute('app_holidays_period_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('holidays_period/edit.html.twig', [
            'holidays_period' => $holidaysPeriod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_holidays_period_delete', methods: ['POST'])]
    public function delete(Request $request, HolidaysPeriod $holidaysPeriod, HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$holidaysPeriod->getId(), $request->request->get('_token'))) {
            $holidaysPeriodRepository->remove($holidaysPeriod, true);
        }

        return $this->redirectToRoute('app_holidays_period_index', [], Response::HTTP_SEE_OTHER);
    }
}
