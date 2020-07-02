@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="title">CATEGORIAS</h1>
    <div class="toolbar text-right">
        <a href="{{ route('materials.index') }}">Voltar</a>
        <a href="{{ route('categories.create') }}"><i class="far fa-plus-square mr-3"></i>Adicionar</a>    
    </div>
    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Nome</th>
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
        ajax: "{{ route('categories.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>

@endpush