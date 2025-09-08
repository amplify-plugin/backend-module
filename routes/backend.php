<?php


// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use Amplify\System\Utility\Http\Controllers\FailedJobCrudController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'backpack'),
    'middleware' => array_merge(config('backpack.base.web_middleware', ['web']),
        (array)config('backpack.base.middleware_key', 'admin')),
    ['admin_password_reset_required'],
], function () {
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
        Route::post('customer/bulk-profile-sync', 'CustomerCrudController@bulkProfileSync');
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
        Route::crud('language', 'LanguageCrudController');
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

        Route::get('page-builder', [\Amplify\System\Cms\Http\Controllers\PageBuilder\PageBuilderController::class, 'index']);
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

});
