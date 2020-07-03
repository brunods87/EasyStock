@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="title">FATURAS</h1>
    <div class="toolbar text-right">
        <button type="button" class="" data-toggle="modal" data-target="#createInvoiceModal"><i class="far fa-plus-square mr-3"></i>Adicionar</button> 
    </div>
    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>

                <th>Nome</th>

                <th>Email</th>

                <th width="100px">Ações</th>

            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>

</div>




@endsection

@section('modals')

    @include('modals.createInvoiceModal')

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
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>

@endpush