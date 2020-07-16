@extends('layouts.app')

@section('content')

<div class="container py-3">

    <h1 class="title">FUNCIONÁRIOS</h1>
    <div class="toolbar text-right">
        <a href="{{ route('employees.create') }}"><i class="far fa-plus-square mr-3"></i>Adicionar</a>    
    </div>
    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Número</th>
                <th>Nome</th>
                <th>Data de admissão</th>
                <th>Salário</th>
                <th>Valor Hora</th>
                <th>Observações</th>
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
        ajax: "{{ route('employees.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'number', name: 'number'},
            {data: 'name', name: 'name'},
            {data: 'admission_date', name: 'admission_date'},
            {data: 'salary', name: 'salary'},
            {data: 'value_hour', name: 'value_hour'},
            {data: 'observations', name: 'observations'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>

@endpush