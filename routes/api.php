<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('iniciar-sesion',            'AutenticacionController@iniciarSesionLocal');
Route::post('iniciar-sesion-salud-id',   'AutenticacionController@iniciarSesionSaludID');
Route::post('refresh-token',    'AutenticacionController@refreshToken');

Route::resource('comisiones', 'ComisionController');

Route::resource('permisos', 'PermisoController');
