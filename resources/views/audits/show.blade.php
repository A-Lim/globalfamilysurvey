@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Audit</h1>
        <ol class="breadcrumb">
            <li><a href="/audits"><i class="fa fa-history"></i> Audits</a></li>
            <li><a class="active"></i> Audit - {{ $audit->id }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <span class="pull-right"><b>Date:</b> {{ $audit->created_at }}</span>
                        <b>Audit ID:</b> {{ $audit->id }} <br>
                        <b>Module:</b> {{ $audit->module }} <br>
                        <b>Action:</b> {{ $audit->action }} <br>
                        <b>IP:</b> {{ $audit->request_ip }} <br>
                        <b>Action By:</b> {{ $audit->user->email }} <br>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Request Header</label>
                        <textarea class="form-control" disabled rows="5">{{ $audit->request_header }} </textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Input</label>
                        <textarea class="form-control" disabled rows="5">{{ $audit->input }} </textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Old Data</label>
                        <textarea class="form-control" disabled rows="5">{{ $audit->old }} </textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label>New Data</label>
                        <textarea class="form-control" disabled rows="5">{{ $audit->new }} </textarea>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection