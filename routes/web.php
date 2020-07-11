<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserMiddleware;
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
    return view('index');
});

Route::get('/produtos', 'ProdutoController@indexView');

Route::get('/categorias', 'CategoriaController@index');

Route::get('/categorias/new', 'CategoriaController@create');

Route::post('/categorias', 'CategoriaController@store');

Route::get('/categorias/delete/{id}', 'CategoriaController@destroy');

Route::get('/categorias/edit/{id}', 'CategoriaController@edit');

Route::post('/categorias/{id}', 'CategoriaController@update');

Route::get('/usuarios', 'UserController@index')->middleware('user');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
