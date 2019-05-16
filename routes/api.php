<?php

use Illuminate\Http\Request;
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization,No-Auth');
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('user/login','Api\UserController@login');
Route::post('user/register','Api\UserController@register');
Route::put('user/update/{id}','Api\UserController@update');
Route::delete('user/delete/{id}','Api\UserController@delete');
Route::get('user/{id}','Api\UserController@getById');
Route::get('users','Api\UserController@getEmployees');
Route::post('user/email_exists','Api\UserController@checkEmailExists');
Route::post('user/phone_exists','Api\UserController@checkPhoneExists');

Route::post('expert/login','Api\ExpertController@login');
Route::post('expert/register','Api\ExpertController@register');
Route::put('employee/update/{id}','Api\ExpertController@update');
Route::delete('expert/delete/{id}','Api\ExpertController@delete');
Route::get('expert/{id}','Api\ExpertController@getById');
Route::get('experts','Api\ExpertController@getEmployees');
Route::post('expert/email_exists','Api\ExpertController@checkEmailExists');
Route::post('expert/phone_exists','Api\ExpertController@checkPhoneExists');

Route::post('admin/login','Api\AdminController@login');
Route::post('admin/register','Api\AdminController@register');
Route::put('employee/update/{id}','Api\AdminController@update');
Route::delete('admin/delete/{id}','Api\AdminController@delete');
Route::get('admin/{id}','Api\AdminController@getById');
Route::get('admins','Api\AdminController@getEmployees');
Route::post('admin/email_exists','Api\AdminController@checkEmailExists');
Route::post('admin/phone_exists','Api\AdminController@checkPhoneExists');
