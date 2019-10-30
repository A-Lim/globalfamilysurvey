@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Request Log - {{ $requestLog->id }}</h1>
        <ol class="breadcrumb">
            <li><a href="/settings/dashboard"><i class="fa fa-cogs"></i> Settings Dashboard</a></li>
            <li><a class="active"></i> Request Log - {{ $requestLog->id }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div id="requestlog-box-profile" class="box-body box-profile">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>ID</b> <span class="pull-right">{{ $requestLog->id }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Status</b>
                                @if ($requestLog->status == \App\RequestLog::STATUS_SUCCESS)
                                    <span class="pull-right label label-success">{{ $requestLog->status }}</span>
                                @endif

                                @if ($requestLog->status == \App\RequestLog::STATUS_ERROR)
                                    <span class="pull-right label label-danger">{{ $requestLog->status }}</span>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <b>Created At</b> <span class="pull-right label label-info">{{ $requestLog->created_at->format('y-m-d h:i:s') }}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Content</label>
                                <textarea class="form-control" rows="20" disabled>{{ json_encode(json_decode($requestLog->content), JSON_PRETTY_PRINT) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
