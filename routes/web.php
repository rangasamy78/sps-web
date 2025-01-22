<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BinTypeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MyEventController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TaxCodeController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TermTypeController;
use App\Http\Controllers\VendorPoController;
use App\Http\Controllers\AssociateController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubHeadingController;
use App\Http\Controllers\VendorTypeController;
use App\Http\Controllers\AccountFileController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\FreightBillController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\ProductFileController;
use App\Http\Controllers\ProductKindController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UnitMeasureController;
use App\Http\Controllers\QuoteFooterController;
use App\Http\Controllers\QuoteHeaderController;
use App\Http\Controllers\SampleOrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ShipmentTermController;
use App\Http\Controllers\SupplierPortController;
use App\Http\Controllers\SupplierTypeController;
use App\Http\Controllers\TaxAuthorityController;
use App\Http\Controllers\TaxComponentController;
use App\Http\Controllers\VendorPoFileController;
use App\Http\Controllers\AboutUsOptionController;
use App\Http\Controllers\AgingPeriodAPController;
use App\Http\Controllers\EndUseSegmentController;
use App\Http\Controllers\EventCalendarController;
use App\Http\Controllers\FreightVendorController;
use App\Http\Controllers\LinkedAccountController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductFinishController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\VisitCalendarController;
use App\Http\Controllers\AccountSubTypeController;
use App\Http\Controllers\AdjustmentTypeController;
use App\Http\Controllers\PriceListLabelController;
use App\Http\Controllers\ShipmentMethodController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\BatchCloseQuoteController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\PrePurchaseTermController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ReceivingQcNoteController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\Visit\VisitFileController;
use App\Http\Controllers\SupplierInvoiceController;
use App\Http\Controllers\TaxExemptReasonController;
use App\Http\Controllers\Quote\QuoteFileController;
use App\Http\Controllers\OpportunityStageController;
use App\Http\Controllers\QuotePrintedNoteController;
use App\Http\Controllers\ProductThicknessController;
use App\Http\Controllers\ReturnReasonCodeController;
use App\Http\Controllers\ProductPriceRangeController;
use App\Http\Controllers\ReleaseReasonCodeController;
use App\Http\Controllers\UserProfileUpdateController;
use App\Http\Controllers\AccountPaymentTermController;
use App\Http\Controllers\CreditCheckSettingController;
use App\Http\Controllers\DefaultLinkAccountController;
use App\Http\Controllers\PrePurchaseRequestController;
use App\Http\Controllers\PrintDocDisclaimerController;
use App\Http\Controllers\ProbabilityToCloseController;
use App\Http\Controllers\SelectTypeCategoryController;
use App\Http\Controllers\SpecialAccountTypeController;
use App\Http\Controllers\SpecialInstructionController;
use App\Http\Controllers\QuoteStageDashboardController;
use App\Http\Controllers\TransactionStartingController;
use App\Http\Controllers\CustomerContactTitleController;
use App\Http\Controllers\SupplierReturnStatusController;
use App\Http\Controllers\PickTicketRestrictionController;
use App\Http\Controllers\SelectTypeSubCategoryController;
use App\Http\Controllers\Supplier\SupplierFileController;
use App\Http\Controllers\SupplierCostListLabelController;
use App\Http\Controllers\PrePurchaseRequestFileController;
use App\Http\Controllers\PurchaseShipmentMethodController;
use App\Http\Controllers\PrePurchaseRequestEventController;
use App\Http\Controllers\PrePurchaseResponseTermController;
use App\Http\Controllers\Quote\Lines\QuoteServiceController;
use App\Http\Controllers\CalculateMeasurementLabelController;
use App\Http\Controllers\PrePurchaseRequestProductController;
use App\Http\Controllers\Opportunity\OpportunityFileController;
use App\Http\Controllers\SampleOrder\SampleOrderFileController;
use App\Http\Controllers\AccountReceivableAgingPeriodController;
use App\Http\Controllers\InventoryAdjustmentReasonCodeController;
use App\Http\Controllers\Quote\Lines\QuoteReceiveDepositController;
use App\Http\Controllers\PrePurchaseRequestSupplierRequestController;
use App\Http\Controllers\Quote\Lines\QuoteOptionLineServiceController;
use App\Http\Controllers\Quote\Lines\QuoteOptionLineProductController;
use App\Http\Controllers\Visit\EventController as VisitEventController;
use App\Http\Controllers\Quote\EventController as QuoteEventController;
use App\Http\Controllers\Visit\ContactController as VisitContactController;
use App\Http\Controllers\Quote\Lines\QuoteProductPriceCalculatorController;
use App\Http\Controllers\Quote\ContactController as QuoteContactController;
use App\Http\Controllers\Customer\ContactController as CustomerContactController;
use App\Http\Controllers\Supplier\ContactController as SupplierContactController;
use App\Http\Controllers\SampleOrder\EventController as SampleOrderEventController;
use App\Http\Controllers\Hold\EventController as HoldEventController;
use App\Http\Controllers\Associate\ContactController as AssociateContactController;
use App\Http\Controllers\Opportunity\EventController as OpportunityEventController;
use App\Http\Controllers\Quote\Lines\QuoteProductController as QuoteProductController;
use App\Http\Controllers\SampleOrder\ContactController as SampleOrderContactController;
use App\Http\Controllers\Hold\ContactController as HoldContactController;
use App\Http\Controllers\Expenditure\ContactController as ExpenditureContactController;
use App\Http\Controllers\Hold\HoldFileController;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\Opportunity\ContactController as OpportunityContactController;
use App\Http\Controllers\Opportunity\OpportunityConvertController as ConvertController;
use App\Http\Controllers\Opportunity\ProductDetail\ProductListController as OpportunityProductListcontroller;

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

    Route::get('/user_profiles', [UserProfileController::class, 'index'])->name('user_profiles');

    Route::get('/user_profile_updates', [UserProfileUpdateController::class, 'index'])->name('user_profile_updates');
    Route::post('/user_profile_updates/{id}', [UserProfileUpdateController::class, 'update'])->name('user_profile_updates.update');

    Route::resource('states', StateController::class);
    Route::get('/state/list', [StateController::class, 'getStateDataTableList'])->name('states.list');
    Route::post('/state/import', [StateController::class, 'importStates'])->name('states.import');
    Route::get('/state/template_download', [StateController::class, 'stateTemplateDownload'])->name('state.template_download');

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
    Route::post('/file_type/import', [FileTypeController::class, 'importFileTypes'])->name('file_types.import');
    Route::get('/file_type/template_download', [FileTypeController::class, 'fileTypeTemplateDownload'])->name('file_type.template_download');

    Route::resource('product_finishes', ProductFinishController::class);
    Route::get('/product_finish/list', [ProductFinishController::class, 'getProductFinishDataTableList'])->name('product_finishes.list');

    Route::resource('product_colors', ProductColorController::class);
    Route::get('/product_color/list', [ProductColorController::class, 'getProductColorDataTableList'])->name('product_colors.list');

    Route::resource('product_groups', ProductGroupController::class);
    Route::get('/product_group/list', [ProductGroupController::class, 'getProductGroupDataTableList'])->name('product_groups.list');

    Route::resource('countries', CountryController::class);
    Route::get('/country/list', [CountryController::class, 'getCountryDataTableList'])->name('countries.list');

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
    Route::post('/product_types/save_default_value', [ProductTypeController::class, 'saveDefaultValue'])->name('product_types.save_default_value');

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
        Route::get('/company/count', [CompanyController::class, 'getCompanyCount'])->name('count');
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

    Route::resource('supplier_cost_list_labels', SupplierCostListLabelController::class);
    Route::get('/supplier_cost_list_label/list', [SupplierCostListLabelController::class, 'getSupplierCostListLabelDataTableList'])->name('supplier_cost_list_labels.list');

    Route::get('credit_check_settings', [CreditCheckSettingController::class, 'index'])->name('credit_check_settings.index');
    Route::post('/credit_check_setting/save', [CreditCheckSettingController::class, 'save'])->name('credit_check_settings.save');

    Route::resource('select_type_categories', SelectTypeCategoryController::class);
    Route::get('/select_type_category/list', [SelectTypeCategoryController::class, 'getSelectTypeCategoryDataTableList'])->name('select_type_categories.list');

    Route::resource('select_type_sub_categories', SelectTypeSubCategoryController::class);
    Route::get('/select_type_sub_category/list', [SelectTypeSubCategoryController::class, 'getSelectTypeSubCategoryDataTableList'])->name('select_type_sub_categories.list');

    Route::resource('print_doc_disclaimers', PrintDocDisclaimerController::class);
    Route::get('/print_doc_disclaimer/list', [PrintDocDisclaimerController::class, 'getPrintDocDisclaimerDataTableList'])->name('print_doc_disclaimers.list');
    Route::get('/get_sub_categories', [PrintDocDisclaimerController::class, 'getSubCategories'])->name('get_sub_categories');

    Route::resource('price_list_labels', PriceListLabelController::class);
    Route::get('/price_list_label/list', [PriceListLabelController::class, 'getPriceListLabelDataTableList'])->name('price_list_labels.list');

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

    Route::resource('account_payable_aging_periods', AgingPeriodAPController::class);
    Route::post('/account_payable_aging_period/save', [AgingPeriodAPController::class, 'save'])->name('account_payable_aging_periods.save');

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

    Route::resource('expense_categories', ExpenseCategoryController::class);
    Route::get('/expense_category/list', [ExpenseCategoryController::class, 'getExpenseCategoryDataTableList'])->name('expense_categories.list');

    Route::resource('payment_methods', PaymentMethodController::class);
    Route::get('/payment_method/list', [PaymentMethodController::class, 'getPaymentMethodDataTableList'])->name('payment_methods.list');

    Route::get('account_receivable_aging_periods', [AccountReceivableAgingPeriodController::class, 'index'])->name('account_receivable_aging_periods.index');
    Route::post('/account_receivable_aging_period/save', [AccountReceivableAgingPeriodController::class, 'save'])->name('account_receivable_aging_periods.save');

    Route::get('transaction_startings', [TransactionStartingController::class, 'index'])->name('transaction_startings.index');
    Route::post('/transaction_starting/save', [TransactionStartingController::class, 'save'])->name('transaction_startings.save');

    Route::resource('users', UserController::class);
    Route::get('/user/list', [UserController::class, 'getUserDataTableList'])->name('users.list');
    Route::get('/get_designation', [UserController::class, 'getDesignation'])->name('get_designation');

    Route::resource('counties', CountyController::class);
    Route::get('/county/list', [CountyController::class, 'getCountyDataTableList'])->name('counties.list');

    Route::resource('languages', LanguageController::class);
    Route::get('/language/list', [LanguageController::class, 'getLanguageDataTableList'])->name('languages.list');

    Route::resource('customers', CustomerController::class);
    Route::get('/customer/list', [CustomerController::class, 'getCustomerDataTableList'])->name('customers.list');
    Route::get('/customer/fetch-customer-billing-address', [CustomerController::class, 'fetchCustomerBillingAddress'])->name('customers.billing-address');
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::post('/upload-image', [CustomerController::class, 'customerUploadImage'])->name('upload');
        Route::get('/contacts/list/{type_id}', [CustomerContactController::class, 'getContactDataTableList'])->name('contacts.list');
        Route::post('/contacts/save', [CustomerContactController::class, 'contactSave'])->name('contacts.save');
        Route::get('/contacts/edit/{id}', [CustomerContactController::class, 'contactEdit'])->name('contacts.edit');
        Route::put('/contacts/update/{id}', [CustomerContactController::class, 'contactUpdate'])->name('contacts.update');
        Route::post('/update/status/{id}', [CustomerController::class, 'updateStatus'])->name('update_status');
    });

    Route::resource('product_kinds', ProductKindController::class);
    Route::get('/product_kind/list', [ProductKindController::class, 'getProductKindDataTableList'])->name('product_kinds.list');

    Route::resource('special_account_types', SpecialAccountTypeController::class);
    Route::get('/special_account_type/list', [SpecialAccountTypeController::class, 'getSpecialAccounttypeDataTableList'])->name('special_account_types.list');

    Route::resource('term_types', TermTypeController::class);
    Route::get('/term_type/list', [TermTypeController::class, 'getTermTypeDataTable'])->name('term_types.list');

    Route::resource('suppliers', SupplierController::class);
    Route::get('/supplier/list', [SupplierController::class, 'getSupplierDataTableList'])->name('suppliers.list');
    Route::get('/supplier/status/{id}', [SupplierController::class, 'updateStatus'])->name('suppliers.status');

    Route::post('/contact/save', [SupplierContactController::class, 'save'])->name('contacts.save');
    Route::get('/contact/list/{id}', [SupplierContactController::class, 'getSupplierContactDataTableList'])->name('supplier_contacts.list');

    Route::resource('supplier_files', SupplierFileController::class);
    Route::get('/supplier_file/list/{id}', [SupplierFileController::class, 'getSupplierFileDataTableList'])->name('supplier_files.list');

    Route::resource('accounts', AccountController::class);
    Route::get('/account/list', [AccountController::class, 'getAccountDataTableList'])->name('accounts.list');
    Route::get('/account/in_active_list', [AccountController::class, 'getInAccountDataTableList'])->name('accounts.in_active_list');
    Route::get('/account/status/{id}', [AccountController::class, 'updateStatus'])->name('accounts.status');
    Route::get('/account/is_subtype/{id}', [AccountController::class, 'getIsSubAccountOf'])->name('accounts.is_subtype');

    Route::resource('account_files', AccountFileController::class);
    Route::get('/account_file/list/{id}', [AccountFileController::class, 'getAccountFileDataTableList'])->name('account_files.list');

    Route::resource('expenditures', ExpenditureController::class);
    Route::get('/expenditure/list', [ExpenditureController::class, 'getExpenditureDataTableList'])->name('expenditures.list');
    Route::post('/expenditure_change_status/{id}', [ExpenditureController::class, 'expenditureChangeStatus'])->name('expenditures.expenditure_change_status');
    Route::prefix('expenditures')->name('expenditures.')->group(function () {
        Route::get('/contacts/list/{type_id}', [ExpenditureContactController::class, 'getContactDataTableList'])->name('contacts.list');
        Route::post('/contacts/save', [ExpenditureContactController::class, 'contactSave'])->name('contacts.save');
        Route::delete('/contacts/{id}/delete', [ExpenditureContactController::class, 'destroy'])->name('contacts.destroy');
    });

    Route::resource('associates', AssociateController::class);
    Route::get('/associate/list', [AssociateController::class, 'getAssociateDataTableList'])->name('associates.list');
    Route::post('/associate_change_status/{id}', [AssociateController::class, 'associateChangeStatus'])->name('associates.associate_change_status');

    Route::resource('products', ProductController::class);
    Route::get('/product/list', [ProductController::class, 'getProductDataTableList'])->name('products.list');
    Route::resource('product_files', ProductFileController::class);
    Route::get('/product_file/list', [ProductFileController::class, 'getProductFileDataTableList'])->name(name: 'product_files.list');

    Route::post('/contact/save', [AssociateContactController::class, 'save'])->name('contacts.save');
    Route::get('/contact/list', [AssociateContactController::class, 'getContactDataTableList'])->name('contacts.list');

    Route::post('/sub_category/{id}', [ProductController::class, 'getSubCategory'])->name('products.sub_category');
    Route::post('/product_change_status/{id}', [ProductController::class, 'productChangeStatus'])->name('products.product_change_status');
    Route::get('/price_update/{id}', [ProductController::class, 'productPriceUpdate'])->name('products.price_update');

    Route::get('/product/stock', [ProductController::class, 'stockProduct'])->name('products.stock');
    Route::get('/product/stock_list', [ProductController::class, 'getProductStockDataTableList'])->name('products.stock_list');

    Route::get('/product/price_list_product', [ProductController::class, 'priceListProduct'])->name('products.price_list_product');
    Route::get('/product/price_list_product_list', [ProductController::class, 'getProductpriceListDataTableList'])->name('products.price_list_product_list');

    Route::get('/product/product_search', [ProductController::class, 'productSearch'])->name('products.product_search');
    Route::get('/product/product_search_list', [ProductController::class, 'getProductSearchDataTableList'])->name('products.product_search_list');
    Route::get('/get_product_images', [ProductController::class, 'getProductImages']);

    Route::get('/product/customer_price_list_product', [ProductController::class, 'customerpriceListProduct'])->name('products.customer_price_list_product');
    Route::get('/product/customer_price_list_product_list', [ProductController::class, 'getcustomerProductpriceListDataTableList'])->name('products.customer_price_list_product_list');

    Route::get('/{id}/product_website', [ProductController::class, 'productWebsite'])->name('products.product_website');
    Route::put('/{id}/product_web', [ProductController::class, 'productWebsiteUpdate'])->name('products.product_web_update');
    Route::get('/{id}/product_image', [ProductController::class, 'productImage'])->name('products.product_image');
    Route::post('product/upload-files', [ProductController::class, 'uploadFiles'])->name('product.uploadFiles');

    // Route::post('/upload_image', [CustomerController::class, 'customerUploadImage'])->name('upload');
    // Route::post('/update/status/{id}', [CustomerController::class, 'updateStatus'])->name('update_status');

    Route::resource('tax_codes', TaxCodeController::class);
    Route::get('/tax_code/list', [TaxCodeController::class, 'getTaxCodeDataTableList'])->name('tax_codes.list');
    Route::get('/tax_code/get-account-number/{id}', [TaxCodeController::class, 'getGLAccountNumber'])->name('tax_codes.gl-account');

    Route::resource('tax_authorities', TaxAuthorityController::class);
    Route::get('/tax_authority/list', [TaxAuthorityController::class, 'getTaxAuthorityDataTableList'])->name('tax_authorities.list');

    Route::resource('tax_components', TaxComponentController::class);
    Route::get('/tax_component/list', [TaxComponentController::class, 'getTaxComponentDataTableList'])->name('tax_components.list');

    Route::resource('service_categories', ServiceCategoryController::class);
    Route::get('/service_category/list', [ServiceCategoryController::class, 'getServiceCategoryDataTableList'])->name('service_categories.list');

    Route::resource('service_types', ServiceTypeController::class);
    Route::get('/service_type/list', [ServiceTypeController::class, 'getServiceTypeDataTableList'])->name('service_types.list');

    Route::resource('services', ServiceController::class);
    Route::get('/service/list', [ServiceController::class, 'getServiceDataTableList'])->name('services.list');
    Route::post('/service_change_status/{id}', [ServiceController::class, 'serviceChangeStatus'])->name('services.service_change_status');
    Route::post('/services/upload', [ServiceController::class, 'serviceUploadImage'])->name('services.upload');

    Route::view('lists', 'lists.home')->name('lists');
    Route::resource('consignments', ConsignmentController::class);
    Route::get('/consignment/list/{status}', [ConsignmentController::class, 'getConsignmentDataTableList'])->name('consignments.list');
    Route::get('/consignment/customer_list', [ConsignmentController::class, 'getCustomerListDataTableList'])->name('consignments.customer_list');
    Route::get('/consignment/create_customer_list/{status}', [ConsignmentController::class, 'getCreateCustomerListDataTableList'])->name('consignments.create_customer_list');
    //Start pre_purchase_requests
    Route::resource('pre_purchase_requests', PrePurchaseRequestController::class);
    Route::get('/pre_purchase_request/list', [PrePurchaseRequestController::class, 'getPrePurchaseRequestDataTableList'])->name('pre_purchase_requests.list');
    Route::get('/get_supplier_address', [PrePurchaseRequestController::class, 'getSupplierAddress'])->name('get_supplier_address');
    Route::get('/get_purchase_location_address', [PrePurchaseRequestController::class, 'getPurchaseLocationAddress'])->name('get_purchase_location_address');
    Route::get('/get_shipto_location_address', [PrePurchaseRequestController::class, 'getShipToLocationAddress'])->name('get_ship_to_location_address');
    Route::get('/get-pre-purchase-term-policy', [PrePurchaseRequestController::class, 'getPrePurchaseTermPolicy'])->name('get_pre_purchase_term_policy');
    Route::get('/get_supplier_primary_address', [PrePurchaseRequestController::class, 'getSupplierPrimaryAddress'])->name('get_supplier_primary_address');
    Route::get('/get_contact_address', [PrePurchaseRequestController::class, 'getContactAddress'])->name('get_contact_address');
    Route::post('/internal_note/save', [PrePurchaseRequestController::class, 'internalNoteSave'])->name('internal_notes.store');
    Route::get('/internal_note/list', [PrePurchaseRequestController::class, 'getInternalNotes'])->name('internal_notes.list');
    Route::resource('pre_purchase_request_products', PrePurchaseRequestProductController::class);
    Route::get('/pre_purchase_request_product/list', [PrePurchaseRequestProductController::class, 'getPrePurchaseRequestProductDataTableList'])->name('pre_purchase_request_products.list');
    Route::resource('pre_purchase_request_events', PrePurchaseRequestEventController::class);
    Route::get('/pre_purchase_request_event/list', [PrePurchaseRequestEventController::class, 'getPrePurchaseRequestEventDataTableList'])->name('pre_purchase_request_events.list');
    Route::get('/get_pre_purchase_request_product_details', [PrePurchaseRequestProductController::class, 'getPrePurchaseRequestProductDetails'])->name('get_pre_purchase_request_product_details');
    Route::prefix('pre_purchase_request_files')->name('pre_purchase_request_files.')->group(function () {
        Route::get('/', [PrePurchaseRequestFileController::class, 'index'])->name('index');
        Route::post('/store', [PrePurchaseRequestFileController::class, 'store'])->name('store');
        Route::delete('/{id}/delete', [PrePurchaseRequestFileController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/edit', [PrePurchaseRequestFileController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [PrePurchaseRequestFileController::class, 'update'])->name('update');
        Route::get('/{id}/show', [PrePurchaseRequestFileController::class, 'show'])->name('show');
    });
    Route::get('/pre_purchase_request_file/list', [PrePurchaseRequestFileController::class, 'getPrePurchaseRequestFileDataTableList'])->name('pre_purchase_request_files.list');
    Route::resource('pre_purchase_supplier_requests', PrePurchaseRequestSupplierRequestController::class);
    Route::get('/pre_purchase_supplier_request/list', [PrePurchaseRequestSupplierRequestController::class, 'getPrePurchaseRequestSupplierRequestDataTableList'])->name('pre_purchase_supplier_requests.list');
    Route::get('pre_purchase/{id}/response', [PrePurchaseRequestFileController::class, 'prePurchaseResponse'])->name('pre_purchase.response');
    Route::get('pre_purchase_response/create/{pre_purchase_response_id}', [PrePurchaseResponseTermController::class, 'create'])->name('pre_purchase_response.create');
    Route::post('pre_purchase_response/store', [PrePurchaseResponseTermController::class, 'store'])->name('pre_purchase_response.store');
    Route::get('pre_purchase/{pre_purchase_request_id}/supplier/{supplier_request_id}/complete', [PrePurchaseResponseTermController::class, 'createComplete'])->name('pre_purchase.complete');
    Route::post('pre_purchase_response/complete', [PrePurchaseResponseTermController::class, 'completeStore'])->name('pre_purchase_complete.store');
    Route::post('/supplier-response-view', [PrePurchaseResponseTermController::class, 'SupplierResponseView'])->name('pre_purchase_compare.response');
    Route::post('/compare_update_status', [PrePurchaseResponseTermController::class, 'updateStatus'])->name('pre_purchase_compare.update.status');
    Route::post('/compare_reject_status', [PrePurchaseResponseTermController::class, 'rejectStatus'])->name('pre_purchase_compare.reject.status');
    Route::get('pre_purchase_multiple_request/create', [PrePurchaseRequestSupplierRequestController::class, 'multipleCreate'])->name('pre_purchase.multiple.create');
    Route::post('pre_purchase_request/multi_store', [PrePurchaseRequestSupplierRequestController::class, 'multipleStore'])->name('pre_purchase.multiple.store');
    Route::get('/get_supplier_details', [PrePurchaseRequestSupplierRequestController::class, 'getSupplierDetails'])->name('get_supplier_details');
    Route::get('/get_supplier_compare_details', [PrePurchaseRequestSupplierRequestController::class, 'getSupplierCompareDetails'])->name('get_supplier_compare_details');
    Route::resource('special_instructions', SpecialInstructionController::class);
    Route::get('/special_instruction/list', [SpecialInstructionController::class, 'getSpecialInstructionDataTableList'])->name('special_instructions.list');
    Route::resource('pre_purchase_terms', PrePurchaseTermController::class);
    Route::get('/pre_purchase_term/list', [PrePurchaseTermController::class, 'getPrePurchaseTermDataTableList'])->name('pre_purchase_terms.list');
    //End pre_purchase_requests
    Route::resource('visit_calendars', VisitCalendarController::class);
    Route::resource('quote_stages_dashboard', QuoteStageDashboardController::class);
    Route::get('/follow_ups', [FollowUpController::class, 'index'])->name('follow_ups.index');
    Route::resource('event_calendars', EventCalendarController::class);
    Route::resource('my_events', MyEventController::class);
    Route::get('/my_event/list', [MyEventController::class, 'getMyEventDataTableList'])->name('my_events.list');
    Route::post('/set_as_complete/{id}', [MyEventController::class, 'setAsComplete'])->name('my_events.set_as_complete');
    Route::get('/my_events/{event}', [MyEventController::class, 'show'])->name('my_event.show');

    Route::resource('vendor_pos', VendorPoController::class);
    Route::get('/vendor_po/list', [VendorPoController::class, 'getVendorPoDataTableList'])->name('vendor_pos.list');
    Route::get('/fetch_service_details', [VendorPoController::class, 'FetchServiceData'])->name('fetch_service_details');
    Route::get('/fetch_vendor_details/{id}', [VendorPoController::class, 'FetchVendorData'])->name('fetch_vendor_details');
    Route::get('/vendor_po/details/{id}', [VendorPoController::class, 'getVendorPoDetails'])->name('vendor_pos.details');
    Route::get('/vendor_po/po_details', [VendorPoController::class, 'FetchVendorPoDetails'])->name('vendor_pos.po_details');
    Route::resource('vendor_po_files', VendorPoFileController::class);
    Route::get('/vendor_po_file/list/{id}', [VendorPoFileController::class, 'getVendorPoFileDataTableList'])->name('vendor_po_files.list');
    Route::get('/vendor_po/pre_payment/{id}', [VendorPoController::class, 'prePayment'])->name('vendor_pos.pre_payment');
    Route::post('/vendor_po/prepayment/{id}', [VendorPoController::class, 'prepaymentSave'])->name('vendor_pos.prepaymentsave');
    Route::get('/vendor_po/Vpayment/{id}', [VendorPoController::class, 'Vpayment'])->name('vendor_pos.Vpayment');
    Route::get('/vendor_po/new_bill/{id}', [VendorPoController::class, 'newBill'])->name('vendor_pos.new_bill');
    Route::post('/vendor_po/new_bill/{id}', [VendorPoController::class, 'newBillSave'])->name('vendor_pos.new_billsave');
    Route::get('/vendor_po/new_bill_details/{id}', [VendorPoController::class, 'newBillDetails'])->name('vendor_pos.new_bill_details');
    Route::resource('freight_bills', FreightBillController::class);
    Route::get('/freight_bill/list', [FreightBillController::class, 'getFreightBillDataTableList'])->name('freight_bills.list');
    Route::resource('freight_vendors', FreightVendorController::class);
    Route::get('/freight_vendor/list', [FreightVendorController::class, 'getFreightVendorDataTableList'])->name('freight_vendors.list');
    Route::resource('purchase_orders', PurchaseOrderController::class);
    Route::get('/purchase_order/list', [PurchaseOrderController::class, 'getPurchaseOrderDataTableList'])->name('purchase_orders.list');
    Route::get('/purchase_order/purchase_details/{id}', [PurchaseOrderController::class, 'getPoDetails'])->name('purchase_orders.purchase_details');
    Route::get('/fetch_supplier_details/{id}', [PurchaseOrderController::class, 'FetchSupplierData'])->name('fetch_supplier_details');
    Route::post('/purchase_order/SaveProductPo', [PurchaseOrderController::class, 'PurchaseOrderPo'])->name('purchase_orders.po_product_save');
    Route::put('/purchase_order/update_product_po', [PurchaseOrderController::class, 'PurchaseOrderPoUpdate'])->name('purchase_orders.po_product_update');
    Route::get('/purchase_order/listPurchaseProduct', [PurchaseOrderController::class, 'getPurchaseProductDataTableList'])->name('purchase_orders.list_productpo');
    Route::get('/po_product_details/{id}', [PurchaseOrderController::class, 'FetchPoData'])->name('purchase_orders.po_product_details');
    Route::get('/purchase_order/po_details/{id}', [PurchaseOrderController::class, 'FetchPoDetails'])->name('purchase_orders.po_details');
    Route::get('/purchase_order/supplier_invoice/{id}', [PurchaseOrderController::class, 'SupplierInvoice'])->name('supplier_invoice.create');
    Route::post('/supplier_invoice/supplier_save', [PurchaseOrderController::class, 'SupplierInvoiceSave'])->name('supplier_invoice.supplier_save');
    Route::get('/supplier_invoice/supplier_invoice_packing/{id}', [PurchaseOrderController::class, 'SupplierInvoicePackingList'])->name('supplier_invoice.supplier_invoice_packing');
    Route::delete('/purchase-orders/{id}', [PurchaseOrderController::class, 'destroyPo']);
    Route::delete('/purchase_order/purchase_details/{id}', [PurchaseOrderController::class, 'deletePoDetails'])->name('deletePo');
    Route::get('/fetch_product_po_details/{id}', [PurchaseOrderController::class, 'FetchProductPoData'])->name('fetch_product_po_details');
    Route::get('/fetch_po_products/{id}', [PurchaseOrderController::class, 'FetchPoproductDetails'])->name('fetch_po_products');
    //OPPORTUNITY , VISIT,SAMPLE ORDER, QUOTE AND HOME PAGE
    Route::view('/pre_sales', 'pre_sales.home')->name('pre_sales');
    Route::view('/purchases', 'purchases.home')->name('purchases');
    Route::resource('opportunities', OpportunityController::class);
    Route::get('/opportunity/list', [OpportunityController::class, 'getOpportunityDataTableList'])->name('opportunities.list');
    Route::get('/subtransaction/list/{id}', [OpportunityController::class, 'getAllSubtransactionDataTableList'])->name('subtransactions.list');

    Route::get('/opportunity/ship_to_list/{id}', [OpportunityController::class, 'getAllShipToDataTableList'])->name('opportunities.ship_to_list');
    Route::get('/opportunity/customer_list', [OpportunityController::class, 'getAllCustomerDataTableList'])->name('opportunities.customer_list');
    Route::get('/opportunity/associate_list', [OpportunityController::class, 'getAllAssociateDataTableList'])->name('opportunities.associate_list');
    Route::patch('/opportunity/internal_notes/{id}', [OpportunityController::class, 'updateInternalNotes'])->name('opportunities.internal_notes');
    Route::patch('/opportunity/probability_close/{id}', [OpportunityController::class, 'updateProbabilityClose'])->name('opportunities.probability_close');
    Route::patch('/opportunity/stages/{id}', [OpportunityController::class, 'updateStages'])->name('opportunities.stages');
    Route::patch('/survey/{id}', [OpportunityController::class, 'updateSurveyRate'])->name('opportunities.survey');
    Route::prefix('opportunities')->name('opportunities.')->group(function () {
        Route::post('/contact/save', [OpportunityContactController::class, 'save'])->name('contact.save');
        Route::get('/contact/list/{id}', [OpportunityContactController::class, 'getOpportunityContactDataTableList'])->name('contacts.list');
        Route::delete('/contacts/{id}/delete', [OpportunityContactController::class, 'destroy'])->name('contacts.destroy');
        Route::get('/bill_to_contact/list/{id}', [OpportunityContactController::class, 'getOpportunityBillToContactDataTableList'])->name('bill_to_contacts.list');
        Route::delete('/bill_to_contact/{id}/delete', [OpportunityContactController::class, 'billTodestroy'])->name('bill_to_contacts.destroy');
    });

    Route::resource('opportunity_files', OpportunityFileController::class);
    Route::get('/opportunity_file/list/{id}', [OpportunityFileController::class, 'getOpportunityFileDataTableList'])->name('opportunity_files.list');
    Route::prefix('events')->group(function () {
        Route::resource('events', OpportunityEventController::class);
        Route::get('/event/list/{id}', [OpportunityEventController::class, 'getEventDataTableList'])->name('events.list');
        Route::get('/product_list', [OpportunityEventController::class, 'getAllProductDataTableList'])->name('events.product_list');
    });
    Route::prefix('product_lists')->name('products.')->group(function () {
        Route::get('/search_product', [OpportunityProductListcontroller::class, 'searchProduct'])->name('search_product');
        Route::get('/get-product', [OpportunityProductListcontroller::class, 'getProduct'])->name('get_product');
        Route::get('/get-product-price', [OpportunityProductListcontroller::class, 'getProductPrice'])->name('get_product_price');
        Route::get('/get-service-price', [OpportunityProductListcontroller::class, 'getServicePrice'])->name('get_service_price');
    });

    Route::resource('visits', VisitController::class);
    Route::get('/visit/opportunity_detail/{id}', [VisitController::class, 'getOpportunityDetail'])->name('visits.opportunity_detail');
    Route::get('/visit/list/{id}', [VisitController::class, 'getVisitProductDataTableList'])->name('visits.list');
    Route::get('/visit/show_add_product/{id}', [VisitController::class, 'showAddProduct'])->name('visits.show_add_product');
    Route::post('/save_visit_product', [VisitController::class, 'saveVisitProduct'])->name('visits.save_visit_product');
    Route::get('/edit_visit_product/{id}', [VisitController::class, 'editVisitProduct'])->name('visits.edit_visit_product');
    Route::put('/update_visit_product/{id}', [VisitController::class, 'updateVisitProduct'])->name('visits.update_visit_product');
    Route::delete('/delete_visit_product/{id}', [VisitController::class, 'deleteVisitProduct'])->name('visits.delete_visit_product');
    Route::patch('/update_visit_checkout/{id}', [VisitController::class, 'updateCheckout'])->name('visits.checkout');
    Route::patch('/update_visit_survey/{id}', [VisitController::class, 'updateSurveyRate'])->name('visits.survey');


    Route::prefix('visit_lists')->name('visit.lists.')->group(function () {
        Route::get('/list', [VisitController::class, 'getVisitDataTableList'])->name('list');
        Route::get('/list/{id}', [VisitController::class, 'getAllVisitDataTableList'])->name('list_all');
    });

    Route::prefix('visit_opportunities')->name('visit.opportunities.')->group(function () {
        Route::get('/index', [VisitController::class, 'indexOpportunityVisit'])->name('index');
        Route::post('/save', [VisitController::class, 'saveOpportunityVisit'])->name('save');
        Route::get('/edit/{id}', [VisitController::class, 'editOpportunityVisit'])->name('edit');
        Route::put('/update/{id}', [VisitController::class, 'updateOpportunityVisit'])->name('update');
    });

    Route::resource('visit_files', VisitFileController::class);
    Route::get('/visit_file/list/{id}', [VisitFileController::class, 'getVisitFileDataTableList'])->name('visit_files.list');

    Route::prefix('visit_events')->group(function () {
        Route::resource('visit_events', VisitEventController::class);
        Route::get('/visit_event/list/{id}', [VisitEventController::class, 'getVisitEventDataTableList'])->name('visit_events.list');
    });

    Route::prefix('visits')->name('visits.')->group(function () {
        Route::post('/contact/save', [VisitContactController::class, 'save'])->name('contact.save');
        Route::get('/contact/list/{id}', [VisitContactController::class, 'getCustomerContactDataTableList'])->name('contacts.list');
        Route::delete('/contacts/{id}/delete', [VisitContactController::class, 'destroy'])->name('contacts.destroy');
        Route::patch('/probability_close/{id}', [VisitController::class, 'updateProbabilityClose'])->name('probability_close');
    });
    Route::prefix('sample_orders')->name('create.')->group(function () {
        Route::resource('sample_orders', SampleOrderController::class);
        Route::get('/list', [SampleOrderController::class, 'getSampleOrderDataTableList'])->name('list');
        Route::get('/list/{id}', [SampleOrderController::class, 'getAllSampleOrderDataTableList'])->name('list_all');

        Route::get('/index/{id}', [SampleOrderController::class, 'indexSampleOrder'])->name('index_sample_order');
        Route::get('/index/product/{id}', [SampleOrderController::class, 'indexProductSampleOrder'])->name('index_product');
        Route::post('/save_product', [SampleOrderController::class, 'saveSampleOrderProduct'])->name('save_product');
        Route::get('/product/list/{id}', [SampleOrderController::class, 'getSampleOrderProductDataTableList'])->name('products.list');
        Route::get('/edit_product/{id}', [SampleOrderController::class, 'editSampleOrderProduct'])->name('edit_product');
        Route::put('/update_product/{id}', [SampleOrderController::class, 'updateSampleOrderProduct'])->name('update_product');
        Route::delete('/delete_product/{id}', [SampleOrderController::class, 'deleteSampleOrderProduct'])->name('delete_product');
        Route::patch('/probability_close/{id}', [SampleOrderController::class, 'updateProbabilityClose'])->name('probability_close');
        Route::patch('/status/{id}', [SampleOrderController::class, 'updateStatus'])->name('status');
        //sample order and opportunity
        Route::get('/index', [SampleOrderController::class, 'indexOpportunitySampleOrder'])->name('index');
        Route::post('/save', [SampleOrderController::class, 'saveOpportunitySampleOrder'])->name('save');
        Route::get('/edit/{id}', [SampleOrderController::class, 'editOpportunitySampleOrder'])->name('edit');
        Route::put('/update/{id}', [SampleOrderController::class, 'updateOpportunitySampleOrder'])->name('update');
        //sample order
        Route::resource('sample_order_files', SampleOrderFileController::class);
        Route::get('/sample_order_file/list/{id}', [SampleOrderFileController::class, 'getSampleOrderFileDataTableList'])->name('sample_order_files.list');
        //event
        Route::resource('sample_order_events', SampleOrderEventController::class);
        Route::get('/sample_order_event/list/{id}', [SampleOrderEventController::class, 'getSampleOrderEventDataTableList'])->name('sample_order_events.list');
        //contact
        Route::post('/contact/save', [SampleOrderContactController::class, 'save'])->name('contact.save');
        Route::get('/contact/list/{id}', [SampleOrderContactController::class, 'getCustomerContactDataTableList'])->name('contacts.list');
        Route::delete('/contacts/{id}/delete', [SampleOrderContactController::class, 'destroy'])->name('contacts.destroy');
    });
    //quote header
    Route::resource('quote_headers', QuoteHeaderController::class);
    Route::get('/quote_header/list', [QuoteHeaderController::class, 'getQuoteHeaderDataTableList'])->name('quote_headers.list');

    //quote footer
    Route::resource('quote_footers', QuoteFooterController::class);
    Route::get('/quote_footer/list', [QuoteFooterController::class, 'getQuoteFooterDataTableList'])->name('quote_footers.list');

    //quote printed note
    Route::resource('quote_printed_notes', QuotePrintedNoteController::class);
    Route::get('/quote_printed_note/list', [QuotePrintedNoteController::class, 'getQuotePrintedNoteDataTableList'])->name('quote_printed_notes.list');

    //quote
    Route::prefix('quotes')->name('quote.')->group(function () {
        Route::resource('quotes', QuoteController::class);
        Route::get('/index/{id}', [QuoteController::class, 'indexQuote'])->name('index_quote');
        Route::get('/list', [QuoteController::class, 'getQuoteDataTableList'])->name('list');
        Route::get('/list_all/{id}', [QuoteController::class, 'getAllQuoteDataTableList'])->name('list_all');
        Route::patch('internal_notes/{id}', [QuoteController::class, 'updateInternalNotes'])->name('internal_notes');
        Route::patch('/probability_close/{id}', [QuoteController::class, 'updateProbabilityClose'])->name('probability_close');
        Route::patch('/survey/{id}', [QuoteController::class, 'updateSurveyRate'])->name('survey');
        Route::patch('/status/{id}', [QuoteController::class, 'updateQuoteStatus'])->name('status');
        //quote and opportunity
        Route::get('/index', [QuoteController::class, 'indexOpportunityQuote'])->name('index');
        Route::post('/save', [QuoteController::class, 'saveOpportunityQuote'])->name('save');
        // quote Product
        Route::resource('quote_products', QuoteProductController::class);
        Route::get('/product_list', [QuoteProductController::class, 'getAllProductDataTableList'])->name('product_list');
        Route::get('/service_product_list/{id}', [QuoteProductController::class, 'getAllServiceProductDataTableList'])->name('service_product_list');
        //optinal line product
        Route::resource('quote_option_line_products', QuoteOptionLineProductController::class);
        Route::get('/option_line_product', [QuoteOptionLineProductController::class, 'getAllOptionLineProductDataTableList'])->name('option_line_product');
        Route::get('lists/{id}', [QuoteOptionLineProductController::class, 'show'])->name('option_line_product_lists');
        // quote Service
        Route::resource('quote_services', QuoteServiceController::class);
        Route::get('/service_list', [QuoteServiceController::class, 'getAllServiceDataTableList'])->name('service_list');
        //optinal line service
        Route::resource('quote_option_line_services', QuoteOptionLineServiceController::class);
        Route::get('/option_line_service', [QuoteOptionLineServiceController::class, 'getAllOptionLineServiceDataTableList'])->name('option_line_service');
        Route::get('/get-service', [QuoteOptionLineServiceController::class, 'getService'])->name('get_service');
        Route::get('option_line_service_list/{id}', [QuoteOptionLineServiceController::class, 'show'])->name('option_line_service_lists');
        //price calulator from cost
        Route::get('supplier_detail/{id}', [QuoteProductPriceCalculatorController::class, 'getSupplierDetail'])->name('supplier_detail');
        Route::get('tax_amount/{id}', [QuoteProductPriceCalculatorController::class, 'getTaxAmount'])->name('tax_amount');
        Route::Post('price_calculator_store', [QuoteProductPriceCalculatorController::class, 'store'])->name('price_calculator_store');
        Route::get('price_calculator_show/{id}', [QuoteProductPriceCalculatorController::class, 'show'])->name('price_calculator_show');
        Route::delete('/price_calculator_inventory/{id}', [QuoteProductPriceCalculatorController::class, 'destroy'])->name('price_calculator_inventory_delete');
        //recieve deposit
        Route::get('/receive_deposit/index/{id}', [QuoteReceiveDepositController::class, 'index'])->name('receive_index');
        Route::post('/receive_deposit/store', [QuoteReceiveDepositController::class, 'store'])->name('receive_store');
        // contact
        Route::resource('contacts', QuoteContactController::class);
        Route::get('/list/{id}', [QuoteContactController::class, 'getAllQuoteContactDataTableList'])->name('contact_list');
        Route::get('/customer_contact/list/{id}', [QuoteContactController::class, 'getCustomerContactDataTableList'])->name('customer_contact_list');
        Route::delete('/customer_contact/{id}/delete', [QuoteContactController::class, 'customerContactDestroy'])->name('customer_contact.destroy');
        //file
        Route::resource('files', QuoteFileController::class);
        Route::get('/quote_file/list/{id}', [QuoteFileController::class, 'getQuoteFileDataTableList'])->name('quote_file.list');
        //event
        Route::resource('events', QuoteEventController::class);
        Route::get('/event/list/{id}', [QuoteEventController::class, 'getQuoteEventDataTableList'])->name('events.list');
    });

    //hold
    Route::prefix('holds')->name('hold.')->group(function () {
        Route::resource('holds', HoldController::class);
        Route::get('/index/{id}', [HoldController::class, 'indexHold'])->name('index_hold');
        Route::get('/list', [HoldController::class, 'getHoldDataTableList'])->name('hold_list');
        Route::get('/index_product/{id}', [HoldController::class, 'indexProductHold'])->name('index_product');
        Route::post('/save_product', [HoldController::class, 'saveHoldProduct'])->name('save_product');
        Route::get('/product/list/{id}', [HoldController::class, 'getHoldProductDataTableList'])->name('products.list');
        Route::get('/edit_product/{id}', [HoldController::class, 'editHoldProduct'])->name('edit_product');
        Route::delete('/delete_product/{id}', [HoldController::class, 'deleteHoldProduct'])->name('delete_product');
        Route::patch('/probability_close/{id}', [HoldController::class, 'updateProbabilityClose'])->name('probability_close');
        Route::patch('internal_notes/{id}', [HoldController::class, 'updateInternalNotes'])->name('internal_notes');
        Route::patch('/survey/{id}', [HoldController::class, 'updateSurveyRate'])->name('survey');
        Route::get('/index_release/{id}', [HoldController::class, 'indexHoldRelease'])->name('index_release');
        Route::post('/update_release', [HoldController::class, 'updateHoldRelease'])->name('update_release');
        //hold and opportunity
        Route::get('/index', [HoldController::class, 'indexOpportunityHold'])->name('index');
        Route::post('/save', [HoldController::class, 'saveOpportunityHold'])->name('save');
        //hold file
        Route::resource('hold_files', HoldFileController::class);
        Route::get('/hold_file/list/{id}', [HoldFileController::class, 'getHoldFileDataTableList'])->name('hold_files.list');
        //event
        Route::resource('hold_events', HoldEventController::class);
        Route::get('/hold_event/list/{id}', [HoldEventController::class, 'getHoldEventDataTableList'])->name('hold_events.list');
        //  //contact
        Route::post('/contact/save', [HoldContactController::class, 'save'])->name('contact.save');
        Route::get('/contact/list/{id}', action: [HoldContactController::class, 'getCustomerContactDataTableList'])->name('contacts.list');
        Route::delete('/contacts/{id}/delete', [HoldContactController::class, 'destroy'])->name('contacts.destroy');
    });
    Route::prefix('converts')->name('convert.')->group(function () {
        //visits converts
        Route::get('/convert_visit/index/{id}', [VisitController::class, 'indexConvertSampleAndQuote'])->name('convert_visit');
        Route::post('/save_convert_visit', [ConvertController::class, 'saveConvertVisit'])->name('save_convert_visit');
        //sample order converts
        Route::get('/convert_sample_order/index/{id}', [SampleOrderController::class, 'indexConvertVisitAndQuote'])->name('convert_sample_order');
        Route::post('/save_convert_sample_order', [ConvertController::class, 'saveConvertSampleOrder'])->name('save_convert_sample_order');
        // quote converts
        Route::get('/convert_quote/index/{id}', [QuoteController::class, 'indexConvertVisitAndSample'])->name('convert_quote');
        Route::post('/save_convert_quote', [ConvertController::class, 'saveConvertQuote'])->name('save_convert_quote');
    });
    //END OPPORTUNITY , VISIT, sample order ,quote AND HOME PAGE

    Route::get('/purchase_order/po_details', [PurchaseOrderController::class, 'getPoProductPoDataTableList'])->name('purchase_orders.po_product_details');
    Route::resource('supplier_invoices', SupplierInvoiceController::class);
    Route::get('/supplier_invoice/list', [SupplierInvoiceController::class, 'getSupplierInvoiceDataTableList'])->name('supplier_invoices.list');
    Route::get('batch_close_quotes', [BatchCloseQuoteController::class, 'index'])->name('batch_close_quotes.index');
    Route::get('/batch_close_quote/list', [BatchCloseQuoteController::class, 'getBatchCloseQuoteDataTableList'])->name('batch_close_quotes.list');
    Route::post('/batch_close_quote/updatestatus', [BatchCloseQuoteController::class, 'updatestatus'])->name('batch_close_quotes.updatestatus');
});
