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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/register', 'AccountsController@register')->name('register');
Route::post('/register', 'AccountsController@store')->name('register.store');

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/get_directory_pie_chart_data', 'DashboardController@get_directory_pie_chart_data')->name('get_directory_pie_chart_data');


        Route::group(['prefix' => 'applications'], function () {
            Route::get('/', 'ApplicationController@index')->name('applications.index');
            Route::post('/download-zip', 'ApplicationController@make_zip_download')->name('application.zip');
            Route::post('/download-file', 'ApplicationController@download_single_file')->name('application.single.download');
            Route::post('/delete-directory', 'ApplicationController@delete_directory_folder')->name('application.delete');
            Route::post('/delete-file', 'ApplicationController@delete_single_file')->name('application.file.delete');
        });

        Route::group(['prefix' => 'documents'], function () {
            Route::get('/', 'ApplicationController@documents')->name('documents.index');
        });
    });
});
