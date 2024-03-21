<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RoleController;


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
//UserController
Route::post('/authenticate', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('role:Admin,Cliente');
Route::get('/get-users', [UserController::class, 'index'])->middleware('role:Admin');
Route::get('/get-user', [UserController::class, 'getUser'])->middleware('role:Admin,Cliente');
Route::get('/get-clients', [UserController::class, 'clients'])->middleware('role:Admin');
Route::post('/create-user', [UserController::class, 'store'])->middleware('role:Admin');
Route::put('/update-user/{id}', [UserController::class, 'update'])->middleware('role:Admin');
Route::delete('/delete-user/{id}', [UserController::class, 'destroy'])->middleware('role:Admin');

//BookController
Route::get('/get-books', [BookController::class, 'index'])->middleware('role:Admin');
Route::post('/get-search-books', [BookController::class, 'searchBooks'])->middleware('role:Admin,Cliente');
Route::post('/create-book', [BookController::class, 'store'])->middleware('role:Admin');
Route::put('/update-book/{id}', [BookController::class, 'update'])->middleware('role:Admin');
Route::delete('/delete-book/{id}', [BookController::class, 'destroy'])->middleware('role:Admin');

//CategoryController
Route::get('/get-categories', [CategoryController::class, 'index'])->middleware('role:Admin');
Route::post('/create-category', [CategoryController::class, 'store'])->middleware('role:Admin');
Route::put('/update-category/{id}', [CategoryController::class, 'update'])->middleware('role:Admin');
Route::delete('/delete-category/{id}', [CategoryController::class, 'destroy'])->middleware('role:Admin');

//EditorialController
Route::get('/get-editorials', [EditorialController::class, 'index'])->middleware('role:Admin');
Route::post('/create-editorial', [EditorialController::class, 'store'])->middleware('role:Admin');
Route::put('/update-editorial/{id}', [EditorialController::class, 'update'])->middleware('role:Admin');
Route::delete('/delete-editorial/{id}', [EditorialController::class, 'destroy'])->middleware('role:Admin');

//WriterController
Route::get('/get-writers', [WriterController::class, 'index'])->middleware('role:Admin');
Route::post('/create-writer', [WriterController::class, 'store'])->middleware('role:Admin');
Route::put('/update-writer/{id}', [WriterController::class, 'update'])->middleware('role:Admin');
Route::delete('/delete-writer/{id}', [WriterController::class, 'destroy'])->middleware('role:Admin');

//LoanController
Route::get('/get-loans', [LoanController::class, 'index'])->middleware('role:Admin');
Route::post('/create-loan', [LoanController::class, 'store'])->middleware('role:Admin');
Route::put('/update-loan/{id}', [LoanController::class, 'update'])->middleware('role:Admin');

//RolesController
Route::get('/get-roles', [RoleController::class, 'index'])->middleware('role:Admin');


//Default

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/login', function () {
    return view('welcome');
});

Route::get('/user', function () {
    return view('welcome');
})->middleware('role:Admin');

Route::get('/category', function () {
    return view('welcome');
})
->middleware('role:Admin');

Route::get('/book', function () {
    return view('welcome');
})
->middleware('role:Admin');

Route::get('/editorial', function () {
    return view('welcome');
})
->middleware('role:Admin');

Route::get('/writer', function () {
    return view('welcome');
})
->middleware('role:Admin');

Route::get('/loan', function () {
    return view('welcome');
})
->middleware('role:Admin');

Route::get('/search-books', function () {
    return view('welcome');
})
->middleware('role:Admin,Cliente');


// Route::get('{any}', fn() => view('welcome'))->where('any', '.*')->middleware('auth');
