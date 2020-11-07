<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
	@page{
		margin: 25px;
	}
.page-break {
    page-break-after: always;
}
table{
	border-collapse: collapse;
	margin: 0;
}
table th{
	border: 1px solid #000;
	background-color: #019FCE;
}
table td{
	padding: 5px;
}
.left{
	text-align: left;
}
.right{
	text-align: right;
}
.center{
	text-align: center;
}
</style>
<div class="center" style="margin-bottom: 15px;">MATERIAL</div>
<table style="width: 100%;">
	<thead>
		<tr>
			<th class="left">DESIGNAÇÃO</th>
			<th class="left">REFERÊNCIA</th>
			<th class="left">UNIDADE</th>
			<th class="right">PREÇO</th>
			<th class="right">STOCK</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="left">{{ $data->name }}</td>
			<td class="left">{{ $data->reference }}</td>
			<td class="left">{{ $data->unity ? $data->unity->name : '' }}</td>
			<td class="right">{{ $data->price }} €</td>
			<td class="right">{{ $data->stock}} </td>
		</tr>
	</tbody>
</table>
<div class="center" style="margin-bottom: 15px;margin-top: 30px;">OBRAS</div>
<table style="width: 100%;">
	<thead>
		<tr>
			<th class="left">NOME</th>
			<th class="left">REFERÊNCIA</th>
			<th class="left">QUANTIDADE</th>
		</tr>
	</thead>
	<tbody>
		@php $total = 0; @endphp
		@foreach ($data->info() as $info)
			<tr>
				<td class="left">{{ $info['name'] }}</td>
				<td class="left">{{ $info['reference'] }}</td>
				<td class="left">{{ $info['quantity'] }}</td>
			</tr>
			@php $total += $info['quantity']; @endphp
		@endforeach
		<tr>
			<td></td>
			<td style="text-align: right;background-color: #019FCE;border: 1px solid #000;">TOTAL</td>
			<td style="border: 1px solid #000;">{{$total}}</td>
		</tr>
	</tbody>
</table>