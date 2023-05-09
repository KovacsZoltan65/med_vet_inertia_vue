<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HumanController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
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

    // OFFICES
    Route::resource('/offices', OfficeController::class)->names([
        'index' => 'offices',
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
    // Betegek
    // -------------
    Route::resource('/patients', \App\Http\Controllers\PatientController::class)->names([
        'index' => 'patients'
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
});
