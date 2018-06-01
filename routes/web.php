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
Route::get('/admin/index', 'Admin\IndexController@index');
Route::post('/admin/login','Admin\IndexController@login');

Route::group(['middleware' => ['verifyAdminUser','langSet']], function () {

	Route::any('/admin/iamgeUpload','Admin\UploadController@imageUpload');
	Route::any('/admin/txtUpload','Admin\UploadController@txtUpload');
	Route::post('/admin/lang/set','Admin\LangController@set');

	Route::resource('/admin/administrators/user', 'Admin\AdminUserController');
	Route::get('/admin/user/info/destoryByPassport', 'Admin\UserInfoController@destoryByPassport');
	Route::resource('/admin/user/info', 'Admin\UserInfoController');
	Route::get('/admin/user/usercountry', 'Admin\UserInfoController@userCountry');

	Route::resource('/admin/news','Admin\NewsController');
	Route::get('/admin/users','Admin\UsersController@index');
	
	//挖矿设置
	Route::get('/admin/mineConfig','Admin\MineConfigController@index');
	Route::post('/admin/mineConfig/update','Admin\MineConfigController@update');
	
	//应用设置
	// Route::resource('/admin/apps','Admin\AppsController');
});


