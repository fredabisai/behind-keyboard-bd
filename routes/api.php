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
| is assigned the "API" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:API')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('user/login','API\UserController@login');
Route::post('user/register','API\UserController@register');
Route::put('user/update/{id}','API\UserController@update');
Route::delete('user/delete/{id}','API\UserController@delete');
Route::get('user/{id}','API\UserController@getById');
Route::get('users','API\UserController@index');
Route::post('user/email_exists','API\UserController@checkEmailExists');
Route::post('user/phone_exists','API\UserController@checkPhoneExists');

Route::post('expert/login','API\ExpertController@login');
Route::post('expert/register','API\ExpertController@register');
Route::put('employee/update/{id}','API\ExpertController@update');
Route::delete('expert/delete/{id}','API\ExpertController@delete');
Route::get('expert/{id}','API\ExpertController@getById');
Route::get('experts','API\ExpertController@getEmployees');
Route::post('expert/email_exists','API\ExpertController@checkEmailExists');
Route::post('expert/phone_exists','API\ExpertController@checkPhoneExists');

Route::post('admin/login','API\AdminController@login');
Route::post('admin/register','API\AdminController@register');
Route::put('employee/update/{id}','API\AdminController@update');
Route::delete('admin/delete/{id}','API\AdminController@delete');
Route::get('admin/{id}','API\AdminController@getById');
Route::get('admins','API\AdminController@getEmployees');
Route::post('admin/email_exists','API\AdminController@checkEmailExists');
Route::post('admin/phone_exists','API\AdminController@checkPhoneExists');

Route::post('question/add','API\QuestionController@add');
Route::get('questions','API\QuestionController@index');
Route::get('question/{id}','API\QuestionController@getById');


Route::post('answer/add','API\AnswerController@add');
Route::get('answers','API\AnswerController@index');
Route::get('answer/{id}','API\AnswerController@getById');
