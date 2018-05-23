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


	//版本设置
	Route::resource('/admin/version','Admin\VersionSetController');
	Route::get('/admin/versions/versionEdit','Admin\VersionSetController@versionEdit');
	Route::post('/admin/versions/versionUpdate','Admin\VersionSetController@versionUpdate');

	//应用设置
	Route::resource('/admin/apps','Admin\AppsController');
});


