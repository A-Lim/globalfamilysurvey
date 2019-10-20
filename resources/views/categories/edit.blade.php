@extends('layouts.admin')
@section('title', ' Edit Category | GFS')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Category</h1>
        <ol class="breadcrumb">
            <li><a href="/categories"><i class="fas fa-tags"></i> Categories</a></li>
            <li><a class="active"></i> Edit Categories</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <form method="post" action="/categories/{{ $category->id }}">
            @method('patch')
            @csrf
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name', $category->name ) }}">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('sequence') ? ' has-error' : '' }} col-md-6">
                            <label for="sequence">Sequence</label>
                            <input type="text" class="form-control" name="sequence" placeholder="Sequence" value="{{ old('sequence', $category->sequence ) }}">
                            <span class="text-danger">{{ $errors->first('sequence') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('question_ids') ? ' has-error' : '' }} col-md-6">
                            <label for="question_ids">Questions</label>
                            <select class="form-control select2" name="question_ids[]" multiple="multiple" data-placeholder="Select Questions" style="width: 100%;">
                                @php
                                    $i = 0;
                                    $selected_questions = $category->questions->pluck('id')->toArray();
                                @endphp
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id }}" {{ in_array($question->id, old('question_ids'.$i, $selected_questions)) ? 'selected' : '' }}>{{ $question->title }}</option>
                                    @php $i++; @endphp
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('question_ids') }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
                <!-- /.box-footer -->
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
