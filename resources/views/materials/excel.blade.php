<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{ HTML::style('/css/excel.css') }}

<table>
	<thead>
		<tr><th colspan="5" style="text-align: center;">MATERIAIS</th></tr>
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
				<td class="right">{{ $item->price}} €</td>
				<td class="right">{{ $item->stock}} </td>
			</tr>
		@endforeach
	</tbody>
</table>

</html>