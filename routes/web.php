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
	Route::resource('shift-schedule', 'ShiftScheduleController');
	Route::resource('task', 'TaskController');
	Route::resource('user', 'UserController');
	Route::resource('user-role', 'UserRoleController');

	// User resource
	Route::group(['prefix' => 'user'], function(){
		Route::post('check', 'UserController@check');
		Route::post('change-password', 'UserController@changePassword');
		Route::post('check-default-password', 'UserController@checkDefaultPassword');
		Route::post('verify-password', 'UserController@verifyPassword');
		Route::post('logout', 'UserController@logout');
		Route::post('upload-avatar/{userID}', 'UserController@uploadAvatar');
		Route::get('avatar/{userID}', 'UserController@avatar');
		Route::post('mark-all-as-read', 'UserController@markAllAsRead');
		Route::post('mark-as-read', 'UserController@markAsRead');
	});

	// Task resource
	Route::group(['prefix' => 'task'], function(){
		Route::post('enlist', 'TaskController@enlist');
		Route::post('dashboard', 'TaskController@dashboard');
		Route::get('download/{date_start}/to/{date_end}/at/{time_start}/until/{time_end}', 'TaskController@download');
		Route::post('finish/{task}', 'TaskController@finish');
		Route::post('pause/{task}', 'TaskController@pause');
		Route::post('resume/{task}', 'TaskController@resume');
	});

	// Account resource
	Route::group(['prefix' => 'account'], function(){
		Route::post('enlist', 'AccountController@enlist');
	});
});
