@extends('layouts.app')


@section('content')

<div class="container py-1">
	<h1 class="text-center">Adicionar Material</h1>
	<div class="toolbar text-right">
        <a href="{{ route('materials.index') }}">Voltar</a>    
    </div>
	{!! $form !!}
</div>


@endsection