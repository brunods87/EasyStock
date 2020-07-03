@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="title">MATERIAIS</h1>
    <div class="toolbar text-right">
        <a href="{{ route('unities.index') }}"><i class="fas fa-list mr-3"></i>Unidades</a>
        <a href="{{ route('types.index') }}"><i class="fas fa-list mr-3"></i>Tipos</a>
        <a href="{{ route('categories.index') }}"><i class="fas fa-list mr-3"></i>Categorias</a>    
        <a href="{{ route('materials.create') }}"><i class="far fa-plus-square mr-3"></i>Adicionar</a>    
    </div>
    

    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>Nº</th>
                <th>Nome</th>
                <th>Referência</th>
                <th>Preço</th>
                <th>Unidade</th>
                <th>Fornecedor</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>Stock</th>
                <th>Obra</th>
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
        ajax: "{{ route('materials.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'reference', name: 'reference'},
            {data: 'price', name: 'price'},
            {data: 'unity_id', name: 'unity'},
            {data: 'supplier_id', name: 'supplier_id'},
            {data: 'category_id', name: 'category_id'},
            {data: 'type_id', name: 'type_id'},
            {data: 'stock', name: 'stock'},
            {data: 'job_id', name: 'job_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "order": [[ 1, "asc" ]]
    });
    
  });
</script>

@endpush