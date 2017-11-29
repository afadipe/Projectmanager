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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*
Naming Resource Routes
By default, all resource controller actions have a route name; however, 
you can override these names by passing a names array with your options:
Route::resource('photo', 'PhotoController', ['names' => [
    'create' => 'photo.build'
]]);
*/
Route::middleware(['auth'])->group(function(){

    Route::resource('companies','CompaniesController');
    Route::get('projects/create/{company_id?}', 'ProjectsController@create');
    Route::resource('projects','ProjectsController');
    Route::resource('roles','CompaniesController');
    Route::resource('tasks','TasksController');
    Route::resource('users','UsersController');
    Route::resource('comments','CommentsController');
    
});

