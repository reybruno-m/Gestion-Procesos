<?php
Route::get('/', function () {
    return view('inicio');
});
Route::get('/inicio', function () {
    return view('inicio');
});

/*
	Vistas
*/

Route::get('/origins', function () {
    return view('origins.index');
})->middleware('auth');


Route::get('/requests', function () {
    return view('requests.index');
})->middleware('auth');


Auth::routes();

/*
    Rutas Axios para ABM de registros.
*/

Route::resource('/origin', 'OriginController', [
    'except' => ['create']
]);

Route::resource('/state', 'StateController', [
    'except' => ['create']
]);

Route::resource('/request', 'RequestController', [
    'except' => ['create']
]);

Route::resource('/movement', 'MovementController', [
    'except' => ['create']
]);

Route::resource('/reports', 'ReportController', [
    'only' => ['index', 'create', 'store']
]);

Route::resource('/account', 'AccountController', [
    'only' => ['index']
]);


Route::resource('/management', 'ManagementController', [
    'only' => ['index']
]);

/*
    Metodos Agregados
*/

Route::post('/changeState/{id}', 'OriginController@changeState');
Route::get('/getMisc', 'MiscController@getMiscGroup');
Route::get('/getMiscByID', 'MiscController@getMiscByID');

