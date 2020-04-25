@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Settings Dashboard</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-wrench"></i> Settings</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @if ($survey_count == 0)
            <div class="callout callout-warning">
                <h4>Retrieve Surveys</h4>
                <p>There are no surveys yet. Click <a href="/surveys/create">here</a> to retrieve and add surveys.</p>
            </div>
        @endif

        @include('components.status')
        <div class="row">
            <div class="col-md-4">
                <div id="box-total-count" class="info-box bg-red">
                    <span class="info-box-icon"><i class="ion ion-android-globe"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total API Calls </span>
                        <span class="info-box-number"></span>
                    </div>
                    <div class="stats-is-loading overlay">
                        <i class="fa fa-sync fa-spin"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="box-today-count" class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">API Calls Today</span>
                        <span class="info-box-number"></span>
                        {{-- added here so that can retrieved in javascript --}}
                        <input id="daily-limit" type="hidden" value="{{ \App\RequestLog::DAILY_LIMIT }}" />
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <span class="progress-description">
                            <span id="percentage-today">0%</span> of today's limit
                        </span>
                    </div>
                    <div class="stats-is-loading overlay">
                        <i class="fa fa-sync fa-spin"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form method="POST" action="/submissions/pull">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group {{ $errors->has('type') ? ' has-error' : '' }} ">
                            <select class="form-control" name="type" {{ $survey_count == 0 ? 'disabled' : '' }}>
                                <option>-- Select Request Type --</option>
                                @foreach(\App\Submission::REQ_TYPES as $request_type)
                                    <option value="{{ $request_type }}" {{ old('type') == $request_type ? 'selected' : '' }}>{{ ucfirst($request_type) }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('type') }}</span>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-block btn-warning" onclick="return confirm('Are you sure you want to perform this action?')"
                                {{ $survey_count == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-download"></i> Update Immediately
                            </button>
                        </div>
                    </div>
                    @if ($survey_count == 0)
                        <span class="help-block"><small>Function disabled because there is currently no surveys.</small></span>
                    @endif
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="font-weight: normal">Request Logs</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table no-margin" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th style="max-width: 40px">Status</th>
                                        <th class="col-action">Created At</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="box-queue" class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="font-weight: normal">Queues</h3>

                        <div class="box-tools pull-right">
                            <span id="queue-count" class="badge bg-red">0</span>
                            <a href="#" id="btn-refresh-queue" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh">
                                <i class="fa fa-sync"></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <li class="item item-empty">
                                <span class="text-center help-block">Currently nothing in queue</span>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <span class="uppercase">... <span id="queue-more-count"></span> more </a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/settings-dashboard.js') }}"></script>
@endpush
