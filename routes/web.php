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
    return view('welcome');
});

Route::get('minharota', function () {
	return "Hello minha rota!";
});

Route::get('minharota/rota1', function () {
	return "Hello minha rota! - Rota 1";
});

//nada impede de enganar o usuario com um nome semelhante à um arquivo
Route::get('minharota/rota1.php', function () {
	return "Hello minha rota! - Rota 1";
});

//rota com parametro
//colocar ? para parametro opcional
Route::get('client/{id}/{name?}', function($id, $name = 'Fulano'){
	return "Client $id, $name";
});