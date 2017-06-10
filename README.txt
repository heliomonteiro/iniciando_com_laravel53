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

------
Views
------
Importante lembrar que o arquivo de rotas serve para escrever e organizar as rotas. Portanto, ficar escrevendo codigos html para retorno deixa o código bem grande. Por isso, criar uma view separado.

Invés de:
Route::get('minharota', function () {
	return "Hello minha rota!";
});

Usar:
//retornando uma view - modo correto - separa a responsabilidade da view e da rota.
Route::get('minharota', function() {
	return view('helloworld');
});

Por padrão, o laravel procura no diretório 'resources/views/' pelo nome da view.

//Envio de dados para a view
return view('greetings', ['name' => 'Victoria']);
ou
return view('greeting')->with('name', 'Victoria');

Ex.:
Route::get('client/{id}/{name?}', function($id, $name = 'Fulano'){
	return view('client-name')
	->with('id',$id)
	->with('name', $name);
	/*return view('client-name', [
		'id' => $id,
		'name' => $name
		]);*/
});

//Acessando os dados pela view
<?php echo $id; ?>
<?php echo $name; ?>


//Retornar view em um diretorio dentro do diretorio views. Lembrar de separar por pontos cada diretorio.
return view('admin.profile', $data);

------
Blade
------
Utilizamos o arquivo de rotas para rotas e view para html, porém ainda misturamos o codigo html com php. Porquê não utilizar uma template engine para dar este suporte?
O blade permite uma forma mais clara de usar codigos php sem poluir o codigo html.

Agora o nome de nossas view vao ter o prefixo .blade acrescidos antes da extensao .php

Na chamada do nome da view:
view('welcome')
O laravel procura por .php ou .blade.php, não é preciso preocupar com isso :D

//INTERPOLAÇÃO
transportar um conjunto de um lugar para conseguir mostrar. Em outras palavras, tornar funções complexas em algo mais simples.

//Por tras dos panos
O Blade pega a view e gera um novo código php. Localizado na pasta 'Storage/framewoerk/views';

--------------------------------
Um pouco mais sobre interpolação
---------------------------------
Com o blade pode ser utilizado as mesmas operações do php. Quando for imprimir codigo html, deve ser utilizado a forma de interpolação escaped.
O blade apresenta uma forma pratica de utilizar operador ternario.

<p>{{ 2 + 2 }}</p>
<p>{{ $name . " Júnior"}}</p>

//Operador ternario
<p>{{ isset($conteudo) ? $conteudo : "Varivável não existe" }}</p>
<p>{{ $conteudo or 'Variavel não existe' }}</p>

//interpolacao segura - htmlentities do php - interpolacao escaped
<p> {{ "<a href='#'>Link</a>" }} </p>

//interpolacao real - interpolacao unescaped
<p> {!! "<a href='#'>Link</a>" !!} </p>

--------------------------------------------
BLADE - Estruturas condicionais e repetição
--------------------------------------------
//COMENTARIOS
{{-- Este é um comentário --}}

//CODIGO PHP
<?php $var = 10; ?>

ou

@php
$var = 10;
@endphp

//ESTRUTURAS DE CONTROLE

//IF
@if (count($records) === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif
//por conveniencia existe o unless
@unless (Auth::check())
    You are not signed in.
@endunless

//LOOPS
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor

@foreach ($users as $user)
    <p>This is user {{ $user->id }}</p>
@endforeach

@forelse ($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse

@while (true)
    <p>I'm looping forever.</p>
@endwhile

//conveniencia no loop
Existe a variável loop à qual podemos acessar alguns atributos do loop atual. Tais como index, iteration, remaining, count, first, last, depth, parent.

@foreach ($users as $user)
    @if ($loop->first)
        This is the first iteration.
    @endif

    @if ($loop->last)
        This is the last iteration.
    @endif

    <p>This is user {{ $user->id }}</p>
@endforeach

---------
ARTISAN
---------
php -S localhost:8000 -t public public/index.php
//root é a pasta public
//todas as requisições redirecionadas para public/index.php
//Corresponde à
php artisan serve

O artisan é um console que oferece várias facilidades como esta.
Outras sao para criar alguns elementos como filas, models, controllers;
listar as rotas da aplicação, útil para vc entender as rotas de uma aplicação que já está em desenvolvimento em equipe;
Gerar key da aplicação;
E outras tarefas cotidiana.

------------
CONTROLLERS
------------
php artisan make:controller ClientsController

//Diretorios
App -> Onde fica todo codigo fonte da aplicação, excluindo as views.
App/Http/Controllers -> onde fica os controllers

Quando utilizar closure e quando utilizar controller nas rotas?
Utilizar controller para centralizar várias ações. Exemplo: CRUD todas as ações em um controller.
Quando for uma rota para apenas um retorno simples, pode ser utilizado uam closure.

EX.:
--rotas--
Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientsController@create');

Route::post('cliente', 'ClientsController@store')->name('client.store');

--ClientsController--
class ClientsController extends Controller
{
    public function create(){
    	return view('client');
    }

    public function store(Request $request){
    	return $request->get('value');
    }
}

--------------------
Agrupamento de rotas
--------------------

Podemos utilizar o método group para agrupar rotas adicionando um prefixo na sua url. Este prefixo também pode ser inserido no nome da rota através do parametro 'as'.

Ex.:

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
	Route::get('client', 'ClientsController@create');
	Route::post('cliente', 'ClientsController@store')->name('client.store');
	//novo nome da rota é admin.client.store;
});

