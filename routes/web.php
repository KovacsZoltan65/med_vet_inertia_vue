<?php
//use App\Http\Controllers\PostController;


use App\Http\Controllers\AddressController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\HumanController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PatientController;
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
    Route::resource('/addresses', AddressController::class)->names([
        'index' => 'addresses'
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
});
