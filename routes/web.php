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


//Rota de formulário e roda de retorno com mesmo nome. O laravel os diferenciará pelo verbo HTTP.
Route::get('client', function () {
	$csrfToken = csrf_token(); // helper laravel para gerar o token.
	$action = route('client.store');
	//string com o codigo html.
	$html = <<<HTML
	<html>
		<body>
			<form method="post" action="$action">
				<input type="hidden" name="_token" value="$csrfToken"/>
				<input type="text" name="value"/>
				<button type="submit">Enviar</button>
			</form>
		</body>
	</html>			
HTML;

	return $html;
});

Route::post('cliente', function(Request $request){
	return $request->get('value');
})->name('client.store'); //aqui foi utilizado uma rota nomeada.