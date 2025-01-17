<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware( ['admin'])->group(function () {
    Route::apiResource('/users', UserController::class);
});
Route::middleware( ['auth.basic'])->group(function () {
    Route::apiResource('/users', UserController::class);
});
Route::middleware( ['librarian'])->group(function () {
    Route::apiResource('/users', UserController::class);
});
Route::middleware( ['librarianbasic'])->group(function () {
    Route::apiResource('/users', UserController::class);
});




//ADMIN
Route::middleware( ['admin'])->group(function () {
    //books
    Route::get('/api/books', [BookController::class, 'index']);
    Route::get('/api/books/{id}', [BookController::class, 'show']);
    Route::post('/api/books', [BookController::class, 'store']);
    Route::put('/api/books/{id}', [BookController::class, 'update']);
    Route::delete('/api/books/{id}', [BookController::class, 'destroy']);
    //copies
    Route::apiResource('/api/copies', CopyController::class);
    //queries
    Route::get('/api/book_copies/{title}', [BookController::class, 'bookCopies']);
    //view - copy
    Route::get('/copy/new', [CopyController::class, 'newView']);
    Route::get('/copy/edit/{id}', [CopyController::class, 'editView']);
    Route::get('/copy/list', [CopyController::class, 'listView']); 
});

//SIMPLE USER
Route::middleware(['auth.basic'])->group(function () {
    
    //user   
    Route::get('/api/books/', [BookController::class, 'index']);
    Route::apiResource('/api/users', UserController::class);
    Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
    //queries
    //user lendings
    Route::get('/api/user_lendings', [LendingController::class, 'userLendingsList']);
    Route::get('/api/user_lendings_count', [LendingController::class, 'userLendingsCount']);
    Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
    //Route::apiResource('/api/copies', CopyController::class);
});

Route::middleware(['librarian'])->group(function(){

    //Route::apiResource('/api/copies', CopyController::class);
    Route::get('/api/lendings', [LendingController::class, 'index']); 

});

Route::middleware(['librarian', 'auth.basic'])->group(function(){
    Route::apiResource('/api/copies', CopyController::class);
});

//csak a tesztelés miatt van "kint"
//Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
//Route::apiResource('/api/copies', CopyController::class);
//Route::get('/api/lendings', [LendingController::class, 'index']); 
Route::get('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'show']);
Route::put('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::patch('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::post('/api/lendings', [LendingController::class, 'store']);
Route::delete('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']);

//órai munka/doga volt
Route::get('/api/book_copy_count/{title}',[CopyController::class, 'bookCopyCount']);
Route::get('api/hard_cover/{hardcovered}', [CopyController::class, 'hardCover']);
Route::get('/api/publcitaion_date/{publication}',[CopyController::class, 'kiadasEv']);
Route::get('/api/raktar/', [CopyController::class, 'raktarBan']);
Route::get('/api/raktaros/{ev}/{id}',[CopyController::class, 'bizonyosRaktar']);
Route::get('/api/kiadott/{id}', [CopyController::class, 'adottKony']);

//11.19
Route::get('/api/reservation', ReservationController::class, 'older');

require __DIR__.'/auth.php';
