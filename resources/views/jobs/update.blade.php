@extends('layouts.app')


@section('content')

<div class="container py-5">
	<h1 class="text-center">Editar Folha de Obra</h1>
	<div class="toolbar text-right">
        <a href="{{ route('jobs.index') }}">Voltar</a>    
    </div>
	{!! $form !!}
</div>


@endsection