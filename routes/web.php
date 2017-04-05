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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/register', 'HomeController@index');

Route::group(['middleware' => 'auth'], function(){
	Route::post('/pusher/auth', 'PusherController@auth');

	Route::resource('account', 'AccountController');
	Route::resource('department', 'DepartmentController');
	Route::resource('role', 'RoleController');
	Route::resource('task', 'TaskController');
	Route::resource('user', 'UserController');
	Route::resource('user-role', 'UserRoleController');

	Route::group(['prefix' => 'user'], function(){
		Route::post('check', 'UserController@check');
		Route::post('change-password', 'UserController@changePassword');
		Route::post('verify-password', 'UserController@verifyPassword');
		Route::post('logout', 'UserController@logout');
	});
});
