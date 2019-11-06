<?php

Route::get('/', function () {
    return view('inicio');
});

Route::get('/inicio', function () {
    return view('inicio');
});

// Ruta de Testing
Route::get('/testing/{param?}', 'TestingController@index')->name('param');

Auth::routes();
