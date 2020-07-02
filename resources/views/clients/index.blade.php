@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="title">CLIENTES</h1>
    <div class="toolbar text-right">
        <a href="{{ route('clients.create') }}"><i class="far fa-plus-square mr-3"></i>Adicionar</a>    
    </div>
    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Nome</th>
                <th>NIF</th>
                <th>Morada</th>
                <th width="100px">Ações</th>

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
        ajax: "{{ route('clients.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'nif', name: 'nif'},
            {data: 'address', name: 'address'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>

@endpush