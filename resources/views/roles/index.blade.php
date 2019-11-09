@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Settings</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-user-astronaut"></i> Roles And Permissions</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Roles</a></li>
                <li><a href="#tab_2" data-toggle="tab" aria-expanded="true">Permissions</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    @can('create', App\Role::class)
                        <div class="box-header">
                            <a href="/roles/create" class="btn btn-primary pull-right">Add Role</a>
                        </div>
                    @endcan

                    <table id="datatable" class="table table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Access</th>
                                <th class="col-action">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane" id="tab_2">
                    <table id="permission-datatable" class="table table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                <th>Tag</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td> {{ $permission->label }}</td>
                                    <td>
                                        <span class="label label-{{ tag_type_for_permisson($permission->name) }}">{{ $permission->label }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.tab-content -->
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
        ajax: '/roles/datatable',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            {data: 'label'},
            {data: 'access', sortable: false},
            {data: 'action', sortable: false},
        ],
        initComplete: function(settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    </script>
@endpush
