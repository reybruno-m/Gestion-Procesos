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

Route::resource('/getOrigins', 'OriginController', [
    'only' => ['index', 'create', 'store']
]);

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
