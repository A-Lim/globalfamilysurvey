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
                                <th>Role</th>
                                <th>Access</th>
                                <th class="col-action">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td> {{ $role->label }} </td>
                                    <td>
                                        @if ($role->name == 'super_admin')
                                            <span class="label label-success">full</span>
                                        @else
                                            @foreach ($role->permissions as $permission)
                                                <span class="label label-{{ tag_type_for_permisson($permission->name) }}">{{ $permission->label }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @can('update', App\Role::class)
                                            <a class="link-btn" href="/roles/{{ $role->id }}/edit" title="Edit">
                                                <button type="button" class="btn btn-primary">
                                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                                </button>
                                            </a>
                                        @endcan

                                        @can('delete', App\Role::class)
                                            <form action="/roles/{{ $role->id }}" method="post" class="form-btn">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this role?')">
                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab_2">
                    <table id="datatable" class="table table-bordered" cellspacing="0">
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
