@extends('layouts.app')


@section('content')
<div class="row mx-0">
<aside class="col-2 sidebar">
	<div class="sidebar-inner">
	<h2 class="text-center">Folha de Obra</h2>
	<div class="data">
		<table class="table table-bordered view-table">
			<tr>
				<th>Nome</th>
				<td>{{ $job->name }}</td>
			</tr>
			<tr>
				<th>Referência</th>
				<td>{{ $job->reference }}</td>
			</tr>
			<tr>
				<th>Cliente</th>
				<td>{{ $job->client->name }}</td>
			</tr>
			<tr>
				<th>Data</th>
				<td>{{ $job->date }}</td>
			</tr>
			<tr>
				<th>Total Orçamentado</th>
				<td>{{ $job->quote_value }}</td>
			</tr>
			<tr>
				<th>Moradao</th>
				<td>{{ $job->address }}</td>
			</tr>
			<tr>
				<th>Tipo</th>
				<td>{{ $job->type }}</td>
			</tr>
		</table>
	</div>
</div>
</aside>
<div class="col-10">
<div class="container py-3">
	<h1 class="mb-3 text-center">Elementos da Obra</h1>
		<div class="toolbar text-right">
        <a href="{{ route('jobs.index') }}">Voltar</a>    
    </div>
	<div class="row justify-content-center mt-5">
		
		<div class="form col-12">
			<form method="POST" action="{{ route('jobs.storeItems') }}">
				@csrf
				<input type="hidden" name="jobID" value="{{$job->id}}">
			<div class="col-12">
				
				<table class="table table-bordered" id="jobItems">
					
					<thead>
						<tr>
							<th>Referência</th>
							<th>Descrição</th>
							<th>Unidade</th>
							<th style="width: 70px;">Qtd</th>
							<th>Preço Unitário</th>
							<th>Desconto</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						@foreach($job->job_expenses as $item)
						<tr>
							<td class="reference">{{$item->material->reference}}</td>
							<td class="name">{{$item->material->name}}</td>
							<td class="unity">{{$item->material->unity->name}}</td>
							<td class="quantity">
								<input type="number" onclick="select();" name="quantity[{{$item->material->id}}]" value="{{floatval($item->quantity)}}" step="0.01" min="0">
							</td>
							<td class="price">{{$item->material->price}}</td>
							<td class="discount">{{$item->material->discount}}</td>
							<td class="total">{{$item->total()}} €</td>
							<td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td>
						</tr>
						@endforeach
					</tbody>

				</table>
				<div class="text-center">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExpensesModal"><i class="far fa-plus-square mr-2"></i>Despesa</button>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#"><i class="far fa-plus-square mr-2"></i>Receita</button>
					<input type="submit" class="btn btn-primary" name="" value="Guardar">
				</div>
				@include('modals.addExpensesModal')

			</div>
			</form>
		</div>
	</div>

</div>


@endsection

@push('scripts')

	<script type="text/javascript">
		$(function () {
    
		    var table = $('.data-table-materials').DataTable({
		        processing: true,
		        serverSide: true,
		        ajax: "{{ route('materials.insert') }}",
		        columns: [
		            {data: 'id', name: 'id', className: 'id'},
		            {data: 'name', name: 'name', className: 'name'},
		            {data: 'reference', name: 'reference', className: 'reference'},
		            {data: 'price', name: 'price', className: 'price'},
		            {data: 'unity_id', name: 'unity', className: 'unity'},
		            {data: 'supplier_id', name: 'supplier_id', className: 'supplier'},
		            {data: 'category_id', name: 'category_id', className: 'category'},
		            {data: 'type_id', name: 'type_id', className: 'type'},
		            {data: 'stock', name: 'stock', className: 'stock'},
		            {data: 'discount', name: 'discount', className: 'discount'},
		            {data: 'tax', name: 'tax', className: 'tax'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ],
		        "order": [[ 1, "asc" ]]
		    });

		    var table_employees = $('.data-table-employees').DataTable({
		        processing: true,
		        serverSide: true,
		        ajax: "{{ route('employees.insert') }}",
		        columns: [
		            {data: 'id', name: 'id', className: 'id'},
		            {data: 'number', name: 'number'},
		            {data: 'name', name: 'name'},
		            {data: 'admission_date', name: 'admission_date'},
		            {data: 'salary', name: 'salary'},
		            {data: 'value_hour', name: 'value_hour'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ],
		        "order": [[ 1, "asc" ]]
		    });
		    
		  });
	</script>
	<script type="text/javascript">
		function insertMaterial(el)
		{
			var row = el.closest('tr');
			var material = {
				id: row.querySelector('.id').textContent,
				reference: row.querySelector('.reference').textContent,
				name: row.querySelector('.name').textContent,
				unity: row.querySelector('.unity').textContent,
				price: row.querySelector('.price').textContent,
				discount: row.querySelector('.discount').textContent,
				tax: row.querySelector('.tax').textContent
			}
			var html = '<tr><td class="reference">'+material.reference+'</td><td class="name">'+material.name+'</td><td class="unity">'+material.unity+'</td><td class="quantity">							<input type="number" onclick="select();" name="quantity['+material.id+']" value="0" step="0.01" min="0"></td><td class="price">'+material.price+'</td><td class="discount">'+material.discount+'</td><td class="total">0,00 €</td><td class="tax">'+material.tax+'</td><td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td></tr>';
			$('#jobItems tbody').append(html);
		}

		$(document).ready(function(){

			$(document).on('change', '#jobItems td.quantity input', function(event){

				var row = event.target.closest('tr');
				var price = Number(row.querySelector('.price').textContent);
				var quantity = Number(event.target.value);
				var total = price* quantity;
				row.querySelector('.total').innerHTML = total.toFixed(2) + " €";
			});
			$(document).on('click', '#jobItems td .delete-row', function(event){
				$(this).parent().parent().remove();
			});

		});
	</script>
	
@endpush