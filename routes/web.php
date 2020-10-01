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

// dashboard
Route::get('/', 'DashboardController@index')->name('dashboard.index');

// ====================================
// Inventory
// ====================================
Route::name('inventory.')->prefix('inventory')->group(function(){
    // ====================================
    // Software
    // ====================================
    Route::group(['prefix' => 'software'], function(){
        Route::delete('{software}/image', 'Inventory\SoftwareController@deleteImage')->name('software.delete.image');
    });
    Route::resource('software', 'Inventory\SoftwareController');

    // ====================================
    // Inventory
    // ====================================
    Route::group(['prefix' => 'device'], function(){
        
    });
    Route::resource('device', 'Inventory\DeviceController');
});
