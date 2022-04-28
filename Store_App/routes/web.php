<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

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

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'prefix' =>'admin'
],function (){

    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin');
//    Route::resource('categories',\App\Http\Controllers\Admin\CategoryController::class)->except('update','destroy');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');


    //  products
    Route::resource('products',\App\Http\Controllers\Admin\ProductController::class)->except('update','destroy');
    Route::post('/update/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::get('/delete/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.delete');

    Route::resource('users',\App\Http\Controllers\Admin\UsersController::class);
    Route::post('/update/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'update'])->name('user.update');
    Route::get('/delete/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('user.delete');



});

Route::middleware(['auth:sanctum','verified'])->get('/dashboard',function (){
    return view('dashboard');

})->name('dashboard');
