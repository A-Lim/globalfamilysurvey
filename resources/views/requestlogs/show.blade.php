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
                <div class="row">
                    <div class="col-md-12">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Info</h3>
                            </div>
                            <div id="requestlog-box-profile" class="box-body box-profile">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        ID <span class="pull-right">{{ $requestLog->id }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Status
                                        @if ($requestLog->status == \App\RequestLog::STATUS_SUCCESS)
                                            <span class="pull-right label label-success">{{ $requestLog->status }}</span>
                                        @endif

                                        @if ($requestLog->status == \App\RequestLog::STATUS_ERROR)
                                            <span class="pull-right label label-danger">{{ $requestLog->status }}</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item">
                                        Created At <span class="pull-right label label-info">{{ $requestLog->created_at->format('y-m-d h:i:s') }}</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    @if ($requestLog->params != null)
                        <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                              <h4 class="box-title">Query Params</h4>
                            </div>
                            <div id="requestlog-query-box" class="box-body box-profile">
                                <ul class="list-group list-group-unbordered">
                                    @foreach (json_decode($requestLog->params) as $key => $value)
                                        <li class="list-group-item">
                                            {{ $key }} 
                                            @if (is_object($value))
                                                <pre>{{ json_encode($value) }}</pre>
                                            @else 
                                                <span class="pull-right">{{ $value }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Content</label>
                                <textarea id="requestlog-content" class="form-control" rows="20" disabled>{{ $requestLog->content }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
        var ugly = $('#requestlog-content').val()
        var obj = JSON.parse(ugly);
        var pretty = JSON.stringify(obj, undefined, 2);

        $('#requestlog-content').val(pretty);
    });
    </script>
@endpush
