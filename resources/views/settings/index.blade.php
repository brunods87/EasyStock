@extends('layouts.app')


@section('content')

<div class="container py-5">
	<h1 class="text-center">Editar Definições</h1>
	<div class="toolbar text-right">
        <a href="{{ route('home.index') }}">Voltar</a>    
    </div>
	{!! $form !!}
</div>


@endsection