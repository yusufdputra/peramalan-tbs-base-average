<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'AnonimController@index');

Route::get('forecasting', 'DataController@forecasting');

Route::post('import', 'DataController@import');

Route::post('remove_data', 'DataController@remove_data');
Route::post('store', 'DataController@store');
Route::post('update', 'DataController@update');
Route::post('delete', 'DataController@delete');
