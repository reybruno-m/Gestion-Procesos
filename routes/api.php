<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'auth'], function() {

	/*
	|--------------------------------------------------------------------------
	| TASKS 
	|--------------------------------------------------------------------------
	*/

		Route::resource('/task', 'TaskController', [
		    'only' => ['index', 'store', 'show', 'destroy']
		]);

	/*
	|--------------------------------------------------------------------------
	| MOVEMENTS 
	|--------------------------------------------------------------------------
	*/
	Route::resource('/movement', 'MovementController', [
	    'only' => ['update', 'store']
	]);
	Route::post('/addMovement' , 'MovementController@add');


	/*
	|--------------------------------------------------------------------------
	| ORIGINS 
	|--------------------------------------------------------------------------
	*/
	Route::resource('/origin', 'OriginController', [
	    'except' => ['create']
	]);
	Route::post('/changeState/{id}', 'OriginController@changeState');


	/*
	|--------------------------------------------------------------------------
	| REPORTS 
	|--------------------------------------------------------------------------
	*/
	Route::resource('/reports', 'ReportController', [
	    'only' => ['index']
	]);


	/*
	|--------------------------------------------------------------------------
	| ACCOUNT 
	|--------------------------------------------------------------------------
	*/
	Route::resource('/account', 'AccountController', [
	    'only' => ['index']
	]);


	/*
	|--------------------------------------------------------------------------
	| MANAGEMENT ONLY ADMIN
	|--------------------------------------------------------------------------
	*/
	Route::resource('/management', 'ManagementController', [
	    'only' => ['index']
	]);


	/*
	|--------------------------------------------------------------------------
	| STATES
	|--------------------------------------------------------------------------
	*/
	Route::get('/getStates', 'StateController@index');


	/*
	|--------------------------------------------------------------------------
	| MISC DATA
	|--------------------------------------------------------------------------
	*/
	Route::get('/getMisc', 'MiscController@getMiscGroup');
	Route::get('/getMiscByID', 'MiscController@getMiscByID');

});
