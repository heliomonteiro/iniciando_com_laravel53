<p>Client {{ $id }}, {{ $name }} </p>

<p>{{ 2 + 2 }}</p>
<p>{{ $name . " Júnior"}}</p>
<p>{{ isset($conteudo) ? $conteudo : "Varivável não existe" }}</p>
<p>{{ $conteudo or 'Variavel não existe' }}</p>
<p> {{ "<a href='#'>Link</a>" }} </p> <!-- interpolacao segura - htmlentities do php - interpolacao unescaped-->
<p> {!! "<a href='#'>Link</a>" !!} </p> <!-- interpolacao real - interpolacao scaped-->