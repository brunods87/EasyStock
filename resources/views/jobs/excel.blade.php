<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{ HTML::style('/css/excel.css') }}
<table>
	<tbody>
	<tr>
		<th>Folha de Obra</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Referência:</th>
		<td>{{$data->reference}}</td>
	</tr>
	<tr>
		<th>Data:</th>
		<td>{{$data->date}}</td>
	</tr>
	</tbody>
</table>
<table class="table job-table" id="jobItemsMaterials">
						
	<thead>
		<tr><th colspan="7" style="text-align: center;font-weight: bold;border: 1px solid #000000;">MATERIAIS</th></tr>
		<tr>
			<th>Referência</th>
			<th>Descrição</th>
			<th>Unidade</th>
			<th style="width: 70px;">Qtd</th>
			<th>Preço Unitário</th>
			<th>Desconto</th>
			<th style="text-align: right;">Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data->materials() as $item)
		@if(is_null($item->expense_jobable)) @continue @endif
		<tr>
			<td class="reference">{{$item->expense_jobable->material->reference}}</td>
			<td class="name">{{$item->expense_jobable->description}}</td>
			<td class="unity">{{$item->expense_jobable->material->unity->name}}</td>
			<td class="quantity">
				{{floatval($item->quantity)}}
			</td>
			<td>{{$item->expense_jobable->material->price}}</td>
			<td>{{ number_format($item->expense_jobable->discountInvoiceJob(),2) }}</td>
			<td class="total" style="text-align: right;">{{number_format($item->expense_jobable->total(),2)}} €</td>
		</tr>
		@endforeach
	</tbody>

</table>
<table class="table job-table" id="jobItemsEmployees">
						
	<thead>
		<tr><th colspan="8" style="text-align: center;font-weight: bold;border: 1px solid #000000;">MÃO DE OBRA</th></tr>
		<tr>
			<th>Número</th>
			<th>Nome</th>
			<th>Salário</th>
			<th>Valor Hora</th>
			<th>Quantidade</th>
			<th>Valor Hora Extra</th>
			<th>Quantidade Extra</th>
			<th style="text-align: right;">Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data->employees() as $item)
		@if(is_null($item->expense_jobable)) @continue @endif
		<tr>
			<td class="number">{{$item->expense_jobable->number}}</td>
			<td class="name">{{$item->expense_jobable->name}}</td>
			<td class="salary">{{$item->expense_jobable->salary}}</td>
			<td class="value_hour">{{$item->expense_jobable->value_hour}}</td>
			<td class="quantity">
				{{floatval($item->quantity)}}
			</td>
			<td class="value_extra_hour">{{$item->expense_jobable->value_extra_hour}}</td>
			<td class="quantity_extra">
				{{floatval($item->quantity_extra)}}
			</td>
			<td class="total" style="text-align: right;">{{$item->total}} €</td>
		</tr>
		@endforeach
	</tbody>

</table>
<table class="table job-table" id="jobItemsProfits">
						
	<thead>
		<tr><th colspan="3" style="text-align: center;font-weight: bold;border: 1px solid #000000;">GANHOS</th></tr>
		<tr>
			<th>Número</th>
			<th>Data</th>
			<th style="text-align: right;">Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data->job_profits as $item)
		<tr>
			<td>{{$item->number}}</td>
			<td>{{$item->date}}</td>
			<td style="text-align: right;">{{$item->total}} €</td>
		</tr>
		@endforeach
	</tbody>
</table>
<table>
	<tbody>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">TOTAL ORÇAMENTADO</th>
		<td class="right" style="text-align: right;" colspan="2">{{ $data->quote_value }} €</td>
	</tr>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">TOTAL GASTOS</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->totalExpenses(),2,',','.') }} €</td>
	</tr>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">TOTAL GANHOS</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->totalProfits(),2,',','.') }} €</td>
	</tr>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">LUCRO</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->profit(),2, ',','.') }} €</td>
	</tr>
	</tbody>
</table>

</html>