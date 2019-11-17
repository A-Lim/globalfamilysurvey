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
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

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
        order: [[ 2, "desc" ]],
        initComplete: function(settings, json) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    </script>
@endpush
