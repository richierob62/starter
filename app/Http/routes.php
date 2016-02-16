<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// API Calls
Route::get('/test', function () {
    return response()->json(['name' => 'Abigail', 'state' => 'CA']);
});

// Handles removal from hash using createBrowserHistory on front end
Route::any('{path?}', function () {
    return view('welcome');
})->where('path', '.+');