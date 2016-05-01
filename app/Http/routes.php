<?php

/*
 * |--------------------------------------------------------------------------
 * | Routes File
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you will register all of the routes in an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */

/**
 * Default route
 */
Route::get ( '/', function () {
	return view ( 'welcome' );
} );

/**
 * category route
 */
Route::group(['middleware' => ['web']], function () {
	Route::get ( '/category', 'CategoryController@index' );
	Route::get ( '/category/view/{id}', 'CategoryController@show' );
	Route::get ( '/category/delete/{id}', 'CategoryController@destroy' );
	Route::get ( '/category/edit/{id}', 'CategoryController@edit' );
	Route::get ( '/category/search', 'CategoryController@search' );
	Route::post ( '/category', 'CategoryController@store' );
	Route::post ( '/category/update', 'CategoryController@update' );
	Route::get ( '/categoryall', 'CategoryController@all' );
});
/**
 * article route
 */
Route::group(['middleware' => ['web']], function () {
	Route::get ( '/article', 'ArticleController@index' );
	Route::get ( '/articleall', 'ArticleController@all' );
	Route::get ( '/article/{id}', 'ArticleController@show' );
	Route::delete ( '/article/{id}', 'ArticleController@destroy' );
	Route::post ( '/article', 'ArticleController@store' );
	Route::put ( '/article/{id}', 'ArticleController@update' );
	Route::get ( '/article/page/{pageid}/item/{limit}', 'ArticleController@listArticle' );
	Route::get ( '/article/page/{pageid}/item/{limit}/{key}', 'ArticleController@search' );
});


/**
 * product route
 */
Route::group(['middleware' => ['web']], function () {
	Route::get ( '/product', 'ProductController@index' );
	Route::get ( '/productall', 'ProductController@all' );
	Route::post ( '/product', 'ProductController@store' );
	Route::get ( '/product/{id}', 'ProductController@show' );
	Route::put ( '/product/{id}', 'ProductController@update' );
	Route::delete ( '/product/{id}', 'ProductController@destroy' );
	Route::get ( '/product/page/{pageid}/item/{limit}', 'ProductController@listProduct' );
	Route::get ( '/product/page/{pageid}/item/{limit}/{key}', 'ProductController@search' );
});

/**
 * file route
 */
Route::group(['middleware' => ['web']], function () {
	Route::get ( '/file', 'FileController@file' );
	Route::get ( '/file/{id}', 'FileController@show' );
	Route::delete ( '/file/{id}', 'FileController@destroy' );
	
	Route::post ( '/file', 'FileController@uploadFile' );
	Route::put ( '/file/{id}', 'FileController@updateFile' );
	
	Route::post ( '/image', 'FileController@uploadImage' );
	Route::put ( '/image/{id}', 'FileController@updateImage' );
	
});

	
