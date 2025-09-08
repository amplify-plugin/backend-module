<?php

use Amplify\ErpApi\Facades\ErpApi;
use Amplify\Frontend\Events\ContactLoggedIn;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('dev-test/{route}', function (string $route) {
    //    Customer::all()->each(function ($customer) {
    //        try {
    //            file_put_contents(base_path("storage/logs/contacts/{$customer->customer_code}.json"),
    //                json_encode(
    //                    ErpApi::service()->post('/sxapiargetcontactlist', [
    //                        "companyNumber" => 1,
    //                        "operatorInit" => "sys",
    //                        "customerNumber" => $customer->customer_code
    //                    ])));
    //            sleep(1);
    //        }catch (\Exception $exception){
    //            logger("Customer: {$customer->customer_code} Message: {$exception->getMessage()}");
    //        }
    //    });

    //    dd(ErpApi::service()->post("/{$route}", [
    //                        "companyNumber" => 1,
    //                        "operatorInit" => "sys",
    //                        "customerNumber" => 1000
    //                    ]));

    switch ($route) {
        case 'adapter':
            dump(ErpApi::adapter());
            break;

        case 'invoice-list':
            dump(ErpApi::getInvoiceList());
            break;
        case 'contact-list':
            dump(ErpApi::getContactList(['customer_number' => 192644, 'name' => 'ANOTHER TEST']));
            break;

        case 'order-list':
            if ($customer_number = request('customer')) {
                dump(ErpApi::getOrderList(['customer_number' => $customer_number]));
            } else {
                dump(ErpApi::getOrderList());
            }

            break;

        case 'quote-list':
            dump(ErpApi::getQuotationList(['customer_number' => 262]));
            break;

        case 'warehouse':
            dump(ErpApi::getWarehouses());
            break;

        case 'order-details':
            dump(ErpApi::getOrderDetail(['order_number' => request('order_number', '418303')]));
            break;

        case 'quote-details':
            dump(ErpApi::getQuotationDetail(['quote_number' => '1']));
            break;

        case 'invoice-details':
            dump(ErpApi::getInvoiceDetail(['invoice_number' => 123445]));
            break;

        case 'price-availability':
            dump(ErpApi::getProductPriceAvailability(['items' => ['142SHDB', '144DB']]));
            break;

        case 'customer-address':
            if ($customer_number = request('customer')) {
                dump(ErpApi::getCustomerShippingLocationList(['customer_number' => $customer_number]));
            } else {
                dump(ErpApi::getCustomerShippingLocationList());
            }

            break;

        case 'customer-list':
            dump(ErpApi::getCustomerList(['customer_start' => '10', 'customer_end' => '100']));
            break;

        case 'create-customer':
            dump(ErpApi::createCustomer());
            break;

        case 'customer-detail':
            if ($customer_number = request('customer')) {
                dump(ErpApi::getCustomerDetail(['customer_number' => $customer_number]));
            } else {
                dump(ErpApi::getCustomerDetail());
            }
            break;

        case 'config':
            dump(config('amplify'));
            break;

        case 'product-sync':
            dump(ErpApi::getProductSync(['updates_only' => 'Y', 'process_updates' => 'N']));
            break;

        case 'product-sync-service':
            dump(ErpApi::storeProductSyncOnModel(['updates_only' => 'Y', 'process_updates' => 'N']));
            break;

        case 'mail':
            Mail::raw('Hi, welcome user!', function ($message) {
                $message->to(request('email', 'shaheenmediusware@gmail.com'), 'test')->subject('test');
            });
            dd('Basic Email Sent. Check your inbox.');
            break;

        case 'timezone':
            dump(array_values(config('amplify.constant.timezone')));
            break;

        case 'dbal':
            dump(DB::select('DESCRIBE `attributes`;'));
            break;

        case 'error' :
            Customer::find(1000000000000)->id;
            break;

        case 'whoami' :
            $contact = Contact::find(request('contact', 9305));

            auth('customer')->login($contact);

            event(new ContactLoggedIn($contact));

            return redirect()->to('/');

        case 'widget-fix':
            return view('text');

        case 'credit-card':
            $num = openssl_decrypt('8LGITJtZAkMODgtLkvAvtR/SbRScJImBsDJg4VOo3GY=', 'aes-128-cbc', '493A4DC5078A43BE', 0,
                '8B8A9E79AB16EF2A');
            $ex = openssl_decrypt('zykT6JD2PlAABdqCMSbi9g==', 'aes-128-cbc', '493A4DC5078A43BE', 0, '8B8A9E79AB16EF2A');
            $cvc = openssl_decrypt('qEpMQNIQkjrX326veepQbw==', 'aes-128-cbc', '493A4DC5078A43BE', 0,
                '8B8A9E79AB16EF2A');

            dd($num, $ex, $cvc);

        case 'invoice-download':
            dump(ErpApi::getDocument(['document_number' => '825562-0', 'document_type' => 'I']));
            break;

        case 'PastSales':
            if ($customer_number = request('customer')) {
                dump(ErpApi::getPastItemList(['customer_number' => $customer_number]));
            }
            break;

        case 'csd-erp':
            dd(ErpApi::service());
            break;

        default:
            dump('Your are on Dev Test Route');
            break;
    }

    return null;
});

Route::view('erp-test', 'vendor.mail.html.layout');

Route::any('form-validation-test', function (\Amplify\System\Backend\Http\Requests\ValidationRequest $request) {
    dd($request->all());
});

Route::any('form-test', function (Request $request) {
    dd($request->all());
});
