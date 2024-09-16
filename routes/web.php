<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CollectionController;
use App\Http\Controllers\Frontend\ImageController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)
    ->prefix('/auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/login', 'login')->name('login.get');
        Route::post('/login', 'loginPost')->name('login.post');
        Route::get('/registration', 'register')->name('register.get');
        Route::post('/registration', 'registerPost')->name('register.post');
        Route::post('/logout', 'logout')->name('logout');
    });

Route::controller(CollectionController::class)
    ->prefix('/collections')
    ->name('collections.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/new', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });

Route::get('/images/{collection}', [ImageController::class, 'index'])->name('images.index');
