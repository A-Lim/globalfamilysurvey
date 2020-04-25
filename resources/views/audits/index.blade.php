@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Audits</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-history"></i> Audits</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <div class="box-body">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Module</th>
                            <th>Action</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Audit Date</th>
                            <th class="col-action">Actions</th>
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
        ajax: '/audits/datatable',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            {data: 'module', name: 'audits.module'},
            {data: 'action', name: 'audits.action'},
            {data: 'email', name: 'users.email'},
            {data: 'request_ip', name: 'audits.request_ip'},
            {data: 'created_at', name: 'audits.created_at' },
            {data: 'actions', sortable: false},
        ],
        initComplete: function(settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    </script>
@endpush
