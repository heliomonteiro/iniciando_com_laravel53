-----------
.gitignore
-----------
/node_modules
/public/storage
/vendor
/.idea
Homestead.json
Homestead.yaml
.env

----------------------------
Acessar variável global .env
----------------------------
-> $_ENV['MINHA_CHAVE]
-> getenv('MINHA_CHAVE)
OBs.: Sempre que mudar configuração no .ENV, reiniciar o servidor.

----------------------
Ambientes de trabalho
----------------------
-.ENV
APP_ENV=local (modo desenvolvimento) - Modo muito lento. Não utilizar no servidor, para não gerar muito cache.)
APP_ENV=prod (modo de produção) - utilizado no servidor)
APP_DEBUG=true (modo de debug) - utilizado em desenvolvimento - apresenta erros completos reportados pela aplicação)

-CONSOLE
php artisan down (coloca em modo de manutenção)
php artisan up (retorna do modo de manutenção)

Ambiente 			Variável 	Configuração
Produção 			APP_ENV 	prod
Produção 			APP_DEBUG 	false
Desenvolvimento 	APP_ENV 	local
Desenvolvimento 	APP_DEBUG 	true

----------------
Rotas amigaveis
----------------
Arquivo de rotas de acesso pelo navegador é:
routes/web.php
As rotas deste arquivo são atribuidos ao grupo middleware 'web' que possuem estado de sessão e proteção CSRF.
As rotas da middleware 'api' não poussuem estados e são atribuidos ao grupo middleware.

//MÉTODOS DA FACADE ROUTE
Route::get($uri, $callback); -> callback é uma closure
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);

//rota com parametro
//colocar ? para parametro opcional
Route::get('client/{id}/{name?}', function($id, $name = 'Fulano'){
	return "Client $id, $name";
});

//Rota com múltiplos verbos HTTP
Route::match(['get', 'post'], '/', function () {
    //
});

//Rota para qualquer verbo HTTP
Route::any('foo', function () {
    //
});

//CSRF
Formulários web apontando para rotas POST, PUT e DELETE são definidos na rota 'web' a incluir um campo token CSRF, caso contrário a requisição será rejeitada.

<form method="POST" action="/profile">
    {{ csrf_field() }}
    ...
</form>

//Rotas podem devem retornar um controller@metodo. Além, a rota pode ser nomeada.
Route::get('user/profile', 'UserController@showProfile')->name('profile');

//Rotas podem conter namespace ou prefixo para organizar o arquivo de rotas
//Rotas podem usar um model para associar o id e retornar algum valor de forma automática.

//Method Spoofing - Formulários HTML não suportam PUT, PATCH e DELETE. Portanto, uma forma é adicionar um campo oculto com o valor do método, assim como o CSRF token.

<form action="/foo/bar" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>

Pode ser utilizado o helper do laravel a seguir para gerar o html input.
{{ method_field('PUT') }}

//Acessando a rota atual
$route = Route::current();
$name = Route::currentRouteName();
$action = Route::currentRouteAction();

-------------------------
Rotas, post e formularios
-------------------------

//Delimitador string de várias linhas
$html = <<<HTML
	<html>
		<body>
			<form>
			...
			</form>
		</body>
	</html>
HTML;

//Rotas com mesmo nome
Rota de formulário e rota de retorno com mesmo nome. O laravel os diferenciará pelo verbo HTTP.

//Sobre o csrf Token
O laravel sempre procura pelo campo com name _token e o valor do csrfToken() em requisições POST, PUT e DELETE.

//Rota nomeada
Útil para manutenibilidade futura, caso a rota física seja mudada. Não será necessário procurar e mudar todos os lugares que chamam esta rota.