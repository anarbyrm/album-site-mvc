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
        Route::post('/logout', 'logout')->name('logout')->middleware('auth');
    });

Route::controller(CollectionController::class)
    ->prefix('/collections')
    ->name('collections.')
    ->middleware('auth')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/new', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });

Route::controller(ImageController::class)
    ->prefix('/images/{collection_id}')
    ->name('images.')
    ->middleware('auth')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/new', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{image_id}/detail', 'show')->name('show');
        Route::post('/{image_id}/delete', 'delete')->name('remove');
        Route::get('/{image_id}/edit', 'edit')->name('edit');
        Route::post('/{image_id}/edit', 'update')->name('update');
    });
