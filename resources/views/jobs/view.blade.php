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
				<td>{{ $job->quote_value }} €</td>
			</tr>
			<tr>
				<th>Morada</th>
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
	<div class="row justify-content-center mt-3">
		
		<div class="form col-12">
			<form method="POST" action="{{ route('jobs.storeItems') }}">
				@csrf
				<input type="hidden" name="jobID" value="{{$job->id}}">
			<div class="col-12">
				<h2 class="text-center">Materiais</h2>
				<table class="table table-bordered" id="jobItemsMaterials">
					
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
						@foreach($job->materials() as $item)
						<tr>
							<td class="reference">{{$item->expense_jobable->reference}}<input type="hidden" name="Material[material_id][]" value="{{$item->expense_jobable->id}}"></td>
							<td class="name">{{$item->expense_jobable->name}}</td>
							<td class="unity">{{$item->expense_jobable->unity->name}}</td>
							<td class="quantity">
								<input type="number" onclick="select();" name="Material[quantity][]" value="{{floatval($item->quantity)}}" step="0.01" min="0">
							</td>
							<td>{{$item->expense_jobable->price}}</td>
							<td>{{ number_format($item->expense_jobable->discountInvoiceJob($job->id),2) }}</td>
							<td class="total">{{number_format($item->expense_jobable->priceInvoiceJob($job->id),2)}} €<input type="hidden" name="Material[expense_id][]" value="{{$item->id}}"></td>
							<td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td>
						</tr>
						@endforeach
					</tbody>

				</table>
				<h2 class="text-center">Mão de Obra</h2>
				<table class="table table-bordered" id="jobItemsEmployees">
					
					<thead>
						<tr>
							<th>Número</th>
							<th>Nome</th>
							<th>Salário</th>
							<th>Valor Hora</th>
							<th>Quantidade</th>
							<th>Valor Hora Extra</th>
							<th>Quantidade Extra</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						@foreach($job->employees() as $item)
						<tr>
							<td class="number">{{$item->expense_jobable->number}}<input type="hidden" name="Employee[employee_id][]" value="{{$item->expense_jobable->id}}"></td>
							<td class="name">{{$item->expense_jobable->name}}<input type="hidden" name="Employee[expense_id][]" value="{{$item->id}}"></td>
							<td class="salary">{{$item->expense_jobable->salary}}</td>
							<td class="value_hour">{{$item->expense_jobable->value_hour}}</td>
							<td class="quantity">
								<input type="number" onclick="select();" name="Employee[quantity][]" value="{{floatval($item->quantity)}}" step="0.01" min="0">
							</td>
							<td class="value_extra_hour">{{$item->expense_jobable->value_extra_hour}}</td>
							<td class="quantity_extra">
								<input type="number" onclick="select();" name="Employee[quantity_extra][]" value="{{floatval($item->quantity_extra)}}" step="0.01" min="0">
							</td>
							<td class="total">{{$item->total}} €</td>
							<td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td>
						</tr>
						@endforeach
					</tbody>

				</table>
				<h2 class="text-center">Ganhos</h2>
				<table class="table table-bordered" id="jobItemsProfits">
					
					<thead>
						<tr>
							<th>Número</th>
							<th>Data</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
				<div class="text-center mt-3">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExpensesModal"><i class="far fa-plus-square mr-2"></i>Gasto</button>
					<button type="button" class="btn btn-primary" id="addProfitButton"><i class="far fa-plus-square mr-2"></i>Ganho</button>
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
		            {data: 'number', name: 'number', className: 'number'},
		            {data: 'name', name: 'name', className: 'name'},
		            {data: 'admission_date', name: 'admission_date'},
		            {data: 'salary', name: 'salary', className: 'salary'},
		            {data: 'value_hour', name: 'value_hour', className: 'value_hour'},
		            {data: 'value_extra_hour', name: 'value_extra_hour', className: 'value_extra_hour'},
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
			var html = '<tr><td class="reference">'+material.reference+'<input type="hidden" name="Material[material_id][]" value="'+material.id+'"></td><td class="name">'+material.name+'</td><td class="unity">'+material.unity+'</td><td class="quantity"><input type="number" onclick="select();" name="Material[quantity][]" value="0" step="0.01" min="0"></td><td class="price">'+material.price+'</td><td class="discount">'+material.discount+'</td><td class="total">0,00 €<input type="hidden" name="Material[expense_id][]" value="0"></td><td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td></tr>';
			$('#jobItemsMaterials tbody').append(html);
		}
		var array_employees = @json($job->employeesIds());
		function insertEmployee(el)
		{
			var row = el.closest('tr');
			var employee = {
				id: row.querySelector('.id').textContent,
				number: row.querySelector('.number').textContent,
				name: row.querySelector('.name').textContent,
				salary: row.querySelector('.salary').textContent,
				value_hour: row.querySelector('.value_hour').textContent,
				value_extra_hour: row.querySelector('.value_extra_hour').textContent,
			}
			if (!array_employees.includes(employee.id)){
				var html = '<tr><td class="number">'+employee.number+'<input type="hidden" name="Employee[employee_id][]" value="'+employee.id+'"></td><td class="name">'+employee.name+'<input type="hidden" name="Employee[expense_id][]" value="0"></td><td class="salary">'+employee.salary+'</td><td class="value_hour">'+employee.value_hour+'</td><td class="quantity"><input type="number" onclick="select();" name="Employee[quantity][]" value="0" step="0.01" min="0"></td><td class="value_extra_hour">'+employee.value_extra_hour+'</td><td class="quantity_extra"><input type="number" onclick="select();" name="Employee[quantity_extra][]" value="0" step="0.01" min="0"></td><td class="total">0,00 €</td><td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td></tr>';
				array_employees.push(employee.id);
				$('#jobItemsEmployees tbody').append(html);
			}
		}

		$(document).ready(function(){

			$(document).on('change', '#jobItemsMaterials td.quantity input', function(event){

				var row = event.target.closest('tr');
				var price = Number(row.querySelector('.price').textContent);
				var quantity = Number(event.target.value);
				var total = price* quantity;
				row.querySelector('.total').innerHTML = total.toFixed(2) + " €";
			});
			$(document).on('change', '#jobItemsEmployees td input', function(event){

				var row = event.target.closest('tr');
				var price = Number(row.querySelector('.value_hour').textContent);
				var quantity = Number(row.querySelector('.quantity input').value);
				var price_extra = Number(row.querySelector('.value_extra_hour').textContent);
				var quantity_extra = Number(row.querySelector('.quantity_extra input').value);
				var total = (price* quantity) + (price_extra * quantity_extra);
				row.querySelector('.total').innerHTML = total.toFixed(2) + " €";
			});
			$(document).on('click', 'table td .delete-row', function(event){
				$(this).parent().parent().remove();
			});
			$('#addProfitButton').on('click', function(){
				var html = '<tr><td><input type="text" name="Profit[number][]"></td><td><input type="date" name="Profit[date][]"></td><td><input type="number" name="Profit[total][]"></td><td><button type="button" class="btn btn-danger delete-row"><i class="fas fa-trash"></i></button></td></tr>';
				$('#jobItemsProfits tbody').append(html);
			});

		});
	</script>
	
@endpush