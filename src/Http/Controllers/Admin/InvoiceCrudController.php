<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Customer;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InvoiceCrudController
 *
 * @property-read CrudPanel $crud
 */
class InvoiceCrudController extends BackpackCustomCrudController
{
    use ListOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/invoice');
        CRUD::setEntityNameStrings('invoice', 'invoices');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        $this->data['customers'] = Customer::all();
        //        $this->crud->setListView('backend::pages.invoice.index');

        CRUD::addColumn([
            'name' => 'id',
            'label' => '#',
        ]);
        CRUD::addColumn([
            'name' => 'customer_code',
            'label' => 'Customer Code',
        ]);
        CRUD::addColumn([
            'name' => 'customer_name',
            'label' => 'Customer Name',
        ]);

        CRUD::column('email');

        CRUD::addColumn([
            'name' => 'customer_type',
            'label' => 'Customer Type',
        ]);

        $this->crud->removeButton('update');
        $this->crud->removeButton('show');
        $this->crud->removeButton('delete');
        $this->crud->addButtonFromView('line', 'invoice', 'custom/invoice', 'start');
        $this->crud->removeButton('create');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    public function invoiceSummary($customerCode)
    {
        // dd($this->crud);
        //        $this->data['customers'] = Customer::all();
        $accountSummary = \ErpApi::getCustomerARSummary(['customer_number' => $customerCode]);
        $customer = \ErpApi::getCustomerDetail(['customer_number' => $customerCode]);
        $invoiceSummary = \ErpApi::getInvoiceList(['customer_number' => $customerCode]);

        return view('backend::pages.invoice.invoice_summary',
            ['invoiceSummary' => $invoiceSummary,
                'customer' => $customer,
                'accountSummary' => $accountSummary,
                'customerCode' => $customerCode]);

        // $this->crud->setShowView('backend::pages.invoice.index');
    }

    public function invoiceDetails($invoiceNumber, $customerCode)
    {
        $invoice = \ErpApi::getInvoiceDetail(['invoice_number' => $invoiceNumber, 'customer_number' => $customerCode]);

        return view('backend::pages.invoice.invoice_details',
            ['invoice' => $invoice, 'customerCode' => $customerCode]);
    }
}
