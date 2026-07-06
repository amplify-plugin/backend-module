<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\ErpApi\Facades\ErpApi;
use Illuminate\Routing\Controller;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class PdfGeneratorOriginalController extends Controller
{
    public function generatePdf($invoiceNumber)
    {
        $invoice = ErpApi::getInvoiceDetail(['invoice_number' => $invoiceNumber]);
        $pdf = LaravelMpdf::loadView('pdf.invoice-details', ['invoice' => $invoice]);

        return $pdf->download("invoice-details-{$invoiceNumber}.pdf");
    }
}
