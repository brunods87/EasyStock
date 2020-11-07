<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{ HTML::style('/css/excel.css') }}
<table>
	<tbody>
	<tr>
		<th>Fatura Nº</th>
		<td>{{$data->number}}</td>
	</tr>
	<tr>
		<th>Data do Documento:</th>
		<td>{{$data->date}}</td>
	</tr>
	</tbody>
</table>

<table>

	<thead>
		<tr>
			<th>REFERÊNCIA</th>
			<th>DESCRIÇÃO</th>
			<th>UNIDADE</th>
			<th>QUANTIDADE</th>
			<th>PREÇO UNITÁRIO</th>
			<th>DESCONTO</th>
			<th>IVA</th>
			<th>TOTAL</th>
		</tr>
	</thead>

	<tbody>
		@foreach($data->invoice_items as $item)
			<tr>
				<td>{{$item->material->reference}}</td>
				<td>{{$item->description}}</td>
				<td>{{$item->material->unity->name}}</td>
				<td>{{$item->quantity}}</td>
				<td>{{$item->material->price}}</td>
				<td>{{number_format($item->discount_1,0)}} + {{number_format($item->discount_2,0)}}</td>
				<td>{{$item->material->tax}}</td>
				<td style="text-align: right;">{{number_format($item->total(),2,',','.')}} €</td>
			</tr>
		@endforeach
	</tbody>

</table>

<table>
	<tbody>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">TOTAL ILÍQUIDO</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->subtotal(),2,',','.') }} €</td>
	</tr>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">DESCONTOS</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->totalDiscount(),2,',','.') }} €</td>
	</tr>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">TOTAL LÍQUIDO</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->subtotal(true),2,',','.') }} €</td>
	</tr>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">TOTAL IVA</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->totalTax(),2,',','.') }} €</td>
	</tr>
	<tr>
		<th class="center" style="text-align: center;" colspan="6">TOTAL A PAGAR</th>
		<td class="right" style="text-align: right;" colspan="2">{{ number_format($data->getTotal(),2,',','.') }} €</td>
	</tr>
	</tbody>
</table>

</html>