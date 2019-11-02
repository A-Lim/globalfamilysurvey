@extends('layouts.admin')
@section('title', 'Categories | GFS')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Categories <small>Congregational Report</small></h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-tags"></i> Category</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            @can('create', App\Category::class)
                <div class="box-header with-border">
                    <a href="/categories/create" class="btn btn-primary pull-right">Add Category</a>
                </div>
            @endcan

            <div class="box-body">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="col-sequence">Sequence</th>
                            <th class="col-action">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->sequence }}</td>
                                <td>
                                    @can('update', App\Category::class)
                                        {!! edit_button('categories', $category->id) !!}
                                    @endcan
                                    @can('delete', App\Category::class)
                                        {!! delete_button('categories', $category->id) !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    {{-- {{ $users->links() }} --}}
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
