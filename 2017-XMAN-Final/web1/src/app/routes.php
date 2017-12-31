<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'PostsController@index']);
Route::get('about', ['as' => 'about', 'uses' => 'PostsController@index']);

// Confide routes
Route::get('signup', ['as' => 'signup', 'uses' => 'UsersController@create']);
Route::post('users', 'UsersController@store');
Route::get('login', ['as' => 'login', 'uses' => 'UsersController@login']);
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('logout', ['as' => 'logout', 'uses' => 'UsersController@logout']);

Route::get('users/settings', [
    'as' => 'users.settings',
    'uses' => 'UsersController@settings'
]);

Route::get('categories/{slug}', [
    'as' => 'categories.show',
    'uses' => 'CategoriesController@show'
]);

Route::get('tags/{slug}', [
    'as' => 'tags.show',
    'uses' => 'TagsController@show'
]);

Route::post('comments', [
    'as' => 'comments.store',
    'uses' => 'CommentsController@store'
]);

Route::delete('comments/{id}', [
    'as' => 'comments.destroy',
    'uses' => 'CommentsController@destroy'
]);

Route::post('upload_image', [
    'as' => 'posts.upload_image',
    'uses' => 'PostsController@uploadImage'
]);

Route::post('resolve_image', [
    'as' => 'posts.resolve_image',
    'uses' => 'PostsController@resolveImage'
]);

Route::get('feed', [
    'as' => 'feed',
    'uses' => 'PostsController@feed'
]);

Route::resource('posts', 'PostsController');
Route::resource('users', 'UsersController');
