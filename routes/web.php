<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAdminOrManager;
use App\Http\Middleware\IsUserLogged;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware([IsAdminOrManager::class])->group(function(){

    Route::get('/users',[App\Http\Controllers\UserController::class, 'index']);
    Route::get('users/{id}',[App\Http\Controllers\UserController::class, 'show']);
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store']);
    Route::post('users/{id}',[App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}',[App\Http\Controllers\UserController::class, 'destroy']);

});

Route::middleware([IsAdmin::class])->group(function(){

    Route::get('/entries',[App\Http\Controllers\EntriesController::class, 'index']);
    Route::get('/entries/{id}',[App\Http\Controllers\EntriesController::class, 'show']);
    Route::post('/entries', [App\Http\Controllers\EntriesController::class, 'store']);
    Route::post('entries/{id}',[App\Http\Controllers\EntriesController::class, 'update']);
    Route::delete('/entries/{id}',[App\Http\Controllers\EntriesController::class, 'destroy']);

});

Route::middleware([IsUserLogged::class])->group(function() {

    Route::get('/user/entries', [App\Http\Controllers\EntriesController::class, 'userEntries']);
    Route::get('user/calories',[App\Http\Controllers\EntriesController::class, 'getUsersCaloriesForToday']);
    Route::get('user/entries/{id}',[App\Http\Controllers\EntriesController::class, 'show']);
    Route::post('/user/entries', [App\Http\Controllers\EntriesController::class, 'newEntry']);
    Route::post('/user/entries/{id}', [App\Http\Controllers\EntriesController::class, 'updateEntry']);
    Route::delete('/user/entries/{id}', [App\Http\Controllers\EntriesController::class, 'deleteEntry']);
    Route::post('user/filterEntries',[App\Http\Controllers\EntriesController::class, 'filterEntries']);
});
