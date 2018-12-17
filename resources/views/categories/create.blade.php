@extends('layouts.admin')
@section('title', 'Create Category | GFS')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Category</h1>
        <ol class="breadcrumb">
            <li><a href="/categories"><i class="fa fa-tags"></i> Categories</a></li>
            <li><a class="active"></i> Add Category</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <form method="POST" action="/categories">
            @csrf
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('sequence') ? ' has-error' : '' }} col-md-6">
                            <label for="sequence">Sequence</label>
                            <input type="number" class="form-control" name="sequence" placeholder="Sequence" value="{{ old('sequence') }}">
                            <span class="text-danger">{{ $errors->first('sequence') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('questions') ? ' has-error' : '' }} col-md-6">
                            <label for="questions">Questions</label>
                            <select class="form-control select2" name="questions[]" multiple="multiple" data-placeholder="Select Questions" style="width: 100%;">
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id }}" {{ in_array($question->id, old('questions') ?? []) ? 'selected' : '' }}>{{ $question->title }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('questions') }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                </div>
                <!-- /.box-footer -->
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
