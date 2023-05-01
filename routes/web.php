<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CompanyController;

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficeTypeController;

use App\Http\Controllers\PageController;
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

    // COMPANIES
    Route::resource('companies', CompanyController::class)->names([
        'index' => 'companies'
    ]);

    // OFFICE TYPES
    Route::get('/get_office_types', [OfficeTypeController::class, 'getOfficeTypes'])->name('get_office_types');
    Route::resource('/office_types', OfficeTypeController::class)->names([
        'index' => 'office_types',
    ]);

    // OFFICES
    Route::resource('/offices', OfficeController::class)->names([
        'index' => 'offices',
    ]);

    // BOOKS
    Route::resource('books', BookController::class)
        ->names([
            'index' => 'books'
        ]);
    
    // Image Upload
    Route::post('/upload-books', [BookController::class, 'upload']);
    //
    Route::post('/upload-books-revert', [BookController::class, 'uploadRevert']);

    // BOOKS 2
    Route::get('/books2', [BookController::class, 'index2'])
        ->name('books2');

    // MODAL DEMO
    Route::get('/modal-demo', [PageController::class, 'modalDemo'])->name('modal-demo');
});
