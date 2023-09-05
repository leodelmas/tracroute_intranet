<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceLineRepository;
use App\Repository\InvoiceRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Writer;
use SplTempFileObject;

#[Route('/invoice')]
class InvoiceController extends AbstractController
{
    #[Route('/', name: 'app_invoice_index', methods: ['GET'])]
    public function index(InvoiceRepository $invoiceRepository): Response
    {
        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_invoice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InvoiceRepository $invoiceRepository, FileUploader $fileUploader): Response
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileName = $form->get('file')->getData();
            if ($fileName) {
                $fileName = $fileUploader->upload($fileName);
                $invoice->setFileName($fileName);
            }
            $invoiceRepository->save($invoice, true);

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_show', methods: ['GET'])]
    public function show(Invoice $invoice): Response
    {
        return $this->render('invoice/show.html.twig', [
            'invoice' => $invoice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_invoice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Invoice $invoice, InvoiceRepository $invoiceRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileName = $form->get('file')->getData();
            if ($fileName) {
                $fileName = $fileUploader->upload($fileName);
                $invoice->setFileName($fileName);
            }
            $invoiceRepository->save($invoice, true);

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice/edit.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_delete', methods: ['POST'])]
    public function delete(Request $request, Invoice $invoice, InvoiceRepository $invoiceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invoice->getId(), $request->request->get('_token'))) {
            $invoiceRepository->remove($invoice, true);
        }

        return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/export/{id}', name: 'app_invoice_export', methods: ['GET'])]
    public function export(Invoice $invoice)
    {
        $fileLines = [];
        foreach ($invoice->getInvoiceLines() as $key => $line) {
            $fileLines[$key]["invoice"] = $invoice->getReference();
            $fileLines[$key]["description"] = $line->getDescription();
            $fileLines[$key]["price"] = $line->getPrice();
            $fileLines[$key]["quantity"] = $line->getQuantity();
        }
        $fileLines[count($fileLines)]["total"] = "Total : " . $invoice->getTotal();
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne(["Facture", "Description", "Prix", "Quantité"]);
        $csv->insertAll($fileLines);
        $csv->output('invoice_' . $invoice->getId() . '.csv');
        die;
    }
}
