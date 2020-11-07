@extends('layouts.app')

@section('content')

<div class="container py-3">

    <h1 class="title">MATERIAIS</h1>
    <div class="toolbar text-right">
        <a href="{{ route('unities.index') }}"><i class="fas fa-list mr-3"></i>Unidades</a>
        <a href="{{ route('types.index') }}"><i class="fas fa-list mr-3"></i>Tipos</a>
        <a href="{{ route('categories.index') }}"><i class="fas fa-list mr-3"></i>Categorias</a>    
        <a href="{{ route('materials.create') }}"><i class="far fa-plus-square mr-3"></i>Adicionar</a>    
    </div>
    <div class="extra-bar text-right mb-4">
        
        <a href="{{ route('materials.exportPdf') }}" class="mx-3"><i class="fas fa-download mr-2"></i> Exportar Materiais PDF</a>
        <a href="{{ route('materials.exportExcel') }}" class="mx-3"><i class="fas fa-download mr-2"></i> Exportar Materiais EXCEL</a>

    </div>

    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>Nº</th>
                <th>Referência</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Unidade</th>
                <th>Fornecedor</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>Stock</th>
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
            {data: 'reference', name: 'reference'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'unity_id', name: 'unity'},
            {data: 'supplier_id', name: 'supplier_id'},
            {data: 'category_id', name: 'category_id'},
            {data: 'type_id', name: 'type_id'},
            {data: 'stock', name: 'stock'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "order": [[ 1, "asc" ]]
    });
    
  });
</script>

@endpush