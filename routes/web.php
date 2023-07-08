<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'loginProses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'registerProses'])->name('register-proses');


Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [HomeController::class, 'dashboard']);

    Route::get('/user', [HomeController::class, 'index'])->name('index');
    Route::get('/create', [HomeController::class, 'create'])->name('user.create');
    Route::post('/store', [HomeController::class, 'store'])->name('user.store');

    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
    Route::put('/update/{id}', [HomeController::class, 'update'])->name('user.update');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');
});

Route::get('/user/create', [HomeController::class, 'create'])->name('user.create');
Route::get('/user/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
Route::delete('/user/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');
Route::post('/user/store', [HomeController::class, 'store'])->name('user.store');
Route::get('/user', [HomeController::class, 'index'])->name('index');
Route::put('/user/update/{id}', [HomeController::class, 'update'])->name('user.update');

Route::get('/', function(){
    return redirect()->route('login');
});