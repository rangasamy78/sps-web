<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\BinTypeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubHeadingController;
use App\Http\Controllers\VendorTypeController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\UnitMeasureController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\SupplierPortController;
use App\Http\Controllers\ShipmentTermController;
use App\Http\Controllers\SupplierTypeController;
use App\Http\Controllers\LinkedAccountController;
use App\Http\Controllers\AboutUsOptionController;
use App\Http\Controllers\EndUseSegmentController;
use App\Http\Controllers\ProductFinishController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\AdjustmentTypeController;
use App\Http\Controllers\ShipmentMethodController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\AccountSubTypeController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ReceivingQcNoteController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\TaxExemptReasonController;
use App\Http\Controllers\OpportunityStageController;
use App\Http\Controllers\ProductThicknessController;
use App\Http\Controllers\ReturnReasonCodeController;
use App\Http\Controllers\ProductPriceRangeController;
use App\Http\Controllers\ReleaseReasonCodeController;
use App\Http\Controllers\AccountPaymentTermController;
use App\Http\Controllers\ProbabilityToCloseController;
use App\Http\Controllers\DefaultLinkAccountController;
use App\Http\Controllers\TransactionStartingController;
use App\Http\Controllers\CustomerContactTitleController;
use App\Http\Controllers\SupplierReturnStatusController;
use App\Http\Controllers\PickTicketRestrictionController;
use App\Http\Controllers\PurchaseShipmentMethodController;
use App\Http\Controllers\CalculateMeasurementLabelController;
use App\Http\Controllers\AccountReceivableAgingPeriodController;
use App\Http\Controllers\InventoryAdjustmentReasonCodeController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('states', StateController::class);
    Route::get('/state/list', [StateController::class, 'getStateDataTableList'])->name('states.list');

    Route::resource('departments', DepartmentController::class);
    Route::get('/department/list', [DepartmentController::class, 'getDepartmentDataTableList'])->name('departments.list');

    Route::resource('project_types', ProjectTypeController::class);
    Route::get('/project_type/list', [ProjectTypeController::class, 'getProjectTypeDataTableList'])->name('project_types.list');

    Route::resource('sub_headings', SubHeadingController::class);
    Route::get('/sub_heading/list', [SubHeadingController::class, 'getSubHeadingDataTableList'])->name('sub_headings.list');

    Route::resource('bin_types', BinTypeController::class);
    Route::get('/bin_type/list', [BinTypeController::class, 'getBinTypeDataTable'])->name('bintypes.list');

    Route::resource('currencies', CurrencyController::class);
    Route::get('/currency/list', [CurrencyController::class, 'getCurrencyDataTable'])->name('currencies.list');

    Route::resource('file_types', FileTypeController::class);
    Route::get('/file_type/list', [FileTypeController::class, 'getFileTypeDataTableList'])->name('file_types.list');

    Route::resource('product_finishes', ProductFinishController::class);
    Route::get('/product_finish/list', [ProductFinishController::class, 'getProductFinishDataTableList'])->name('product_finishes.list');

    Route::resource('product_colors', ProductColorController::class);
    Route::get('/product_color/list', [ProductColorController::class, 'getProductColorDataTableList'])->name('product_colors.list');

    Route::resource('product_groups', ProductGroupController::class);
    Route::get('/product_group/list', [ProductGroupController::class, 'getProductGroupDataTableList'])->name('product_groups.list');

    Route::resource('countries', CountryController::class);
    Route::get('/country/list', [CountryController::class, 'getCountryDataTableList'])->name('countries.list');

    Route::resource('transaction_startings', TransactionStartingController::class);
    Route::get('/transaction_starting/list', [TransactionStartingController::class, 'getTransactionStartingDataTableList'])->name('transaction_startings.list');

    Route::resource('opportunity_stages', OpportunityStageController::class);
    Route::get('/opportunity_stage/list', [OpportunityStageController::class, 'getOpportunityStageDataTableList'])->name('opportunity_stages.list');

    Route::resource('probability_to_closes', ProbabilityToCloseController::class);
    Route::get('/probability_to_close/list', [ProbabilityToCloseController::class, 'getProbabilityToCloseDataTableList'])->name('probability_to_closes.list');

    Route::resource('release_reason_codes', ReleaseReasonCodeController::class);
    Route::get('/release_reason_code/list', [ReleaseReasonCodeController::class, 'getReleaseReasonCodeDataTableList'])->name('release_reason_codes.list');

    Route::resource('product_thicknesses', ProductThicknessController::class);
    Route::get('/product_thickness/list', [ProductThicknessController::class, 'getProductThicknessDataTableList'])->name('product_thicknesses.list');

    Route::resource('designations', DesignationController::class);
    Route::get('/designation/list', [DesignationController::class, 'getDesignationDataTable'])->name('designations.list');

    Route::resource('event_types', EventTypeController::class);
    Route::get('/event_type/list', [EventTypeController::class, 'getEventTypeDataTableList'])->name('event_types.list');

    Route::resource('calculate_measurement_labels', CalculateMeasurementLabelController::class);
    Route::get('/calculate_measurement_label/list', [CalculateMeasurementLabelController::class, 'getCalculateMeasurementLabelDataTableList'])->name('calculate_measurement_labels.list');

    Route::resource('end_use_segments', EndUseSegmentController::class);
    Route::get('/end_use_segment/list', [EndUseSegmentController::class, 'getEndUseSegementDataTableList'])->name('end_use_segments.list');

    Route::resource('about_us_options', AboutUsOptionController::class);
    Route::get('/about_us_option/list', [AboutUsOptionController::class, 'getAboutUsOptionDataTableList'])->name('about_us_options.list');

    Route::resource('customer_types', CustomerTypeController::class);
    Route::get('/customer_type/list', [CustomerTypeController::class, 'getCustomerTypeDataTableList'])->name('customer_types.list');

    Route::resource('unit_measures', UnitMeasureController::class);
    Route::get('/unit_measure/list', [UnitMeasureController::class, 'getUnitMeasureDataTableList'])->name('unit_measures.list');

    Route::resource('survey_questions', SurveyQuestionController::class);
    Route::get('/survey_question/list', [SurveyQuestionController::class, 'getSurveyQuestionDataTableList'])->name('survey_questions.list');
    Route::get('/survey_question/transaction_id', [SurveyQuestionController::class, 'getTransactionTypeBasedQuestion'])->name('survey_questions.transaction');

    Route::resource('shipment_methods', ShipmentMethodController::class);
    Route::get('/shipment_method/list', [ShipmentMethodController::class, 'getShipmentMethodDataTableList'])->name('shipment_methods.list');

    Route::resource('product_categories', ProductCategoryController::class);
    Route::get('/product_category/list', [ProductCategoryController::class, 'getProductCategoryDataTableList'])->name('product_categories.list');

    Route::resource('product_types', ProductTypeController::class);
    Route::get('/product_type/list', [ProductTypeController::class, 'getProductTypeDataTableList'])->name('product_types.list');
    Route::post('/updateDefaultvalue', [ProductTypeController::class, 'updateDefaultvalue'])->name('product_types.updateDefaultvalue');

    Route::resource('product_price_ranges', ProductPriceRangeController::class);
    Route::get('/product_price_range/list', [ProductPriceRangeController::class, 'getProductPriceRangeDataTableList'])->name('product_price_ranges.list');

    Route::resource('return_reason_codes', ReturnReasonCodeController::class);
    Route::get('/return_reason_code/list', [ReturnReasonCodeController::class, 'getReturnReasonCodeDataTableList'])->name('return_reason_codes.list');

    Route::resource('customer_contact_titles', CustomerContactTitleController::class);
    Route::get('/customer_contact_title/list', [CustomerContactTitleController::class, 'getCustomerContactTitleDataTableList'])->name('customer_contact_titles.list');

    Route::prefix('companies')->name('companies.')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::post('/store', [CompanyController::class, 'store'])->name('store');
        Route::get('/list', [CompanyController::class, 'getCompanyDataTableList'])->name('list');
        Route::delete('/{id}/delete', [CompanyController::class, 'destroy'])->name('delete');
        Route::get('/{id}/edit', [CompanyController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [CompanyController::class, 'update'])->name('update');
        Route::get('/{id}/show', [CompanyController::class, 'show'])->name('show');
    });

    Route::resource('adjustment_types', AdjustmentTypeController::class);
    Route::get('/adjustment_type/list', [AdjustmentTypeController::class, 'getAdjustmentTypeDataTableList'])->name('adjustment_types.list');

    Route::resource('inventory_adjustment_reason_codes', InventoryAdjustmentReasonCodeController::class);
    Route::get('/inventory_adjustment_reason_code/list', [InventoryAdjustmentReasonCodeController::class, 'getInventoryAdjustmentReasonCodeLabelDataTableList'])->name('inventory_adjustment_reason_codes.list');

    Route::resource('supplier_types', SupplierTypeController::class);
    Route::get('/supplier_type/list', [SupplierTypeController::class, 'getSupplierTypeDataTableList'])->name('supplier_types.list');

    Route::resource('vendor_types', VendorTypeController::class);
    Route::get('/vendor_type/list', [VendorTypeController::class, 'getVendorTypeDataTableList'])->name('vendor_types.list');

    Route::get('pick_ticket_restrictions', [PickTicketRestrictionController::class, 'index'])->name('pick_ticket_restrictions.index');
    Route::post('/pick_ticket_restriction/save', [PickTicketRestrictionController::class, 'save'])->name('pick_ticket_restrictions.save');

    Route::resource('shipment_terms', ShipmentTermController::class);
    Route::get('/shipment_term/list', [ShipmentTermController::class, 'getShipmentTermDataTableList'])->name('shipment_terms.list');

    Route::resource('supplier_ports', SupplierPortController::class);
    Route::get('/supplier_port/list', [SupplierPortController::class, 'getSupplierPortDataTableList'])->name('supplier_ports.list');

    Route::resource('supplier_return_statuses', SupplierReturnStatusController::class);
    Route::get('/supplier_return_status/list', [SupplierReturnStatusController::class, 'getSupplierReturnStatusDataTableList'])->name('supplier_return_statuses.list');

    Route::resource('receiving_qc_notes', ReceivingQcNoteController::class);
    Route::get('/receiving_qc_note/list', [ReceivingQcNoteController::class, 'getReceivingQcNoteDataTableList'])->name('receiving_qc_notes.list');

    Route::resource('purchase_shipment_methods', PurchaseShipmentMethodController::class);
    Route::get('/purchase_shipment_method/list', [PurchaseShipmentMethodController::class, 'getPurchaseShipmentMethodDataTableList'])->name('purchase_shipment_methods.list');

    Route::resource('account_types', AccountTypeController::class);
    Route::get('/account_type/list', [AccountTypeController::class, 'getAccountTypeDataTableList'])->name('account_types.list');

    Route::resource('account_payment_terms', AccountPaymentTermController::class);
    Route::get('/account_payment_term/list', [AccountPaymentTermController::class, 'getAccountPaymentTermDataTableList'])->name('account_payment_terms.list');

    Route::resource('tax_exempt_reasons', TaxExemptReasonController::class);
    Route::get('/tax_exempt_reason/list', [TaxExemptReasonController::class, 'getTaxExemptReasonDataTableList'])->name('tax_exempt_reasons.list');

    Route::resource('account_sub_types', AccountSubTypeController::class);
    Route::get('/account_sub_type/list', [AccountSubTypeController::class, 'getAccountSubTypeDataTableList'])->name('account_sub_types.list');

    Route::resource('linked_accounts', LinkedAccountController::class);
    Route::get('/linked_account/list', [LinkedAccountController::class, 'getLinkedAccountDataTableList'])->name('linked_accounts.list');

    Route::prefix('default_link_accounts')->name('default_link_accounts.')->group(function () {
        Route::get('/', [DefaultLinkAccountController::class, 'index'])->name('default_link_accounts.index');
        Route::post('/inventory_asset/save', [DefaultLinkAccountController::class, 'inventoryAssetSave'])->name('inventory_asset.save');
        Route::post('/inventory_in_transit_on_transfer/save', [DefaultLinkAccountController::class, 'inventoryInTransitOnTransferSave'])->name('inventory_in_transit_on_transfer.save');
        Route::post('/inventory_adjustment/save', [DefaultLinkAccountController::class, 'inventoryAdjustmentSave'])->name('inventory_adjustment.save');
        Route::post('/banking_payment/save', [DefaultLinkAccountController::class, 'bankingPaymentSave'])->name('banking_payment.save');
        Route::post('/other_charges_discounts_variance/save', [DefaultLinkAccountController::class, 'otherChargesDiscountsVarianceSave'])->name('other_charges_discounts_variance.save');
        Route::post('/sale/save', [DefaultLinkAccountController::class, 'saleSave'])->name('sale.save');
        Route::post('/accounting/save', [DefaultLinkAccountController::class, 'accountingSave'])->name('accounting.save');
        Route::post('/banking_receipt/save', [DefaultLinkAccountController::class, 'bankingReceiptSave'])->name('banking_receipt.save');
    });
    Route::resource('expense_categories', ExpenseCategoryController::class);
    Route::get('/expense_category/list', [ExpenseCategoryController::class, 'getExpenseCategoryDataTableList'])->name('expense_categories.list');

    Route::resource('payment_methods', PaymentMethodController::class);
    Route::get('/payment_method/list', [PaymentMethodController::class, 'getPaymentMethodDataTableList'])->name('payment_methods.list');

    Route::get('account_receivable_aging_periods', [AccountReceivableAgingPeriodController::class, 'index'])->name('account_receivable_aging_periods.index');
    Route::post('/account_receivable_aging_period/save', [AccountReceivableAgingPeriodController::class, 'save'])->name('account_receivable_aging_periods.save');
});
