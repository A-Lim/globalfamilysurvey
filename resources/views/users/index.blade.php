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
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Church</th>
                            <th>Verified</th>
                            <th class="col-action">Actions</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->email }} </td>
                                <td> {{ $user->roles->first()['label'] }} </td>
                                <td> {{ $user->church->name ?? ''  }} </td>
                                <td>
                                    @can('update', $user)
                                        <a class="link-btn" href="/users/{{ $user->id }}/edit" title="Edit">
                                            <button type="button" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </button>
                                        </a>&nbsp;
                                    @endcan

                                    @can('delete', $user)
                                        <form action="/users/{{ $user->id }}" method="post" class="form-btn">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete user?')">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
                </table>
                {{-- <div class="pull-right">
                    {{ $users->links() }}
                </div> --}}
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
            {data: 'name'},
            {data: 'email'},
            {data: 'role'},
            {data: 'church'},
            {data: 'verified'},
            {data: 'action', sortable: false},
        ],
    });
    </script>
@endpush
