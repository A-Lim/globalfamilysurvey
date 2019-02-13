@extends('layouts.admin')
@section('title', 'Create Webhook | GFS')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Webhook</h1>
        <ol class="breadcrumb">
            <li><a href="/webhooks"><i class="fa fa-broadcast-tower"></i> Webhooks</a></li>
            <li><a class="active"></i> Edit Webhook</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Results</label>
                                <textarea class="form-control" rows=20>{{ json_encode(Session::get('result'), JSON_PRETTY_PRINT) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <form method="POST" action="/webhooks/{{ $webhook->id }}">
                        @csrf
                        @method('patch')
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name', $webhook->name) }}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('survey_id') ? ' has-error' : '' }} col-md-12">
                                    <label for="survey_id">Survey ID</label>
                                    <select name="survey_id" class="form-control">
                                        <option value="">Select Survey</option>
                                        @foreach ($surveys as $survey)
                                            <option value="{{ $survey->id }}" {{ old('survey_id', $webhook->survey_id) == $survey->id ? 'selected' : '' }}>{{ $survey->title }} [{{ ucwords($survey->type) }}]</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('survey_id') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('event_type') ? ' has-error' : '' }} col-md-12">
                                    <label for="event_type">Event Type</label>
                                    <select class="form-control select2" name="event_type">
                                        @foreach (\App\Webhook::EVENTS as $event)
                                            <option value="{{ $event }}" {{ old('event', $webhook->event_type) == $event ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $event)) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('event_type') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('object_type') ? ' has-error' : '' }} col-md-12">
                                    <label for="object_type">Object Type</label>
                                    <select name="object_type" class="form-control">
                                        <option value="">Select Object Type</option>
                                        <option value="survey" {{ old('object_type', $webhook->object_type) ? 'selected' : '' }}>Survey</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('object_type') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Edit</button>
                        </div>
                    <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </section>
<!-- /.content -->
@endsection
