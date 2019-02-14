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
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name', $church->name) }}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('denomination') ? ' has-error' : '' }} col-md-12">
                                    <label for="denomination">Denomination</label>
                                    <input type="text" class="form-control" name="denomination" placeholder="Denomination" value="{{ old('denomination', $church->denomination) }}">
                                    <span class="text-danger">{{ $errors->first('denomination') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }} col-md-12">
                                    <label for="country">Country</label>
                                    <select class="form-control select2" name="country">
                                        @include('components.options.countries')
                                    </select>
                                    <span class="text-danger">{{ $errors->first('country') }}</span>
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
                        @foreach ($surveys as $survey)
                        <div class="row">
                            <div class="form-group col-md-12">
                                @php
                                    $url = $survey->url.'?church='.$church->uuid;
                                @endphp
                                <div><i class="fa fa-link"></i> <a target="_blank" href="{{ $url }}">{{ $survey->title }}</a></div>
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
