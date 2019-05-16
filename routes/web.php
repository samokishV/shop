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

Route::post('cart/update/{productId}', 'CartController@update');

Route::post('cart/delete/{productId}', 'CartController@delete');

Route::post('cart/delete', 'CartController@deleteAll');

Route::get('cart', 'PagesController@cart');

Route::get('order', 'PagesController@order');

Route::post('order', 'OrderController@store');

Route::get('order/history', 'OrderController@show');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

    Route::get('/', 'PagesController@adminIndex');

    Route::get('user', 'UserController@index');

    Route::delete('user/delete/{id}', 'UserController@destroy');

    Route::get('user/add', 'UserController@create');

    Route::post('user/add', 'UserController@store');

    Route::get('user/edit/{id}', 'UserController@edit');

    Route::post('user/edit/{id}', 'UserController@update');

    Route::get('order', 'OrderController@index');

    Route::get('order/edit/{id}', 'OrderController@edit');

    Route::post('order/edit/{id}', 'OrderController@update');

    Route::get('category', 'CategoryController@index');

    Route::delete('category/delete/{id}', 'CategoryController@destroy');

    Route::get('category/add', 'CategoryController@create');

    Route::post('category/add', 'CategoryController@store');

    Route::get('category/edit/{id}', 'CategoryController@edit');

    Route::post('category/edit/{id}', 'CategoryController@update');

    Route::get('product', 'ProductController@index');

    // Route::delete('category/delete/{id}', 'CategoryController@destroy');

    // Route::get('category/add', 'CategoryController@create');

    // Route::post('category/add', 'CategoryController@store');

    Route::get('product/edit-promo/{id}', 'ProductController@updatePromo');

    Route::post('product/edit-promo/{id}', 'ProductController@updatePromo');
});

// Public route to show images
Route::get('img/{image}', 'ImageController@uploadImages');








