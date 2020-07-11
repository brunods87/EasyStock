@extends('layouts.app')


@section('content')

<div class="container py-1">
	<h1 class="text-center">Visualizar Fatura</h1>
	<div class="toolbar text-right">
        <a href="{{ route('invoices.index') }}">Voltar</a>    
    </div>
	<div class="row justify-content-center">
		<div class="col-10">
			<table class="table table-bordered view-table">
				<tr>
					<th>Número</th>
					<td>{{ $invoice->number }}</td>
				</tr>
				<tr>
					<th>Fornecedor</th>
					<td>{{ $invoice->supplier->name }}</td>
				</tr>
				<tr>
					<th>Data</th>
					<td>{{ $invoice->date }}</td>
				</tr>
				<tr>
					<th>Total</th>
					<td>{{ $invoice->total }}</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row justify-content-center mt-5">
		
		<h2 class="mb-3">Elementos da Fatura</h2>
		<div class="form col-12">
			<form method="POST" action="{{ route('invoiceItem.store') }}">
				@csrf
				<input type="hidden" name="invoiceID" value="{{$invoice->id}}">
			<div class="col-12">
				
				<table class="table table-bordered" id="invoiceItems">
					
					<thead>
						<tr>
							<th>Referência</th>
							<th>Descrição</th>
							<th>Unidade</th>
							<th style="width: 70px;">Qtd</th>
							<th>Preço Unitário</th>
							<th>Desconto</th>
							<th>Total</th>
							<th>IVA</th>
						</tr>
					</thead>
					<tbody>
						@foreach($invoice->invoice_items as $item)
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
							<td class="tax">{{$item->material->tax}}</td>
							<td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td>
						</tr>
						@endforeach
					</tbody>

				</table>
				<div class="text-center">
					<button type="button" data-toggle="modal" data-target="#createMaterialModal"><i class="far fa-plus-square"></i></button>
					<input type="submit" name="" value="Guardar">
				</div>
				@include('modals.createMaterialModal')

			</div>
			</form>
		</div>
	</div>

</div>


@endsection

@push('scripts')

	<script type="text/javascript">
		$(function () {
    
		    var table = $('.data-table-modal').DataTable({
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
			$('#invoiceItems tbody').append(html);
		}

		$(document).ready(function(){

			$(document).on('change', '#invoiceItems td.quantity input', function(event){

				var row = event.target.closest('tr');
				var price = Number(row.querySelector('.price').textContent);
				var quantity = Number(event.target.value);
				var total = price* quantity;
				row.querySelector('.total').innerHTML = total.toFixed(2) + " €";
			});
			$(document).on('click', '#invoiceItems td .delete-row', function(event){
				$(this).parent().parent().remove();
			});

		});
	</script>
	
@endpush