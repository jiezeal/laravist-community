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

Route::get('/', 'PostsController@index');
Route::resource('discussions', 'PostsController');
Route::resource('/post/upload', 'PostsController@upload');

route::get('/verify/{confirm_code}', 'UsersController@confirmEmail');

route::get('/user/login', 'UsersController@login');
route::get('/user/register', 'UsersController@register');
route::get('/user/avatar', 'UsersController@avatar');
route::post('/user/login', 'UsersController@signin');
route::post('/user/register', 'UsersController@store');
route::post('/avatar', 'UsersController@changeAvatar');
route::post('/crop/api', 'UsersController@cropAvatar');

route::get('/logout', 'UsersController@logout');

Route::resource('comment', 'CommentsController');