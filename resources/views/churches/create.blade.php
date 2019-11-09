@extends('layouts.admin')
@section('title', 'Create Church | GFS')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Church</h1>
        <ol class="breadcrumb">
            <li><a href="/churches"><i class="fa fa-church"></i> Churches</a></li>
            <li><a class="active"></i> Add Church</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <form method="POST" action="/churches">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }} col-md-12">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" placeholder="City" value="{{ old('city') }}">
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('district') ? ' has-error' : '' }} col-md-12">
                                    <label for="district">District</label>
                                    <input type="text" class="form-control" name="district" placeholder="District" value="{{ old('district') }}">
                                    <span class="text-danger">{{ $errors->first('district') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }} col-md-12">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" name="state" placeholder="State" value="{{ old('state') }}">
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }} col-md-12">
                                    <label for="country_id">Country</label>
                                    <select name="country_id" class="select2 form-control">
                                        <option>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Add</button>
                        </div>
                    <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </section>
<!-- /.content -->
@endsection
