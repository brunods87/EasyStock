@extends('layouts.app')

@section('content')

<div class="container py-3">

    <h1 class="title">FOLHAS DE OBRA</h1>
    <div class="toolbar text-right">
        <a href="{{ route('jobs.create') }}"><i class="far fa-plus-square mr-3"></i>Adicionar</a>
    </div>
    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Nome</th>
                <th>Referência</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Despesas</th>
                <th width="100px">Action</th>

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
        ajax: "{{ route('jobs.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'reference', name: 'reference'},
            {data: 'client_id', name: 'client_id'},
            {data: 'date', name: 'date'},
            {data: 'materials', name: 'materials'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>

@endpush