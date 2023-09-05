<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminInvoiceController extends AbstractController
{
    #[Route('/admin/invoice', name: 'app_admin_invoice_controller_php')]
    public function index(): Response
    {
        return $this->render('admin_invoice_controller_php/index.html.twig', [
            'controller_name' => 'AdminInvoiceControllerPhpController',
        ]);
    }
}
