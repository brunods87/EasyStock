<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
	@page{
		margin: 25px;
	}
.page-break {
    page-break-after: always;
}
.body table{
	border-collapse: collapse;
	margin: 0;
}
.body table th{
	border: 1px solid #000;
	background-color: #019FCE;
}
.body table td{
	padding: 5px;
}
.left{
	text-align: left;
}
.right{
	text-align: right;
}
.footer table th{
	border-right: 1px solid #000;
	background-color: #019FCE;
	padding-left: 10px;
}
.header, .body, .footer{
	width: 100%;
}
.my-bak{
	background-color: #eaeaec;
}
.vf-data p{
	margin-bottom: 3px;
}
.mt-0{
	margin-top: 0;
}
.materials, .employees, .profits{
	margin-top: 30px;
}
.profits table td{
	text-align: center;
}
h2{
	margin-bottom: 5px;
}
</style>


<div class="header">
	<h1 class="mt-0">{{$data->client->name}}</h1>	
	<h4>NIF: {{$data->client->nif}}</h4>
	
	<table style="margin-left: auto;margin-right: -5px;width: 50%;">
		<tbody style="border: 1px solid #000;">
		<tr>
			<th style="text-align: left;padding: 5px;">Nome da Folha de Obra</th>
			<td style="text-align: right;padding-left: 15px;">{{$data->name}}</td>
		</tr>
		<tr>
			<th style="text-align: left;padding: 5px;">Referência da Folha de Obra</th>
			<td style="text-align: right;padding-left: 15px;">{{$data->reference}}</td>
		</tr>
		<tr>
			<th style="text-align: left;padding: 5px;">Data do Documento:</th>
			<td style="text-align: right;padding-left: 15px;">{{$data->date}}</td>
		</tr>
		</tbody>
	</table>
	
	<div class="my-bak vf-data" style="text-align: left;width: 35%;margin-top: 30px;border: 1px solid #000;padding: 10px;">
		<p style="margin: 0;">Exmo.(S) Sr.(S)</p>
		<p>VF Alumínios, Lda</p>
		<p>Rua São Mateus - Trabulheira</p>
		<p>Stª Eufémia</p>
		<p>2420-369 LEIRIA</p>
	</div>

</div>

<div class="body" style="margin-top: 20px;">
	<div class="materials">
		<h2 style="text-align: center;">MATERIAIS</h2>
		<table style="width: 100%;border: 1px solid #000;">
			<thead>
				<tr>
					<th>REFERÊNCIA</th>
					<th>DESCRIÇÃO</th>
					<th>UNID</th>
					<th>QTD</th>
					<th>P. UNITÁRIO</th>
					<th>DESCONTO</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				@foreach($data->materials() as $item)
				@if(is_null($item->expense_jobable)) @continue @endif
					<tr>
						<td class="left">{{$item->expense_jobable->material->reference}}</td>
						<td class="left">{{$item->expense_jobable->description}}</td>
						<td class="right">{{$item->expense_jobable->material->unity->name}}</td>
						<td class="right">{{$item->quantity}}</td>
						<td class="right">{{$item->expense_jobable->material->price}}</td>
						<td class="right">{{number_format($item->expense_jobable->discountInvoiceJob(),0)}}</td>
						<td class="right">{{number_format($item->expense_jobable->total(),2,',','.')}} €</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="employees">
		<h2 style="text-align: center;">MÃO DE OBRA</h2>
		<table style="width: 100%;border: 1px solid #000;">
			<thead>
				<tr>
					<th>Nº</th>
					<th>NOME</th>
					<th>SALÁRIO</th>
					<th>V. HORA</th>
					<th>QTD</th>
					<th>V. HORA EXT.</th>
					<th>QTD EXT.</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				@foreach($data->employees() as $item)
				@if(is_null($item->expense_jobable)) @continue @endif
					<tr>
						<td class="left">{{$item->expense_jobable->number}}</td>
						<td class="left">{{$item->expense_jobable->name}}</td>
						<td class="right">{{$item->expense_jobable->salary}}</td>
						<td class="right">{{$item->expense_jobable->value_hour}}</td>
						<td class="right">{{$item->quantity}}</td>
						<td class="right">{{$item->expense_jobable->value_extra_hour}}</td>
						<td class="right">{{floatval($item->quantity_extra)}}</td>
						<td class="right">{{$item->total}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="profits">
		<h2 style="text-align: center;">GANHOS</h2>
		<table style="width: 100%;border: 1px solid #000;">
			<thead>
				<tr>
					<th>NÚMERO</th>
					<th>DATA</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				@foreach($data->job_profits as $item)
					<tr>
						<td class="left">{{$item->number}}</td>
						<td class="left">{{$item->date}}</td>
						<td class="right">{{$item->total}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="footer" style="margin-top: 30px;text-align: right;">
	
	<table style="margin-left: auto;margin-right: -5px;width: 60%;">
		<tbody style="border: 1px solid #000;">
		<tr>
			<th class="left" style="text-align: left;">TOTAL ORÇAMENTADO</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->quote_value,2,',','.') }} €</td>
		</tr>
		<tr>
			<th class="left" style="text-align: left;">TOTAL GASTOS</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->totalExpenses(),2,',','.') }} €</td>
		</tr>
		<tr>
			<th class="left" style="text-align: left;">TOTAL GANHOS</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->totalProfits(),2,',','.') }} €</td>
		</tr>
		<tr>
			<th class="left" style="text-align: left;">LUCRO</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->profit(),2,',','.') }} €</td>
		</tr>
		</tbody>
	</table>

</div>

