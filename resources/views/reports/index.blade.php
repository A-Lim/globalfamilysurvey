@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Reports <small>Leadership Report</small></h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-chart-pie"></i> Reports</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            @can('create', App\Report::class)
                <div class="box-header with-border">
                    <a href="/reports/create" class="btn btn-primary pull-right">Add Report</a>
                </div>
            @endcan

            <div class="box-body">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="col-action">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report->name }}</td>
                                <td>
                                    @can('update', App\Report::class)
                                        {!! edit_button('reports', $report->id) !!}
                                    @endcan
                                    @can('delete', App\Report::class)
                                        {!! delete_button('reports', $report->id) !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="pull-right">
                    {{ $reports->links() }}
                </div> --}}
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
