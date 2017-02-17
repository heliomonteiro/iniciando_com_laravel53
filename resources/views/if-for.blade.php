<?php
$num = 20;
?>
{{ "Exemplo de estrutura condicional"}}

@if($num < 20)
	<p>Número é menor que vinte</p>
@elseif($num == 20)
	<p>Número é igual a vinte</p>
@else
	<p>Número é maior que vinte</p>
@endif

{{ "Exemplo de estrutura condicional" }}

{{ "FOR" }}

@for($i = 0; $i< 20; $i++)
	<p>Valor: {{ $i }}</p>
@endfor

{{ "WHILE" }}

<?php
$k = 0;
?>

@while($k < 20)
	<p>Valor: {{ $k }}</p>
	<?php $k++; ?>
@endwhile

{{ "FOREACH" }}

<?php
$array = [1,2,3,4,5];
?>

@foreach($array as $value)
	<p>Chave {{ $loop->index }}, Valor: {{ $value }}</p>
@endforeach

@php
$array = [];
@endphp

@forelse($array as $value)
	<p>Chave {{ $loop->index }}, Valor: {{ $value }}</p>
@empty
	<p>Nenhum elemento no array</p>
@endforelse