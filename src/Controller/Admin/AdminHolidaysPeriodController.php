<?php

namespace App\Controller\Admin;

use App\Entity\HolidaysPeriod;
use App\Form\HolidaysPeriodType;
use App\Repository\HolidaysPeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/holidays')]
class AdminHolidaysPeriodController extends AbstractController
{
    #[Route('/', name: 'app_admin_holidays_period_index', methods: ['GET'])]
    public function index(HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        return $this->render('admin/holidays_period/index.html.twig', [
            'holidays_periods' => $holidaysPeriodRepository->findAll(),
        ]);
    }

    #[Route('/approve/{id}', name: 'app_admin_holidays_period_approve', methods: ['POST'])]
    public function approve(Request $request, HolidaysPeriod $holidaysPeriod, HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        if ($this->isCsrfTokenValid('approve'.$holidaysPeriod->getId(), $request->request->get('_token'))) {
            $holidaysPeriod->setApproved(true);
            $holidaysPeriodRepository->save($holidaysPeriod, true);
        }

        return $this->redirectToRoute('app_admin_holidays_period_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/refuse/{id}', name: 'app_admin_holidays_period_refuse', methods: ['POST'])]
    public function refuse(Request $request, HolidaysPeriod $holidaysPeriod, HolidaysPeriodRepository $holidaysPeriodRepository): Response
    {
        if ($this->isCsrfTokenValid('refuse'.$holidaysPeriod->getId(), $request->request->get('_token'))) {
            $holidaysPeriod->setApproved(false);
            $holidaysPeriodRepository->save($holidaysPeriod, true);
        }

        return $this->redirectToRoute('app_admin_holidays_period_index', [], Response::HTTP_SEE_OTHER);
    }
}
