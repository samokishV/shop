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

Route::get('home', 'PagesController@index')->name('home');

Route::match(['get', 'post'], '/category/{catSlug}', 'PagesController@category')->name('category.show');

Route::post('/product/search', 'ProductController@search')->name('product.search');

Route::get('/product/{slug}', 'ProductController@show')->name('product.show');

Auth::routes();

Route::post('cart/add', 'CartController@add')->name('cart.add');

Route::post('cart/update/{productId}', 'CartController@update')->name('cart.edit');

Route::post('cart/delete/{productId}', 'CartController@delete')->name('cart.delete');

Route::post('cart/delete', 'CartController@deleteAll')->name('cart.delete.all');

Route::get('cart', 'PagesController@cart')->name('cart');

Route::get('order', 'OrderController@create')->name('order');

Route::post('order', 'OrderController@store');

Route::get('order/history', 'OrderController@show')->name('order.history');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'PagesController@adminIndex');

    Route::get('user', 'UserController@index')->name('admin.user.index');

    Route::delete('user/delete/{id}', 'UserController@destroy')->name('user.delete');

    Route::get('user/add', 'UserController@create')->name('user.add');

    Route::post('user/add', 'UserController@store');

    Route::get('user/edit/{id}', 'UserController@edit')->name('user.edit');

    Route::post('user/edit/{id}', 'UserController@update');

    Route::get('category', 'CategoryController@index')->name('admin.category.index');

    Route::delete('category/delete/{id}', 'CategoryController@destroy')->name('category.delete');

    Route::get('category/add', 'CategoryController@create')->name('category.add');

    Route::post('category/add', 'CategoryController@store');

    Route::get('category/edit/{id}', 'CategoryController@edit')->name('category.edit');
    ;

    Route::post('category/edit/{id}', 'CategoryController@update');

    Route::get('product', 'ProductController@index')->name('admin.product.index');

    Route::delete('product/delete/{id}', 'ProductController@destroy');

    Route::get('product/add', 'ProductController@create')->name('product.add');

    Route::post('product/add', 'ProductController@store');

    Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');

    Route::post('product/edit/{id}', 'ProductController@update');

    Route::get('product/edit-promo/{id}', 'ProductController@updatePromo')->name('promo.edit');

    Route::post('product/edit-promo/{id}', 'ProductController@updatePromo');
});

Route::group(['prefix' => 'admin/order', 'middleware' => ['check_role:admin,manager']], function () {
    Route::get('/', 'OrderController@index')->name('admin.order.index');

    Route::get('edit/{id}', 'OrderController@edit')->name('order.edit');

    Route::post('edit/{id}', 'OrderController@update');
});

// Public route to show images
Route::get('img/{image}', 'ImageController@uploadImages');

Route::get('/redirect', 'SocialAuthFacebookController@redirect')->name('facebook.redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback')->name('facebook.callback');

Route::get('/redirect/twitter', 'SocialAuthTwitterController@redirect')->name('twitter.redirect');
Route::get('/callback/twitter', 'SocialAuthTwitterController@callback')->name('twitter.callback');
