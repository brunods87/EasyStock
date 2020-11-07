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
<div class="center" style="margin-bottom: 30px;">MATERIAIS</div>
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
		@foreach ($data as $item)
			<tr>
				<td class="left">{{ $item->name }}</td>
				<td class="left">{{ $item->reference }}</td>
				<td class="left">{{ $item->unity ? $item->unity->name : '' }}</td>
				<td class="right">{{ $item->price }} €</td>
				<td class="right">{{ $item->stock}} </td>
			</tr>
		@endforeach
	</tbody>
</table>