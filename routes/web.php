<?php

Route::get('/', function () {
    return view('inicio');
});

/*
	Perfil de Usuario, Cambio de datos personales.
*/

Route::resource('/account', 'AccountController', [
    'only' => ['index']
]);

/*
	Modulo Administrativo.
*/

Route::resource('/management', 'ManagementController', [
    'only' => ['index']
]);

/*
	ABM Origenes, Sectores/Personas
*/


Route::get('/origins', function () {
    return view('origins.index');
});

/*
	Generar Reportes.
*/

Route::resource('/reports', 'ReportController', [
    'only' => ['index', 'create', 'store']
]);

/*
	ABM Peticiones Area Principal de Trabajo. 
*/

Route::resource('/requests', 'RequestController', [
    'only' => ['index', 'create', 'store']
]);


Auth::routes();

# Route::get('/home', 'HomeController@index')->name('home');


// Rutas de Datos

/*
    Listado de Origenes.
*/
Route::resource('/origin', 'OriginController');

/*
    Tipos de Origenes
*/

Route::get('/getMisc', 'MiscController@getMiscGroup');

