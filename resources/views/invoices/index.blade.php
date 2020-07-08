@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="title">FATURAS</h1>
    <div class="toolbar text-right">
        <a href="{{ route('invoices.create') }}"><i class="far fa-plus-square mr-3"></i>Adicionar</a>
    </div>
    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Número</th>
                <th>Fornecedor</th>
                <th>Data</th>
                <th>Materiais</th>
                <th>Total</th>
                <th width="150px">Ações</th>

            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>

</div>




@endsection

@push('scripts')

<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('invoices.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'number', name: 'number'},
            {data: 'supplier_id', name: 'supplier_id'},
            {data: 'date', name: 'date'},
            {data: 'materials', name: 'materials'},
            {data: 'total', name: 'total'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>

@endpush