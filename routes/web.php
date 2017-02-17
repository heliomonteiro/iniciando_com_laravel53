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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('minharota', function () {
	return "Hello minha rota!";
});

//retornando uma view - modo correto - separa a responsabilidade da view e da rota.
Route::get('minharota.php', function() {
	return view('helloworld');
});

Route::get('minharota/rota1', function () {
	return view('helloworld1');
});

//nada impede de enganar o usuario com um nome semelhante à um arquivo
Route::get('minharota/rota1.php', function () {
	return "Hello minha rota! - Rota 1";
});

//Rota de formulário e rota de retorno com mesmo nome. O laravel os diferenciará pelo verbo HTTP.
Route::get('client', function () {
	return view('client');
});

//rota com parametro
//colocar ? para parametro opcional
Route::get('client/{id}/{name?}', function($id, $name = 'Fulano'){
	return view('client-name')
	->with('id', $id)
	->with('name', $name)
	->with('conteudo', 'teste');
	/*return view('client-name', [
		'id' => $id,
		'name' => $name
		]);*/
});

Route::post('cliente', function(Request $request){
	return $request->get('value');
})->name('client.store'); //aqui foi utilizado uma rota nomeada.

Route::get('if-for', function() {
	return view('if-for');
});