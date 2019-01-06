@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Questions</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-question"></i> Questions</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <div class="box-body">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Survey Type</th>
                            <th>No. of Answers</th>
                            <th class="col-action">Actions</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td> {{ str_limit(strip_tags($question->title), 40) }} </td>
                                <td> {{ ucwords($question->survey->type) }}</td>
                                <td> {{ $question->answers_count }} </td>
                                <td>
                                    @can('view', App\Question::class)
                                        <a class="link-btn" href="/questions/{{ $question->id }}" title="View">
                                            <button type="button" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('delete', App\Question::class)
                                        <form action="/questions/{{ $question->id }}" method="post" class="form-btn">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete question? This will delete all results linked to this question.')">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
                </table>
                {{-- <div class="pull-right">
                    {{ $questions->links() }}
                </div> --}}
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

{{-- @prepend('scripts')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
@endprepend --}}
@push('scripts')
    <script>
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        bLengthChange: false,
        ajax: '/questions/datatable',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            {data: 'title'},
            {data: 'survey_type', name: 'surveys.type'},
            {data: 'answers_count', searchable: false, sortable: false },
            {data: 'action', sortable: false},
        ],
    });
    </script>
@endpush
