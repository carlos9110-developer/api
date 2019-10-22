<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('tarjetas','TarjetaController@store'); // ruta para registrar las tarjetas
Route::get('tarjetas','TarjetaController@show');   // ruta para traer las tarjetas
Route::post('consultarSaldo','TarjetaController@consultarSaldo'); // ruta para consultar el saldo de una tarjeta

Route::post('compras','CompraController@store'); // ruta para registrar las compras
Route::get('compras','CompraController@show');// ruta para traer las compras 
Route::post('login','UserController@login'); // ruta para registrar las tarjetas

//Route::get('compras/{numeroFactura}','CompraController@traerCompra'); // ruta para traer una compra