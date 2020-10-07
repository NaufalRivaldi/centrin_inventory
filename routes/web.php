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

// ====================================
// Halaman login (guest role)
// ====================================
Route::get('/', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@login')->name('login.post');

Route::get('/register', 'AuthController@register')->name('register');
Route::post('/register', 'AuthController@registerStore')->name('register.store');

// ====================================
// Route with access auth
// ====================================
Route::group(['middleware' => 'auth'], function(){
    Route::get('/logout', 'AuthController@logout')->name('logout');

    // ====================================
    // Dashboard
    // ====================================
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    // ====================================
    // User
    // ====================================
    Route::group(['prefix' => 'user'], function(){
        Route::post('user/ajax', 'UserController@ajax')->name('user.ajax');
    });
    Route::resource('user', 'UserController');
    
    // ====================================
    // Inventory
    // ====================================
    Route::name('inventory.')->prefix('inventory')->group(function(){
        // ====================================
        // Software
        // ====================================
        Route::group(['prefix' => 'software'], function(){
            Route::get('{software}/modal', 'Inventory\SoftwareController@showModal')->name('software.show.modal');
            Route::delete('{software}/image', 'Inventory\SoftwareController@deleteImage')->name('software.delete.image');

            Route::post('ajax', 'Inventory\SoftwareController@ajax')->name('software.ajax');
        });
        Route::resource('software', 'Inventory\SoftwareController');
    
        // ====================================
        // Device
        // ====================================
        Route::group(['prefix' => 'device'], function(){
            Route::get('{device}/modal', 'Inventory\DeviceController@showModal')->name('device.show.modal');
            Route::delete('{device}/image', 'Inventory\DeviceController@deleteImage')->name('device.delete.image');
            Route::post('ajax', 'Inventory\DeviceController@ajax')->name('device.ajax');
        });
        Route::resource('device', 'Inventory\DeviceController');

        // ====================================
        // Computer
        // ====================================
        Route::group(['prefix' => 'computer'], function(){
            Route::delete('{computer}/image', 'Inventory\ComputerController@deleteImage')->name('computer.delete.image');
            Route::get('search/software', 'Inventory\ComputerController@searchSoftware')->name('computer.search.software');
            Route::get('software/{param}', 'Inventory\ComputerController@json')->name('computer.json');
            Route::post('ajax', 'Inventory\ComputerController@ajax')->name('computer.ajax');
        });
        Route::resource('computer', 'Inventory\ComputerController');

        // ====================================
        // Computer
        // ====================================
        Route::group(['prefix' => 'log'], function(){
            Route::get('/', 'Inventory\LogController@index')->name('log.index');
        });
    });
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
