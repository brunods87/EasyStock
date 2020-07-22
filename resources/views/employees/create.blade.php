@extends('layouts.app')


@section('content')

<div class="container py-3">
	<h1 class="text-center">Adicionar Funcionário</h1>
	<div class="toolbar text-right">
        <a href="{{ route('employees.index') }}">Voltar</a>    
    </div>
	{!! $form !!}
</div>


@endsection