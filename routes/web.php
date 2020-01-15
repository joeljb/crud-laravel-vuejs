<?php

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
use App\Http\Middleware\AuthAdmin;

// Route::get('/', function () {
//    return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/contruccion', 'HomeController@contruccion')->name('contruccion');

// Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
 
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware(['auth',AuthAdmin::class]);
Route::post('register', 'Auth\RegisterController@register')->middleware(['auth',AuthAdmin::class]);
 
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
 
// Email Verification Routes...
Route::emailVerification();



Route::get('/home', 'HomeController@index')->name('home');


Route::get('/categorias/traer', 'CategoriasController@traer')->name('categorias.traer');
Route::post('/categoria/crear', 'CategoriasController@store')->name('categoria.crear');
Route::resource('/categorias', 'CategoriasController');


Route::get('/productos/traer', 'ProductosController@traer')->name('productos.traer');


Route::resource('/productos', 'ProductosController');

