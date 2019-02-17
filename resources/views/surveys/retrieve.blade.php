@extends('layouts.admin')
@section('title', 'Retrieve Survey | GFS')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Retrieve Survey</h1>
        <ol class="breadcrumb">
            <li><a href="/surveys"><i class="fa fa-tags"></i> Surveys</a></li>
            <li><a class="active"></i> Retrieve Survey</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="/surveys/retrieve">
                    @csrf
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Results</label>
                                    <textarea class="form-control" rows=20>{{ json_encode(Session::get('content'), JSON_PRETTY_PRINT) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">List</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form method="post" action="/surveys">
                    @csrf
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                                    <label for="name">Survey Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}"/>
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('survey_id') ? ' has-error' : '' }} col-md-12">
                                    <label for="survey_id">Survey ID</label>
                                    <input type="text" name="survey_id" class="form-control" placeholder="Survey ID" value="{{ old('survey_id') }}"/>
                                    <span class="text-danger">{{ $errors->first('survey_id') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('survey_id') ? ' has-error' : '' }} col-md-12">
                                    <label for="url">Survey Url</label>
                                    <input type="text" name="url" class="form-control" placeholder="Survey ID" value="{{ old('url') }}"/>
                                    <span class="text-danger">{{ $errors->first('url') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }} col-md-12">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type">
                                        <option value="">Select Type</option>
                                        @foreach (\App\Survey::TYPES as $type)
                                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucwords($type) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Retrieve</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
