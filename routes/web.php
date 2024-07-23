<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\BinTypeController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\ProductFinishController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\SubHeadingController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\TransactionStartingController;
use App\Http\Controllers\OpportunityStageController;
use App\Http\Controllers\ProbabilityToCloseController;

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

    Route::resource('event_types', EventTypeController::class);
    Route::get('/event_type/list', [EventTypeController::class, 'getEventTypeDataTableList'])->name('event_types.list');

});
