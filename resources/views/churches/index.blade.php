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
                            <th>Church Name</th>
                            <th>Denomination</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($churches as $church)
                            <tr>
                                <td> {{ $church->name }} </td>
                                <td> {{ $church->denomination }} </td>
                                <td> {{ $church->country }} </td>
                                <td>
                                    @can('update', App\Church::class)
                                        <a class="link-btn" href="/churches/{{ $church->id }}/edit" title="Edit">
                                            <button type="button" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </button>
                                        </a>&nbsp;
                                    @endcan
                                    @can('delete', App\Church::class)
                                        <form action="/churches/{{ $church->id }}" method="post" class="form-btn">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete church?')">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    {{ $churches->links() }}
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
