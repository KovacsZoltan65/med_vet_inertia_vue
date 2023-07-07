<?php

//use App\Http\Controllers\PostController;


use App\Http\Controllers\AddressController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EnumController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\HumanController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoleController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // -------------
    // ROLES
    // -------------
    Route::post('/roles/grid-data', [RoleController::class, 'getRoles'])
        ->name('roles_grid_data');
    Route::resource('/roles', RoleController::class)
        ->names([
            'index' => 'roles',
            'store' => 'roles_store',
            'update' => 'roles_update',
            'delete' => 'roles_delete',
    ]);

    // -------------
    // CLIENTS
    // -------------
    // clients ondec oldal
    //Route::get('/clients/grid', 'ClientController@grid')->name('clients_grid');
    Route::get('/clients/grid', [\App\Http\Controllers\ClientController::class, 'grid'])->name('clients_grid');

    // grid adatok lekérése
    //Route::post('/clients/grid-data', 'ClientController@gridData')->name('clients_grid_data');
    Route::post('/clients/grid-data', [\App\Http\Controllers\ClientController::class, 'gridData'])->name('clients_grid_data');

    // client létrehozása
    //Route::post('/clients', 'ClientController@store')->name('clients_store');
    Route::post('/clients', [\App\Http\Controllers\ClientController::class, 'store'])->name('clients_store');
    
    // client adatok frissítésa
    //Route::put('/clients/{client}', 'ClientController@update')->name('clients_update');
    Route::put('/clients/{client}', [\App\Http\Controllers\ClientController::class, 'update'])->name('clients_update');

    // client törlése
    //Route::delete('clients/{client}', 'ClientController@delete')->name('clients_delete');
    Route::delete('clients/{client}', [\App\Http\Controllers\ClientController::class, 'delete'])->name('clients_delete');

    // 
    //Route::get('/clients', 'ClientController@index')->name('clients');
    Route::get('/clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('clients');

    // -------------
    // PERMISSIONS
    // -------------
    
    // -------------
    // COMPANIES
    // -------------
    Route::post('/companies/grid-data', [\App\Http\Controllers\CompanyController::class, 'gridData'])
        ->name('companies_grid_data');
    
    // Létrehozás
    //Route::post('/companies', [\App\Http\Controllers\CompanyController::class, 'store'])->name('companies_store');
    
    // Módosítás
    //Route::put('/companies/{company}', [\App\Http\Controllers\CompanyController::class, 'update'])->name('companies_update');
    

    // Törlés
    Route::delete('/companies/delete', [\App\Http\Controllers\CompanyController::class, 'delete_company'])->name('companies_delete');
    Route::resource('companies', \App\Http\Controllers\CompanyController::class)->names([
        'index' => 'companies',
        'store' => 'companies_store',
        'update' => 'companies_update',
    ]);

    // -------------
    // OFFICES
    // -------------
    Route::get('/get_offices', [OfficeController::class, 'get_offices'])
        ->name('get_offices');
    Route::resource('/offices', OfficeController::class)->names([
        'index' => 'offices',
    ]);

    // -------------
    // OFFICE TYPES
    // -------------
    Route::post(
        '/office_types/grid-data', 
        [\App\Http\Controllers\OfficeTypeController::class, 'gridData']
        )->name('office_types_grid_data');
    
    Route::post(
        '/office_types/get_office_type', 
        [App\Http\Controllers\OfficeTypeController::class, 'editData']
    )->name('get_office_type');
    
    Route::resource('/office_types', \App\Http\Controllers\OfficeTypeController::class)->names([
        'index' => 'office_types',
    ]);

    // -------------
    // HUMANS
    // -------------
    // Image Upload
    Route::post('/upload-humans', [HumanController::class, 'upload']);
    // Image delete
    Route::post('/upload-humans-revert', [HumanController::class, 'uploadRevert']);

    Route::resource('/humans', HumanController::class)->names([
        'index' => 'humans',
    ]);

    // -------------
    // ANIMALS
    // -------------
    Route::resource('/animals', AnimalController::class)->names([
        'index' => 'animals',
    ]);

    // -------------
    // PATIENTS
    // -------------
    Route::get('/getPatients', [PatientController::class, 'getPatients'])
        ->name('getPatients');
    Route::resource('/patients', PatientController::class)->names([
        'index' => 'patients'
    ]);

    // -------------
    // ADDRESSES
    // -------------
    Route::resource('/address', AddressController::class)->names([
        'index' => 'address'
    ]);

    // -------------
    // EXAMINATIONS
    // -------------
    Route::get('/getExaminations', [ExaminationController::class, 'getExaminations'])->name('getExaminations');
    //Route::get('/getExaminations', function(){ print_r('asdasd'); })->name('getExaminations');

    Route::resource('/examinations', ExaminationController::class)
        ->names([
            'index' => 'examinations'
    ]);

    // BOOKS
    Route::resource('books', BookController::class)
        ->names([
            'index' => 'books'
    ]);

    // Image Upload
    Route::post('/upload-books', [BookController::class, 'upload']);
    // Image delete
    Route::post('/upload-books-revert', [BookController::class, 'uploadRevert']);

    // BOOKS 2
    Route::get('/books2', [BookController::class, 'index2'])
        ->name('books2');

    // MODAL DEMO
    Route::get('/modal-demo', [PageController::class, 'modalDemo'])->name('modal-demo');
    
    // ASYNC
    Route::get('/async', [App\Http\Controllers\AsyncController::class, 'index'])
            ->name('async');
    Route::post('/async_get_data', [App\Http\Controllers\AsyncController::class, 'get_data'])
            ->name('async_get_data');
});
