<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/getCategory', [\App\Http\Controllers\CategoryController::class, 'getCategory']);
Route::delete('/deleteCategory/{id}', [\App\Http\Controllers\CategoryController::class, 'delete']);

Route::delete('/filmDelete/{id}' , [\App\Http\Controllers\FilmController::class , 'delete']);
Route::get('/getFilm', [\App\Http\Controllers\FilmController::class, 'getFilm']);



Route::post('/newUser' , [\App\Http\Controllers\UserController::class , 'store']);
Route::post('/login' , [\App\Http\Controllers\UserController::class , 'login']);

Route::group(['middleware'=>'auth:api'] , function (){
Route::post('/newFilm', [\App\Http\Controllers\FilmController::class, 'store']);
Route::post('/filmUpdate/{id}' , [\App\Http\Controllers\FilmController::class , 'update']);


Route::post('/newCategory', [\App\Http\Controllers\CategoryController::class, 'store']);
Route::post('/categoryUpdate/{id}' , [\App\Http\Controllers\CategoryController::class , 'update']);


});

