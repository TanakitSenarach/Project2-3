<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

 // เมนู User
Route::get('admin/user/index',[UserController::class, 'index']);

// เมนู Category
Route::get('admin/category/index',[CategoryController::class, 'index']);
Route::get('admin/category/createfrom',[CategoryController::class, 'createfrom']);
Route::get('admin/category/edit',[CategoryController::class, 'edit']);
Route::post('admin/category/insert',[CategoryController::class, 'insert']);
Route::get('admin/category/edit/{id}',[categorycontroller::class, 'edit']);
Route::post('admin/category/update/{id}',[Categorycontroller::class, 'update']);
Route::get('admin/category/delete/{id}',[Categorycontroller::class, 'delete']);

// เมนู Product
Route::get('admin/product/index',[ProductController::class, 'index'])->name('p.index');
Route::get('admin/product/createfrom',[ProductController::class, 'createfrom'])->name('p.create');
Route::get('admin/product/edit/{id}',[Productcontroller::class, 'edit'])->name('p.edit');
Route::post('admin/product/update/{id}',[Productcontroller::class, 'update']);
Route::get('admin/product/delete/{id}',[Productcontroller::class, 'delete']);
