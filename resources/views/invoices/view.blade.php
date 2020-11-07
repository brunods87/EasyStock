<?php

use App\Job;

?>

@extends('layouts.app')


@section('content')
<div class="row mx-0">
<aside class="col-2 sidebar">
	<div class="sidebar-inner">
		<h2 class="text-center">Fatura</h2>
		<div class="data">
			
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
					<th>Total Ilíquido</th>
					<td>{{ number_format($invoice->subtotal(),2,',','.') }} €</td>
				</tr>
				<tr>
					<th>Total Descontos</th>
					<td>{{ number_format($invoice->totalDiscount(),2,',','.') }} €</td>
				</tr>
				<tr>
					<th>Total Líquido</th>
					<td>{{ number_format($invoice->subtotal(true),2,',','.') }} €</td>
				</tr>
				<tr>
					<th>Total IVA</th>
					<td>{{ number_format($invoice->totalTax(),2,',','.') }} €</td>
				</tr>
				<tr>
					<th>Total a pagar</th>
					<td>{{ number_format($invoice->getTotal(),2,',','.') }} €</td>
				</tr>
			</table>
			
		</div>
	</div>
</aside>
<div class="col-10">
	<div class="container-fluid py-3 px-0">
		<h1 class="mb-3 text-center">Elementos da Fatura</h1>
		<div class="toolbar text-right">
	        <a href="{{ route('invoices.index') }}">Voltar</a>    
	    </div>
		<div class="row justify-content-center mt-5">
			
			<div class="form col-12">
				<form method="POST" action="{{ route('invoiceItem.store') }}">
					@csrf
					<input type="hidden" name="invoiceID" value="{{$invoice->id}}">
				<div class="col-12">
					
					<table class="table table-bordered text-center" id="invoiceItems">
						
						<thead>
							<tr>
								<th>Referência</th>
								<th>Descrição</th>
								<th>Unidade</th>
								<th style="width: 70px;">Qtd</th>
								<th>Preço Unitário</th>
								<th style="width: 180px;">Desconto</th>
								<th>IVA</th>
								<th class="total">Total</th>
								<th class="job">Obra</th>
							</tr>
						</thead>
						<tbody>
							@foreach($invoice->invoice_items as $item)
							<tr>
								<td class="reference">{{$item->material->reference}}<input type="hidden" name="material_id[]" value="{{$item->material->id}}"></td>
								<td class="name"><textarea class="description" name="description[]">{{$item->description}}</textarea><input type="hidden" name="item_id[]" value="{{$item->id}}"></td>
								<td class="unity">{{$item->material->unity->name}}</td>
								<td class="quantity">
									<input type="number" class="quantity-input" data-id="{{$item->material->id}}" onclick="select();" name="quantity[]" value="{{floatval($item->quantity)}}" step="0.01" min="0">
								</td>
								<td class="price">{{$item->material->price}}</td>
								<td class="discount"><input type="number" class="material-discount" min=0 onclick="select();" name="discount_1[]" value="{{floatval($item->discount_1)}}"> + <input type="number" name="discount_2[]" class="extra-discount" min=0 onclick="select();" value="{{floatval($item->discount_2)}}"></td>
								<td class="tax">{{$item->material->tax}}</td>
								<td class="total">{{number_format($item->total(),2)}} €</td>
								<td class="job"><select class="job-select" name="job[]">{!! Job::dropdownSelect($item->job_id) !!}</select></td>
								<td class="actions"><button type="button" data-id="{{$item->id}}" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button><button type="button" class="insert-here btn btn-primary" onclick="setRow(this);"><i class="far fa-plus-square"></i></button></td>
							</tr>
							@endforeach
						</tbody>

					</table>
					<div class="text-center">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMaterialModal"><i class="far fa-plus-square"></i></button>
						<input type="submit" class="btn btn-primary" name="" value="Guardar">
					</div>
					@include('modals.createMaterialModal')

				</div>
				</form>
			</div>
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
		var jobsArray = [];
		var jobsDropdown = '<option value=""></option>';
		var insertAt = null;

		function setRow(el)
		{
			insertAt = el.parentElement.parentElement.rowIndex;
			$('#createMaterialModal').modal('show');
		}
		function insertMaterial(el)
		{
			var row = el.closest('tr');
			var material = {
				id: Number(row.querySelector('.id').textContent),
				reference: row.querySelector('.reference').textContent,
				name: row.querySelector('.name').textContent,
				unity: row.querySelector('.unity').textContent,
				price: row.querySelector('.price').textContent,
				discount: row.querySelector('.discount').textContent,
				tax: row.querySelector('.tax').textContent
			}

			var html = '<tr><td class="reference">'+material.reference+'<input type="hidden" name="material_id[]" value="'+material.id+'"></td><td class="name"><textarea class="description" name="description[]">'+material.name+'</textarea><input type="hidden" name="item_id[]" value="0"></td><td class="unity">'+material.unity+'</td><td class="quantity"><input type="number" class="quantity-input" onclick="select();" data-id="'+material.id+'" name="quantity[]" value="0" step="0.01" min="0"></td><td class="price">'+material.price+'</td><td class="discount"><input type="number" name="discount_1[]" class="material-discount" value='+material.discount+' onclick="select();" data-id="'+material.id+'" min="0"> + <input type="number" value=0 onclick="select();" name="discount_2[]" class="extra-discount" data-id="'+material.id+'" min="0"></td><td class="tax">'+material.tax+'</td><td class="total">0,00 €</td><td class="job"><select class="job-select" name="job[]">'+jobsDropdown+'</select></td><td class="actions"><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button><button type="button" class="insert-here btn btn-primary" onclick="setRow(this);"><i class="far fa-plus-square"></i></button></td></tr>';
			if (insertAt != null){
				var table = document.getElementById('invoiceItems');
				var row = table.insertRow(insertAt+1);
				row.innerHTML = html;
				insertAt = null;
			}else{
				$('#invoiceItems tbody').append(html);	
			}
				
		}

		$(document).ready(function(){

			
			$.ajax({
				type: 'POST',
				url: '{{ route('jobs.getJobs') }}',
			}).done(function(response){
				jobsArray = response;
				jobsArray.forEach(function(el){
					jobsDropdown += '<option value="'+el.id+'">REF: '+el.reference+' | NOME: '+el.name+'</option>';
				});
			});

			$(document).on('change', '#invoiceItems td input', function(event){

				var id = event.target.dataset.id;
				var row = event.target.closest('tr');
				var price = Number(row.querySelector('.price').textContent);
				var quantity = Number(row.querySelector('.quantity-input').value);
				var discount_1 = Number(row.querySelector('.material-discount').value);
				var discount_2 = Number(row.querySelector('.extra-discount').value);
				
				if (discount_1 > 0){
					var sub = price * (discount_1/100);
					price -= sub; 
				}
				if (discount_2 > 0){
					var sub2 = price * (discount_2/100);
					price -= sub2; 
				}
				var total = price * quantity;
				row.querySelector('.total').innerHTML = total.toFixed(2) + " €";
				
			});
			$(document).on('click', '#invoiceItems td .delete-row', function(event){
				var id = $(this).data('id');
				if (id){
					if (confirm('Eliminar o elemento da fatura?')){
						$.ajax({
							type: 'POST',
							url: '{{route("invoiceItem.destroy")}}',
							data: {id: id}
						}).done(function(response){
							alert(response.msg);
							location.reload();
						});
					}
				}else{
					$(this).parent().parent().remove();
				}
			});

		});
	</script>
	
@endpush