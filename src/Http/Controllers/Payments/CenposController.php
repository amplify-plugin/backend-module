<?php

namespace Amplify\System\Backend\Http\Controllers\Payments;

use Amplify\System\Backend\Models\CustomerCreditCard;
use Amplify\System\Payment\CenPos\PaymentService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class CenposController extends Controller
{
    public function getCards(Request $request)
    {
        $request->validate([
            'customer_code' => 'required',
            'customer_email' => 'required|email',
        ]);

        try {
            if (config('amplify.client_code') == 'ACP') {
                $cardList = $this->getCreditCards($request->customer_code);
            } else {
                $cardList = (new PaymentService)->getCards($request->customer_code, $request->customer_email);
            }

            return response()->json([
                'card_list' => $cardList,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function addCard(Request $request)
    {
        $payload = $request->validate([
            'customer_number' => 'required',
            'customer_email' => 'required',

            'name' => 'required',
            'number' => 'required',
            'expiry' => 'required',
            'cvc' => 'required|numeric',

            'billing_address' => 'required',
            'zip_code' => 'required',
        ]);

        $payload['expiry'] = str_replace(' / ', '', $payload['expiry']);

        try {
            if (config('amplify.client_code') == 'ACP') {
                $res = $this->addCreditCard($payload);
            } else {
                $res = (new PaymentService)->addCard($payload);
            }

            if ($res['Result'] == 0) {
                return response()->json(['card_token' => $res['CenposToken']], 200);
            }

            return response()->json(['message' => ($res['CenposMessage'] ?? $res['message']) ?? 'Something went wrong.'], 500);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function getCreditCards($customer_code)
    {
        return CustomerCreditCard::where('customer_number', $customer_code)
            ->get()
            ->map(function ($card) {
                return [
                    'CustomerNumber' => $card->customer_number,
                    'NameOnCard' => $card->name,
                    'TokenID' => $card->id,
                    'LastFourOfCard' => substr($card->number, -4),
                    'CustomerBillingAddress' => $card->billing_address,
                    'CustomerMailAddress' => $card->customer_email,
                    'CustomerZipcode' => $card->zip_code,
                    'CardType' => 'VISA',
                    'CardexpirationDate' => $card->expiry,
                    'Customeremailaddress' => $card->customer_email,
                ];
            });
    }

    public function addCreditCard($card)
    {
        $cardExists = CustomerCreditCard::where([
            'customer_number' => $card['customer_number'],
            'number' => $card['number'],
        ])->exists();

        if ($cardExists) {
            return [
                'Result' => 0,
                'CenposToken' => uniqid(),
                'CenposMessage' => 'Payment successfull.',
            ];
        }

        $creditCard = CustomerCreditCard::create([
            'customer_number' => $card['customer_number'],
            'name' => $card['name'],
            'number' => $card['number'],
            'expiry' => $card['expiry'],
            'cvc' => $card['cvc'],
            'customer_email' => $card['customer_email'],
            'billing_address' => $card['billing_address'],
            'zip_code' => $card['zip_code'],
        ]);

        return [
            'Result' => 0,
            'CenposToken' => $creditCard->id,
            'CenposMessage' => 'Payment successfull.',
        ];
    }
}
