@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Report</h1>
        <ol class="breadcrumb">
            <li><a href="/reports"><i class="fa fa-chart-pie"></i> Reports</a></li>
            <li><a class="active"></i> Add Report</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <form method="POST" action="/reports">
            @csrf
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                            <label for="name">Report Name</label>
                            <input id="name" type="text" class="form-control" name="name" placeholder="Report Name" value="{{ old('name') }}">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <!-- leader -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group {{ $errors->has('leader_question_id') ? ' has-error' : '' }}">
                                        <label for="leader_question_id">Leader's Question</label>
                                        <select class="form-control select2" name="leader_question_id">
                                            <option value="">Select Question</option>
                                            @foreach ($questions as $question)
                                                @if ($question->survey->type == 'leader')
                                                    <option value="{{ $question->id }}" {{ $question->id == old('leader_question_id') ? 'selected' : '' }}>{{ $question->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('leader_question_id') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- member -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group {{ $errors->has('member_question_id') ? ' has-error' : '' }} col-md-12">
                                    <label for="member_question_id">Member's Question</label>
                                    <select class="form-control select2" name="member_question_id">
                                        <option value="">Select Question</option>
                                        @foreach ($questions as $question)
                                            @if ($question->survey->type == 'member')
                                                <option value="{{ $question->id }}" {{ $question->id == old('member_question_id') ? 'selected' : '' }}>{{ $question->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('member_question_id') }}</span>
                                </div>
                            </div>
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
