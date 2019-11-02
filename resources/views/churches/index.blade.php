@extends('layouts.admin')
@section('title', 'Churches | GFS')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Churches</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-church"></i> Churches</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            @can('create', App\Church::class)
                <div class="box-header with-border">
                    <a href="/churches/create" class="btn btn-primary pull-right">Add Church</a>
                </div>
            @endcan

            <div class="box-body">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Church Uuid</th>
                            <th>Network Uuid</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        bLengthChange: false,
        ajax: '/churches/datatable',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            {data: 'uuid'},
            {data: 'network_uuid'},
            {data: 'country_name', name: 'countries.name'},
            {data: 'action', sortable: false},
        ],
        initComplete: function(settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    </script>
@endpush
