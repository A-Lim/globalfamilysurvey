@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-user"></i> Users</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            @can('create', App\User::class)
                <div class="box-header with-border">
                    <a href="/users/create" class="btn btn-primary pull-right">Register User</a>
                </div>
            @endcan

            <div class="box-body">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Network UUID</th>
                            <th>Church UUID</th>
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
        ajax: '/users/datatable',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            {data: 'email', name: 'users.email'},
            {data: 'role', name: 'roles.label'},
            {data: 'network_uuid', name: 'churches.network_uuid'},
            {data: 'church_uuid', name: 'churches.uuid' },
            {data: 'action', sortable: false},
        ],
    });
    </script>
@endpush
