@extends('layouts.app')


@section('content')

<div class="container py-5">
	<h1 class="text-center">Adicionar Tipo</h1>
	<div class="toolbar text-right">
        <a href="{{ route('types.index') }}">Voltar</a>    
    </div>
	{!! $form !!}
</div>


@endsection