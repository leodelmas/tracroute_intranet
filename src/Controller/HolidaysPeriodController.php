<?php

namespace App\Controller;

use App\Entity\HolidaysPeriod;
use App\Form\HolidaysPeriodType;
use App\Repository\HolidaysPeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/holidays')]
class HolidaysPeriodController extends AbstractController
{
    #[Route('/', name: 'app_holidays_period_index', methods: ['GET'])]
    public function index(HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        return $this->render('holidays_period/index.html.twig', [
            'holidays_periods' => $holidaysPeriodRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_holidays_period_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        $holidaysPeriod = new HolidaysPeriod();
        $holidaysPeriod->setUser($this->getUser());
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
}
