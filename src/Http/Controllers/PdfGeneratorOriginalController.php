<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\ErpApi\Facades\ErpApi;
use App\Http\Controllers\Controller;

class PdfGeneratorOriginalController extends Controller
{
    public function generatePdf($invoiceNumber)
    {
        $invoice = ErpApi::getInvoiceDetail(['invoice_number' => $invoiceNumber]);
        $pdf = \Mccarlosen\LaravelMpdf\Facades\LaravelMpdf::loadView('pdf.invoice-details', ['invoice' => $invoice]);

        return $pdf->download("invoice-details-{$invoiceNumber}.pdf");
    }
}
