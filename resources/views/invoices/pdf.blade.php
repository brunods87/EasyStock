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
</style>


<div class="header">
	<h1 class="mt-0">{{$data->supplier->name}}</h1>	
	<h4>NIF: {{$data->supplier->nif}}</h4>
	
	<table style="margin-left: auto;margin-right: -5px;width: 40%;">
		<tbody style="border: 1px solid #000;">
		<tr>
			<th style="text-align: left;padding: 5px;">Fatura Nº</th>
			<td style="text-align: right;padding-left: 15px;">{{$data->number}}</td>
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
	<table style="width: 100%;border: 1px solid #000;">
		<thead>
			<tr>
				<th>REFERÊNCIA</th>
				<th>DESCRIÇÃO</th>
				<th>UNID</th>
				<th>QTD</th>
				<th>P. UNITÁRIO</th>
				<th>DESCONTO</th>
				<th>IVA</th>
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
			@foreach($data->invoice_items as $item)
				<tr>
					<td class="left">{{$item->material->reference}}</td>
					<td class="left">{{$item->description}}</td>
					<td class="right">{{$item->material->unity->name}}</td>
					<td class="right">{{$item->quantity}}</td>
					<td class="right">{{$item->material->price}}</td>
					<td class="right">{{number_format($item->discount_1,0)}} + {{number_format($item->discount_2,0)}}</td>
					<td class="right">{{$item->material->tax}}</td>
					<td class="right">{{number_format($item->total(),2,',','.')}} €</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="footer" style="margin-top: 30px;text-align: right;">
	
	<table style="margin-left: auto;margin-right: -5px;width: 40%;">
		<tbody style="border: 1px solid #000;">
		<tr>
			<th class="left" style="text-align: left;">TOTAL ILÍQUIDO</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->subtotal(),2,',','.') }} €</td>
		</tr>
		<tr>
			<th class="left" style="text-align: left;">DESCONTOS</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->totalDiscount(),2,',','.') }} €</td>
		</tr>
		<tr>
			<th class="left" style="text-align: left;">TOTAL LÍQUIDO</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->subtotal(true),2,',','.') }} €</td>
		</tr>
		<tr>
			<th class="left" style="text-align: left;">TOTAL IVA</th>
			<td class="right" style="text-align: right;padding-left: 15px;">{{ number_format($data->totalTax(),2,',','.') }} €</td>
		</tr>
		<tr>
			<th class="left" style="border: 1px solid #000;">TOTAL A PAGAR</th>
			<td class="right" style="border: 1px solid #000;">{{ number_format($data->getTotal(),2,',','.') }} €</td>
		</tr>
		</tbody>
	</table>

</div>

