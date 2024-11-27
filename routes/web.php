<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TaxCodeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BinTypeController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AssociateController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubHeadingController;
use App\Http\Controllers\VendorTypeController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\ProductFileController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AccountFileController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\ProductKindController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UnitMeasureController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TaxComponentController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ShipmentTermController;
use App\Http\Controllers\SupplierPortController;
use App\Http\Controllers\SupplierTypeController;
use App\Http\Controllers\TaxAuthorityController;
use App\Http\Controllers\AboutUsOptionController;
use App\Http\Controllers\AgingPeriodAPController;
use App\Http\Controllers\EndUseSegmentController;
use App\Http\Controllers\LinkedAccountController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductFinishController;
use App\Http\Controllers\AccountSubTypeController;
use App\Http\Controllers\AdjustmentTypeController;
use App\Http\Controllers\PriceListLabelController;
use App\Http\Controllers\ShipmentMethodController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ReceivingQcNoteController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\TaxExemptReasonController;
use App\Http\Controllers\OpportunityStageController;
use App\Http\Controllers\ProductThicknessController;
use App\Http\Controllers\ReturnReasonCodeController;
use App\Http\Controllers\ProductPriceRangeController;
use App\Http\Controllers\ReleaseReasonCodeController;
use App\Http\Controllers\UserProfileUpdateController;
use App\Http\Controllers\AccountPaymentTermController;
use App\Http\Controllers\CreditCheckSettingController;
use App\Http\Controllers\DefaultLinkAccountController;
use App\Http\Controllers\PrintDocDisclaimerController;
use App\Http\Controllers\ProbabilityToCloseController;
use App\Http\Controllers\SelectTypeCategoryController;
use App\Http\Controllers\SpecialAccountTypeController;
use App\Http\Controllers\TransactionStartingController;
use App\Http\Controllers\SupplierReturnStatusController;
use App\Http\Controllers\CustomerContactTitleController;
use App\Http\Controllers\PickTicketRestrictionController;
use App\Http\Controllers\SupplierCostListLabelController;
use App\Http\Controllers\Supplier\SupplierFileController;
use App\Http\Controllers\SelectTypeSubCategoryController;
use App\Http\Controllers\PurchaseShipmentMethodController;
use App\Http\Controllers\CalculateMeasurementLabelController;
use App\Http\Controllers\Opportunity\OpportunityFileController;
use App\Http\Controllers\AccountReceivableAgingPeriodController;
use App\Http\Controllers\InventoryAdjustmentReasonCodeController;
use App\Http\Controllers\Supplier\ContactController as SupplierContactController;
use App\Http\Controllers\Customer\ContactController as CustomerContactController;
use App\Http\Controllers\Associate\ContactController as AssociateContactController;
use App\Http\Controllers\Opportunity\EventController as OpportunityEventController;
use App\Http\Controllers\Expenditure\ContactController as ExpenditureContactController;
use App\Http\Controllers\Opportunity\ContactController as OpportunityContactController;

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

    Route::post('/upload_image', [CustomerController::class, 'customerUploadImage'])->name('upload');
    Route::post('/update/status/{id}', [CustomerController::class, 'updateStatus'])->name('update_status');

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
    //OPPORTUNITY , VISIT AND HOME PAGE
    Route::view('/pre_sales', 'pre_sales.home')->name('pre_sales');
    Route::view('/purchases', 'purchases.home')->name('purchases');
    Route::resource('opportunities', OpportunityController::class);
    Route::get('/opportunity/list', [OpportunityController::class, 'getOpportunityDataTableList'])->name('opportunities.list');
    Route::get('/opportunity/ship_to_list/{id}', [OpportunityController::class, 'getAllShipToDataTableList'])->name('opportunities.ship_to_list');
    Route::get('/opportunity/customer_list', [OpportunityController::class, 'getAllCustomerDataTableList'])->name('opportunities.customer_list');
    Route::get('/opportunity/associate_list', [OpportunityController::class, 'getAllAssociateDataTableList'])->name('opportunities.associate_list');
    Route::patch('/opportunity/internal_notes/{id}', [OpportunityController::class, 'updateInternalNotes'])->name('opportunities.internal_notes');
    Route::patch('/opportunity/probability_close/{id}', [OpportunityController::class, 'updateProbabilityClose'])->name('opportunities.probability_close');
    Route::patch('/opportunity/stages/{id}', [OpportunityController::class, 'updateStages'])->name('opportunities.stages');
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
        Route::get('/event/list', [OpportunityEventController::class, 'getEventDataTableList'])->name('events.list');
        Route::get('/product_list', [OpportunityEventController::class, 'getAllProductDataTableList'])->name('events.product_list');
    });
    Route::resource('visits', VisitController::class);
    Route::get('/visit/list/{id}', [VisitController::class, 'getVisitProductDataTableList'])->name('visits.list');
    Route::get('/visit/show_add_product/{id}', [VisitController::class, 'showAddProduct'])->name('visits.show_add_product');
    Route::get('/visit/search_product', [VisitController::class, 'searchProduct'])->name('visits.search_product');
    Route::get('/get-product', [VisitController::class, 'getProduct'])->name('visits.get_product');
    Route::get('/get-product-price', [VisitController::class, 'getProductPrice'])->name('visits.get_product_price');
    Route::post('/save_visit_product', [VisitController::class, 'saveVisitProduct'])->name('visits.save_visit_product');
    Route::get('/edit_visit_product/{id}', [VisitController::class, 'editVisitProduct'])->name('visits.edit_visit_product');
    Route::put('/update_visit_product/{id}', [VisitController::class, 'updateVisitProduct'])->name('visits.update_visit_product');
    Route::delete('/delete_visit_product/{id}', [VisitController::class, 'deleteVisitProduct'])->name('visits.delete_visit_product');
    Route::get('/visit/opportunity_detail/{id}', [VisitController::class, 'getOpportunityDetail'])->name('visits.opportunity_detail');
    //END OPPORTUNITY , VISIT AND HOME PAGE
});
