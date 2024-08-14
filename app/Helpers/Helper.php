<?php

use App\Models\EventType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DefaultLinkAccountController;

if (!function_exists('show_route')) {
    function show_route($model, $resource = null)
    {
        $resource = $resource ?? plural_from_model($model);
        return route("{$resource}.show", $model);
    }
}

if (!function_exists('plural_from_model')) {
    function plural_from_model($model)
    {
        $plural = Str::plural(class_basename($model));
        return Str::kebab($plural);
    }
}

if (!function_exists('get_event_category_list')) {
    function get_event_category_list($eventId)
    {
        $eventCategories = EventType::getEventCategory();
        return isset($eventCategories[$eventId]) ? $eventCategories[$eventId] : '';
    }
}

if (!function_exists('get_controller_class_name')) {
    function get_controller_class_name($controllerName)
    {
        return 'App\Http\Controllers\\' . $controllerName;
    }
}

if (!function_exists('get_pascal_case_route')) {
    function get_pascal_case_route($route)
    {
        return Str::studly(Str::singular($route));
    }
}

if (!function_exists('define_default_link_accounts_routes')) {
    function define_default_link_accounts_routes()
    {
        Route::prefix('default_link_accounts')->name('default_link_accounts.')->group(function () {
            Route::get('/', [DefaultLinkAccountController::class, 'index'])->name('index');
            Route::post('/inventory_asset/save', [DefaultLinkAccountController::class, 'inventoryAssetSave'])->name('inventory_asset.save');
            Route::post('/inventory_in_transit_on_transfer/save', [DefaultLinkAccountController::class, 'inventoryInTransitOnTransferSave'])->name('inventory_in_transit_on_transfer.save');
            Route::post('/inventory_adjustment/save', [DefaultLinkAccountController::class, 'inventoryAdjustmentSave'])->name('inventory_adjustment.save');
            Route::post('/banking_payment/save', [DefaultLinkAccountController::class, 'bankingPaymentSave'])->name('banking_payment.save');
            Route::post('/other_charges_discounts_variance/save', [DefaultLinkAccountController::class, 'otherChargesDiscountsVarianceSave'])->name('other_charges_discounts_variance.save');
            Route::post('/sale/save', [DefaultLinkAccountController::class, 'saleSave'])->name('sale.save');
            Route::post('/accounting/save', [DefaultLinkAccountController::class, 'accountingSave'])->name('accounting.save');
            Route::post('/banking_receipt/save', [DefaultLinkAccountController::class, 'bankingReceiptSave'])->name('banking_receipt.save');
        });
    }
}

if (!function_exists('define_companies_routes')) {
    function define_companies_routes()
    {
        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', [CompanyController::class, 'index'])->name('index');
            Route::post('/store', [CompanyController::class, 'store'])->name('store');
            Route::get('/list', [CompanyController::class, 'getCompanyDataTableList'])->name('list');
            Route::delete('/{id}/delete', [CompanyController::class, 'destroy'])->name('delete');
            Route::get('/{id}/edit', [CompanyController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [CompanyController::class, 'update'])->name('update');
            Route::get('/{id}/show', [CompanyController::class, 'show'])->name('show');
        });
    }
}
