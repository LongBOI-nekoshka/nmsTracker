<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/showAllIssues', 'PagesController@showAllIssues');
Route::get('/assignedIssues', 'PagesController@assignedIssues');
Route::resource('/project', 'ProjectController');
Route::resource('/project/{project}/issue', 'IssueController');
Route::resource('/project/{project}/issue/{issue}/comment', 'CommentController',['only'=>['store','destroy']]);
Route::resource('admin','AdminController',['only'=>['index','update']]);
Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
// Route::get('/', function () {
//     return view('welcome');
// });

