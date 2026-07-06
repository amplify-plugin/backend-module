<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\Frontend\Traits\HasDynamicPage;
use Amplify\System\Backend\Facades\CenPos;
use Amplify\System\Backend\Models\CustomerOrder;
use Amplify\System\Backend\Models\Event;
use Amplify\System\Factories\NotificationFactory;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class CenPosPaymentController extends Controller
{
    use HasDynamicPage;

    public function index(Request $request)
    {
        $this->loadPageByType('invoice_pay');

        return $this->render();
    }

    public function invoicePay(Request $request)
    {
        $request->validate([
            'invoices' => 'required|array',
        ]);

        try {
            $payableInvoices = $this->getValidatedInvoice($request->invoices);
            if (count($payableInvoices) === 0) {
                return redirect('invoice-summary')->with('error', 'Select valid invoices.');
            }

            $verifyingPost = CenPos::getVerifyingPost();
            $customerCode = \ErpApi::getCustomerDetail()->CustomerNumber;
            $payableInvoicesId = array_map(function ($item) {
                return $item['InvoiceBalance'];
            }, $payableInvoices);
            $accountPayableAmount = $this->calculatePrice($payableInvoices);
            $payableInvoicesId = encrypt($request->invoices);
        } catch (\Throwable $th) {
            return redirect('invoice-summary')->with('error', $th->getMessage());
        }

        return view(
            'frontend.payment.cenpos-invoices-pay',
            compact('verifyingPost', 'customerCode', 'accountPayableAmount', 'payableInvoices', 'payableInvoicesId')
        );
    }

    public function invoiceProcessPayment(Request $request)
    {
        $request->validate([
            'card_token' => 'required|string',
            'data_token' => 'required',
        ]);

        try {
            $payableInvoicesId = decrypt($request->data_token);
            $payableInvoices = $this->getValidatedInvoice($payableInvoicesId);
            $accountPayableAmount = $this->calculatePrice($payableInvoices);
            // $cenPosRes = CenPos::payPayment(
            //     customer(true)->email,
            //     $accountPayableAmount,
            //     $request->card_token,
            //     implode(' ', $payableInvoicesId)
            // );

            // if (isset($cenPosRes->Message) && $cenPosRes->Message != 'Approved') {
            //     return redirect('invoices')->with('error', $cenPosRes->Message);
            // }

            $paymentParams = [
                'paymentInfo' => [
                    'CreditCardPayment' => [
                        'Token' => $request->card_token,
                        'Amount' => $accountPayableAmount,
                    ],
                ],
                'invoices' => [],
                'type' => 2,
            ];

            for ($i = 0; $i < count($payableInvoices); $i++) {
                $paymentParams['invoices'][] = [
                    'InvoiceNumber' => $payableInvoices[$i]['InvoiceNumber'],
                    'PayAmount' => str_replace(',', '', $payableInvoices[$i]['InvoiceBalance'] ?? 1),
                ];
            }

            $erpRes = \ErpApi::createPayment($paymentParams);

            // if (isset($cenPosRes->Message) && $cenPosRes->Message === 'Approved' && isset($erpRes['Message']) && $erpRes['Message'] === '') {
            //     return redirect('invoices')->with('success', 'Successfully paid.');
            // }
            if (isset($erpRes['Message']) && $erpRes['Message'] === '') {
                return redirect('invoices')->with('success', 'Successfully paid.');
            }
        } catch (\Throwable $th) {
            return redirect('invoices')->with('error', $th->getMessage());
        }

        return redirect('invoices')->with('error', 'Something went wrong.');
    }

    private function getValidatedInvoice($payableInvoicesId)
    {
        $res = [];
        $invoiceList = \ErpApi::getInvoiceList();

        foreach ($invoiceList as $invoice) {
            if (in_array($invoice->InvoiceNumber, $payableInvoicesId)) {
                $res[] = $invoice;
            }
        }

        return $res;
    }

    private function calculatePrice($payableInvoices)
    {
        return array_reduce($payableInvoices, function ($pre, $item) {
            return $pre + str_replace(',', '', $item['InvoiceBalance'] ?? 1);
        }, 0);
    }

    public function orderCreditCardPay(CustomerOrder $customerOrder)
    {
        try {
            if ($customerOrder->order_status === 'Rejected') {
                return redirect('orders')->with('error', 'Something went wrong.');
            }

            $customerOrder->load('orderLines');

            $verifyingPost = CenPos::getVerifyingPost();
            $customerCode = \ErpApi::getCustomerDetail()->CustomerNumber;

            return view(
                'frontend.payment.cenpos-order-credit-card-pay',
                compact('verifyingPost', 'customerCode', 'customerOrder')
            );
        } catch (\Throwable $th) {
            return redirect('orders')->with('error', $th->getMessage());
        }
    }

    public function orderCreditCardProcessPayment(CustomerOrder $customerOrder, Request $request)
    {
        $request->validate([
            'card_token' => 'required|string',
        ]);

        $apiResponse = $customerOrder->createOrderOrQuoteERP([
            'card_token' => $request->input('card_token'),
            'order_type' => 'O',
        ]);

        if ($apiResponse['success']) {

            NotificationFactory::call([Event::ORDER_RECEIVED], [
                'order_id' => $customerOrder->id,
                'customer_id' => $customerOrder->customer_id,
            ]);

            return redirect('orders')->with('success', 'Successfully paid.');
        } else {
            return redirect('orders')->with('error', 'Something went wrong.');
        }
    }
}
