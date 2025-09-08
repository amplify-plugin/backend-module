<?php

use Amplify\System\Backend\Http\Controllers\Payments\CenposController;
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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Centos routes
|--------------------------------------------------------------------------
|
| Here is where you can register Custom route for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('cenpos/v2')->controller(CenposController::class)->group(function () {
    Route::post('get-cards', 'getCards');
    Route::post('add-card', 'addCard');
});

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
Route::get('event/get-themes/{id?}', [EventActionCrudController::class, 'getTemplates'])->name('themes.get');
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