Route::group(['prefix' => '', 'as' => 'site.'], function(){
	Route::get('client', 'SiteClientsController@create');
	Route::post('cliente', 'SiteClientsController@store')->name('client.store');
	//novo nome da rota é site.client.store
});

--------------------------------
Models, Migration e Eloquent ORM
--------------------------------
A model criada será extendida da classe illuminate\Datagase\Eloquent\Model

Por convensão o nome da classe fica no plural e ele associará a classe á tabela com o mesmo nome no plural.
Ex.: classe Flight -> tabela flights.
Ou pode ser setado manualmente a tabela correspondente criando uma variavel protected com o nome $table para definir a tabela no banco de dados.

EX.:
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'my_flights';
}


//GERANDO UMA MODEL
php artisan make:model User //classe singular, inicial maiuscula para padrao do laravel

//GERANDO UMA MODEL COM MIGRATION
php artisan make:model User --migration
//ou
php artisan make:model User -m


--------------------------------
Trabalhando com migrations
--------------------------------
//make:migration cria a migração na pasta database/migrations
php artisan make:migration create_users_table

//especificando a model
php artisan make:migration create_users_table --create=users

//especificando a tabela
php artisan make:migration add_votes_to_users_table --table=users

O método up refere-se ao make:migration e o down ao migrate:rollback

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('airline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flights');
    }
}

//CONFERINDO A EXISTENCIA DE UMA TABELA OU COLUNA
if (Schema::hasTable('users')) {
    //
}

if (Schema::hasColumn('users', 'email')) {
    //
}

//DEFININDO A CONEXAO
Schema::connection('foo')->create('users', function (Blueprint $table) {
    $table->increments('id');
});

//DEFININDO A ENGINE
Schema::create('users', function (Blueprint $table) {
    $table->engine = 'InnoDB';

    $table->increments('id');
});

//RENOMEANDO TABELA
Schema::rename($from, $to);

//DROPANDO TABELA
Schema::drop('users');

Schema::dropIfExists('users');


--------------------------------
Artisan Tinker
--------------------------------
repl - read eval print loop

OBS.: Se fizer alteração na aplicação, deve ser reiniciado o tinker para usufruir da alteração.

php artisan tinker - abre o terminal tinker

funciona comandos php e utiliza pode ser utilizado todos os recursos da App. Para testar podemos por exemplo:

criar um objeto do tipo Client que se encontra na App.

//NOVA INSTANCIA DE UMA MODEL
$client = new \App\Client();

//ACESSANDO OS ELEMENTOS
$client->name = "Helio Monteiro";
$client->address = "Rua x";

//METODOS DO ELOQUENT
$client->save();        //SALVA NO BANCO
\App\Client::all();     //RETORNA TODOS ELEMENTOS DO BANCO

$clientTeste = \App\Client::find(); //BUSCA POR ID

$clientTeste->delete();         //DELETA OBJETO NO BANCO

--------------------------------
Mass Assignment e fillable
--------------------------------
coc
convention of configuration

Sobrescrevendo a variavel $fillable conseguimos especificar quais campos da tabela serão acessíveis. Evitando inserções indevidas por exemplo.

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'address'
    ];
}

--------------------------------
Listando Clientes e Cadastrando
--------------------------------

//ROTA
Route::group(['prefix' => 'eloquent', 'as' => 'eloquent.'], function(){
    Route::get('clients', 'EloquentClientsController@index')->name('client.list');
    Route::get('clients/create', 'EloquentClientsController@create')->name('client.create');
    Route::post('clients/store', 'EloquentClientsController@store')->name('client.store');

});

//CONTROLLER
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class EloquentClientsController extends Controller
{
    public function index(){

        $clients = Client::all();

        return view('eloquent.index', [
            'clients' => $clients
        ]);
    }

    public function create(){
        return view('eloquent.create');
    }

    public function store(Request $request){
        $client = new Client();
        $client->create($request->all());
        return redirect()->route('eloquent.client.list');
    }
}

//APONTANDO UM LINK PARA UMA ROTA
    <a href="{{ route('eloquent.client.create') }}"> Criar novo cliente</a>

//REDIRECT
        return redirect()->route('eloquent.client.list');