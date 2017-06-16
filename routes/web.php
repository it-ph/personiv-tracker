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
	// User resource
	Route::group(['prefix' => 'user'], function(){
		Route::post('check', 'UserController@check');
		Route::post('change-password', 'UserController@changePassword');
		Route::post('check-default-password', 'UserController@checkDefaultPassword');
		Route::post('verify-password', 'UserController@verifyPassword');
		Route::put('reset-password/{user}', 'UserController@resetPassword');
		Route::post('logout', 'UserController@logout');
		Route::post('enlist', 'UserController@enlist');
	});

	// Task resource
	Route::group(['prefix' => 'task'], function(){
		Route::post('enlist', 'TaskController@enlist');
		Route::post('dashboard', 'TaskController@dashboard');
		Route::get('download/{date_start}/to/{date_end}/at/{time_start}/until/{time_end}/department/{department_id}', 'TaskController@download');
		Route::post('finish/{task}', 'TaskController@finish');
		Route::post('pause/{task}', 'TaskController@pause');
		Route::post('resume/{task}', 'TaskController@resume');
		Route::get('checker', 'TaskController@checker');
	});

	// Account resource
	Route::group(['prefix' => 'account'], function(){
		Route::post('enlist', 'AccountController@enlist');
	});

	// Position resource
	Route::group(['prefix' => 'position'], function(){
		Route::post('enlist', 'PositionController@enlist');
	});

	// Experience resource
	Route::group(['prefix' => 'experience'], function(){
		Route::post('enlist', 'ExperienceController@enlist');
	});

	Route::resource('account', 'AccountController');
	Route::resource('department', 'DepartmentController');
	Route::resource('position', 'PositionController');
	Route::resource('role', 'RoleController');
	Route::resource('shift-schedule', 'ShiftScheduleController');
	Route::resource('task', 'TaskController');
	Route::resource('user', 'UserController');
	Route::resource('user-role', 'UserRoleController');
});
