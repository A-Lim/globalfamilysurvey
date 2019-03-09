@extends('layouts.admin')
@section('title', 'Edit Church | GFS')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Church</h1>
        <ol class="breadcrumb">
            <li><a href="/churches"><i class="fa fa-church"></i> Churches</a></li>
            <li><a class="active"></i> Edit Church</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <form method="POST" action="/churches/{{ $church->id }}">
                        @csrf
                        @method('patch')
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }} col-md-12">
                                    <label for="country_id">Country</label>
                                    <select name="country_id" class="select2 form-control">
                                        <option>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', $church->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
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
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-body">
                        <label>Survey Links</label>
                        {{-- @foreach ($surveys as $survey)
                        <div class="row">
                            <div class="form-group col-md-12">
                                @php
                                    $url = $survey->url.'?ch='.$church->uuid;
                                @endphp
                                <div><i class="fa fa-link"></i> <a target="_blank" href="{{ $url }}">{{ $survey->title }} [{{ ucwords($survey->type) }}]</a></div>
                            </div>
                        </div>
                        @endforeach --}}
                        @foreach ($surveys as $survey)
                            @php
                                $url = $survey->url.'?ch='.$church->uuid;
                            @endphp
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div><i class="fa fa-link"></i>  <a target="_blank" href="{{ $url }}">{{ $survey->title }}</a></div>
                                    <div class="input-group">
                                        <input id="link-{{ $survey->id }}" type="text" class="form-control" value="{{ $url }}" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="copy-btn btn btn-primary" data-clipboard-target="#link-{{ $survey->id }}"><i class="fa fa-copy"></i>&nbsp;</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
