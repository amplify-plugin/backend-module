<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use Amplify\System\Backend\Http\Controllers\Admin\ContactCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\CustomerGroupCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\EventActionCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\EventVariableCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\ProductClassificationCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\ProductCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\ProductSyncCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\ServerInfoController;
use Amplify\System\Backend\Http\Controllers\Admin\SiteCrudController;
use Amplify\System\Backend\Http\Controllers\Admin\SystemConfigurationCrudController;
use Amplify\System\Backend\Http\Controllers\AlexusmaiFileManagerController;
use Amplify\System\Cms\Http\Controllers\PageCrudController;
use Amplify\System\Marketing\Http\Controllers\CampaignCrudController;
use Amplify\System\Utility\Http\Controllers\FailedJobCrudController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Amplify\System\Backend\Http\Controllers\Admin'], function () {
    Route::get('force-reset-password/{user}', 'Auth\ForceUpdatePasswordController@edit')
        ->name('admin.force-password.reset')->withoutMiddleware('admin_password_reset_required');

    Route::post('force-reset-password/{user}', 'Auth\ForceUpdatePasswordController@update')
        ->withoutMiddleware('admin_password_reset_required');

    Route::get('logout', function () {
        backpack_auth()->logout();
        request()->session()->regenerateToken();

        return redirect()->route('backpack.auth.login');
    });

    // custom admin routes
    Route::crud('attribute', 'AttributeCrudController');
    Route::crud('attributevalue', 'AttributeValueCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('categoryproduct', 'CategoryProductCrudController');
    Route::crud('contact', 'ContactCrudController');
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('custom-product', 'CustomProductCrudController');
    Route::post('product/sku/remove/{parent_id}/{sku_id}', 'ProductCrudController@removeSku')->name('product.removeSku');
    Route::crud('classification', 'ProductClassificationCrudController');
    Route::post('product/bulk-archive', 'ProductCrudController@bulkArchive')->name('bulk-archive');
    Route::post('product/bulk-publish', 'ProductCrudController@bulkPublish')->name('bulk-publish');
    Route::crud('search', 'SearchCrudController');
    Route::crud('site_only', 'SiteOnlyCrudController');
    Route::crud('site', 'SiteCrudController');
    Route::crud('siteconfig', 'SiteConfigCrudController');
    Route::crud('option', 'OptionCrudController');
    Route::crud('manufacturer', 'ManufacturerCrudController');
    Route::crud('brand', 'BrandCrudController');
    Route::crud('query-category', 'ReportCategoryCrudController');
    Route::crud('saved-query', 'AdhocPromptSuggestionCrudController');
    Route::crud('saved-report', 'SavedDynamicReportCrudController');
    Route::crud('dynamic-report', 'AdhocReportCrudController');
    Route::crud('new-report', 'NewReportCrudController');
    Route::crud('standard-report', 'StandardReportCrudController');
    Route::crud('my-report', 'MyReportCrudController');
    Route::crud('order', 'OrderCrudController');
    Route::crud('draft-order', 'DraftOrderCrudController');
    Route::crud('quote', 'QuoteCrudController');
    Route::crud('invoice', 'InvoiceCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('faq', 'FaqCrudController');

    Route::crud('email', 'EmailCrudController');
    Route::crud('shipping', 'ShippingCrudController');
    Route::crud('tax', 'TaxCrudController');
    Route::crud('warehouse', 'WarehouseCrudController');
    Route::crud('store', 'StoreCrudController');
    Route::crud('site-pricing', 'SitePricingCrudController');
    Route::crud('customer-group', 'CustomerGroupCrudController');
    Route::crud('customer-registration', 'CustomerRegistrationCrudController');
    Route::crud('contact-registration', 'ContactRegistrationCrudController');
    Route::crud('localization', 'LocalizationCrudController');
    Route::crud('document-type', 'DocumentTypeCrudController');
    Route::crud('faq-category', 'FaqCategoryCrudController');
    Route::crud('customer-list', 'CustomerListCrudController');
    Route::crud('list-item', 'ListItemCrudController');
    Route::crud('trigger', 'TriggerCrudController');
    Route::crud('event-action', 'EventActionCrudController');
    Route::crud('event-template', 'EventTemplateCrudController');
    Route::crud('system-configuration', 'SystemConfigurationCrudController');
    Route::crud('event-variable', 'EventVariableCrudController');
    Route::crud('event-recipent', 'EventRecipentCrudController');
    Route::crud('product-sync', 'ProductSyncCrudController');
    Route::crud('account-title', 'AccountTitleCrudController');
    Route::get('invoice/invoice-summary/{customerCode}', 'InvoiceCrudController@invoiceSummary');
    Route::get('invoice/invoice-details/{invoiceNumber}/{customerCode}',
        'InvoiceCrudController@invoiceDetails')->name('admin.invoice.invoice-details');
    Route::get('notification/unreadcount', [
        'uses' => 'NotificationCrudController@unreadCount',
        'as' => 'crud.notification.unreadcount',
    ]);
    Route::get('notification/dismissall', [
        'uses' => 'NotificationCrudController@dismissAll',
        'as' => 'crud.notification.dismissall',
    ]);
    Route::get('notification/{notification_id}/dismiss', [
        'uses' => 'NotificationCrudController@dismiss',
        'as' => 'crud.notification.dismiss',
    ]);
    Route::crud('notification', 'NotificationCrudController');
    Route::crud('report', 'ReportCrudController');
    Route::crud('customer-permission', 'CustomerPermissionCrudController');
    Route::crud('customer-role', 'CustomerRoleCrudController');
    Route::crud('tag', 'TagCrudController');
    Route::crud('message', 'MessageCrudController');
    Route::crud('event', 'WebinarCrudController');
    Route::crud('event-type', 'WebinarTypeCrudController');
    Route::crud('contact-login', 'ContactLoginCrudController');
    Route::crud('threshold-range', 'ThresholdRangeCrudController');
    Route::crud('industry-classification', 'IndustryClassificationCrudController');
    Route::crud('customer-address', 'CustomerAddressCrudController');

    // ---- Reports ----
    Route::prefix('charts')->group(function () {
        Route::get('monthly-order-amount',
            'Charts\MonthlyOrderAmountChartController@response')->name('charts.monthly-order-amount.index');
        Route::get('contacts',
            'Charts\LatestContactsChartController@response')->name('charts.latest-contacts.index');
        Route::get('customers',
            'Charts\LatestCustomersChartController@response')->name('charts.latest-customers.index');
        Route::get('weekly-order-by-quarterly',
            'Charts\WeeklyOrderByQuarterlyChartController@response')->name('charts.weekly-order-by-quarterly.index');
        Route::get('weekly-order-by-last-quarterly',
            'Charts\WeeklyOrderByLastQuarterlyChartController@response')->name('charts.weekly-order-by-last-quarterly.index');
    });
    Route::get('report/{id}/viewreport', 'ReportCrudController@viewReport')->name('admin.report.viewreport');

    Route::crud('country', 'CountryCrudController');
    Route::crud('state', 'StateCrudController');

    Route::crud('model-code', 'ModelCodeCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('custom-part-number', 'CustomPartNumberCrudController');
    Route::crud('relationship-type', 'RelationshipTypeCrudController');
    Route::crud('product-relation', 'ProductRelationCrudController');
    Route::crud('catalog', 'CatalogCrudController');
});

Route::get('failed-job/{id}/retry', [FailedJobCrudController::class, 'retry']);
/*
|--------------------------------------------------------------------------
| Site active/deactivate routes
|--------------------------------------------------------------------------
*/
Route::controller(SiteCrudController::class)->prefix('site')->group(function () {
    Route::get('{id}/deactivate', 'deactivate');
    Route::get('{id}/activate', 'activate');
});

/*
|--------------------------------------------------------------------------
| Site cache clear
|--------------------------------------------------------------------------
*/
Route::post('clear-cache', function (Illuminate\Http\Request $request) {
    try {

        Artisan::call('optimize:clear');

        Log::debug(Artisan::output());

        \Illuminate\Support\Facades\Auth::guard(backpack_guard_name())->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        cacheAll();

        return response()->json(['message' => 'Cache clear successfully. You may need to re-logged in.', 'success' => true]);

    } catch (\Exception $exception) {

        return response()->json(['message' => $exception->getMessage(), 'success' => false]);
    }
})->name('clear-cache.clear');

/*
|--------------------------------------------------------------------------
| Product classification related routes
|--------------------------------------------------------------------------
*/
Route::controller(ProductClassificationCrudController::class)->prefix('product-classification')->group(function () {
    Route::get('check-use-product/{product_classification}', 'checkUseInProducts');
    Route::post('update-pivot-table', 'updatePivotTable');
});

/*
|--------------------------------------------------------------------------
| Product Crud routes
|--------------------------------------------------------------------------
*/
Route::controller(ProductCrudController::class)->prefix('product')->group(function () {
    Route::post('upload_image', 'uploadImage');
    Route::post('upload_document', 'uploadDocument');
    Route::post('remove_image', 'removeImage');
    Route::post('remove_document', 'removeDocument');
    Route::post('sku/create', 'storeSKUProduct');
    Route::post('sku/update', 'updateSKUProduct');
    Route::group(['as' => 'product.'], function () {
        Route::get(
            'status-update/{product}/{status}/{previous_status}',
            'statusUpdate'
        )->name('status-update');
        Route::get(
            'remove-from-archive/{product}/{status}/{previous_status}',
            'statusUpdate'
        )->name('remove.archive');
    });
    Route::post('update-pivot-table', 'updatePivotTable');
    Route::match(['POST', 'PUT'], 'custom/save', 'save');
});

/*
|--------------------------------------------------------------------------
| Customer group related routes
|--------------------------------------------------------------------------
*/
Route::controller(CustomerGroupCrudController::class)->prefix('customer-group')->group(function () {
    Route::post('add-customer-to-group', 'addCustomerToGroup');
    Route::post('remove-customer-from-group', 'removeCustomerFromGroup');
});

/*
|--------------------------------------------------------------------------
| Page Controller related routes
|--------------------------------------------------------------------------
*/

Route::get('page/{page}/publish/{status}', [PageCrudController::class, 'publish']);

/*
|--------------------------------------------------------------------------
| File manger related routes
|--------------------------------------------------------------------------
*/
Route::controller(AlexusmaiFileManagerController::class)->prefix('filemanager')->group(function () {
    Route::get('/', 'index')->name('alexusmai-filemanager');
    Route::get('/popup/{input_id}', 'popup')->name('alexusmai-filemanager-popup');
});

/*
|--------------------------------------------------------------------------
| Server Information
|--------------------------------------------------------------------------
*/
Route::get('server-info', ServerInfoController::class)->name('server-info');

/*
|--------------------------------------------------------------------------
| Other routes
|--------------------------------------------------------------------------
*/
Route::get('contact/get-address/{id?}', [ContactCrudController::class, 'getAddresses'])->name('addresses.get');
Route::get('event/get-templates/{id?}', [EventActionCrudController::class, 'getTemplates'])->name('templates.get');
Route::get('event/get-recipents/{id?}', [EventActionCrudController::class, 'getRecipents'])->name('recipents.get');
Route::get('event/get-variables', [EventVariableCrudController::class, 'getVariables'])->name('variable.get');
// Route::post('quote/change-price', [QuoteLineCrudController::class, 'changePrice'])->name('change-price');
// Route::post('order/update-order', [OrderLineCrudController::class, 'updateOrder'])->name('update-order-info');
Route::get('disks', function () {
    return config('filesystems.disks');
});

/*
|--------------------------------------------------------------------------
| Product Sync routes
|--------------------------------------------------------------------------
*/
Route::get('product-sync/{id}/process', [ProductSyncCrudController::class, 'process'])->name('product-sync.process');
Route::post('product-sync/bulk-process', [ProductSyncCrudController::class, 'bulkProcess'])->name('admin.product-sync.bulk');

/*
|----------------------------------------------------------------------------
| System Configurations routes
|----------------------------------------------------------------------------
*/
Route::get('system-config', [SystemConfigurationCrudController::class, 'showConfig'])
    ->name('system-config.update');
Route::put('system-config', [SystemConfigurationCrudController::class, 'updateConfig']);
Route::get('get-page-data', [SystemConfigurationCrudController::class, 'getPageData'])
    ->name('page-data.get');

Route::post('campaign-store', [CampaignCrudController::class, 'store'])->name('admin.campaign.store');
Route::put('campaign-update/{campaign?}', [CampaignCrudController::class, 'update'])->name('admin.campaign.update');

Route::view('google-analytic', 'backend::google-analytics.index');
