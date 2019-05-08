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

Route::get('/', 'PagesController@index');

Route::get('home', 'PagesController@index');

Route::match(['get', 'post'], '/category/{catSlug}', 'PagesController@category');

Route::post('/product/search', 'ProductController@search');

Route::get('/product/{slug}', 'ProductController@show');

Auth::routes();

Route::post('cart/add', 'CartController@add');

Route::get('cart', 'PagesController@cart');
