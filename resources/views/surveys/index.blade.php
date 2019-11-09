@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Surveys</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-list-ul"></i> Surveys</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <div class="box-body">
                @can('retrieve', App\Survey::class)
                    <div class="box-header with-border">
                        <a href="/surveys/create" class="btn btn-primary pull-right">Retrieve Survey</a>
                    </div>
                @endcan
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>No. of Questions</th>
                            <th class="col-action">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surveys as $survey)
                            <tr>
                                <td> <strong>[{{ ucwords($survey->type) }}]</strong> {{ $survey->title }}</td>
                                <td> {{ $survey->questions_count }} </td>
                                <td>
                                    @can('view', App\Survey::class)
                                        <a class="link-btn" href="/surveys/{{ $survey->id }}" title="View">
                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" title="View">
                                                <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                    @endcan

                                    @can('retrieve', App\Survey::class)
                                        <form action="/surveys/{{ $survey->id }}/refresh" method="post" class="form-btn">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="Update survey" onclick="return confirm('Are you sure you want to update this survey?')">
                                                <span class="fa fa-sync" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    @endcan

                                    @can('delete', App\Role::class)
                                        <form action="/surveys/{{ $survey->id }}" method="post" class="form-btn">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete survey? This will delete all questions and results linked to this survey.')">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
