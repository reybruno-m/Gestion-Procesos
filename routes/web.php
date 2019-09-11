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
})->middleware('auth');


Route::get('/requests', function () {
    return view('requests.index');
})->middleware('auth');

/*
	Generar Reportes.
*/

Route::resource('/reports', 'ReportController', [
    'only' => ['index', 'create', 'store']
]);




Auth::routes();

/*
    Listado de Origenes.
*/
Route::resource('/origin', 'OriginController', [
    'except' => ['create']
]);

/*
    ABM Peticiones Area Principal de Trabajo. 
*/

Route::resource('/request', 'RequestController', [
    'except' => ['create']
]);





/*
    Metodos Especificos
*/

Route::get('/getMisc', 'MiscController@getMiscGroup');
Route::get('/getMiscByID', 'MiscController@getMiscByID');

