@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ str_limit($survey->title, 50) }}</h1>
        <ol class="breadcrumb">
            <li><a href="/surveys"><i class="fa fa-list-ul"></i> Surveys</a></li>
            <li><a class="active"></i> {{ str_limit($survey->title, 50) }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="type">Title</label>
                        <input type="text" class="form-control" name="type" placeholder="Type" value="{{ $survey->title }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="question_count">No. of Questions</label>
                        <input type="number" class="form-control" name="question_count" placeholder="No. of Questions" value="{{ $survey->questions->count() }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="questions">Questions</label>
                        <table id="datatable" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="">Title</th>
                                    <th class="">Type</th>
                                    <th class="">Page</th>
                                    <th class="">Sequence</th>
                                    <th class="col-action">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                    <tr>
                                        <td> {{ str_limit($question->title, 50) }} </td>
                                        <td> {{ ucwords(str_replace('_', ' ', $question->type)) }} </td>
                                        <td> {{ $question->page }} </td>
                                        <td> {{ $question->sequence }} </td>
                                        <td>
                                            {!! view_button('questions', $question->id) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection
