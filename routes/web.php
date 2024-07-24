<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\BinTypeController;
use App\Http\Controllers\CalculateMeasurementLabelController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\ProductFinishController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\SubHeadingController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\TransactionStartingController;
use App\Http\Controllers\OpportunityStageController;
use App\Http\Controllers\ProbabilityToCloseController;
use App\Http\Controllers\ReleaseReasonCodeController;
use App\Http\Controllers\ProductThicknessController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EndUseSegmentController;
use App\Http\Controllers\AboutUsOptionController;
use App\Http\Controllers\ShipmentMethodController;
use App\Http\Controllers\CustomerContactTitleController;

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

    Route::resource('shipment_methods', ShipmentMethodController::class);
    Route::get('/shipment_method/list', [ShipmentMethodController::class, 'getShipmentMethodDataTableList'])->name('shipment_methods.list');

    Route::resource('customer_contact_titles', CustomerContactTitleController::class);
    Route::get('/customer_contact_title/list', [CustomerContactTitleController::class, 'getCustomerContactTitleDataTableList'])->name('customer_contact_titles.list');
});
