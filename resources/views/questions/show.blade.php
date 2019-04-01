@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ str_limit(strip_tags($question->title), 50) }}</h1>
        <ol class="breadcrumb">
            <li><a href="/questions"><i class="fa fa-question"></i> Question</a></li>
            <li><a class="active"></i> {{ str_limit(strip_tags($question->title), 20) }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="type">Question Type</label>
                        <input type="text" class="form-control" name="type" placeholder="Type" value="{{ ucfirst(str_replace("_", " ", $question->type)) }}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="sequence">Sequence</label>
                        <input type="number" class="form-control" name="sequence" placeholder="Order" value="{{ $question->sequence }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-7">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" name="id" placeholder="ID" value="{{ $question->id }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-7">
                        <label for="title">Title</label>
                        <textarea class="form-control" name="title" placeholder="Title" rows="5" disabled>{{ strip_tags($question->title) }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-container">
                            <canvas id="bar-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection

@prepend('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.6.0/dist/chartjs-plugin-datalabels.min.js"></script>
@endprepend
{{-- {{ dd($grouped_answers) }} --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            retrieve_data();
        });

        function retrieve_data() {
            $.ajax({
                headers: {
                    Accept: "application/json",
                },
                dataType: 'json',
                url: "/questions/{{ $question->id }}/data",
            }).done(function(data) {
                var chart_id = "bar-chart";
                var chart_type = 'bar';
                var keys = data.keys;
                var values = data.values;
                generateBarChart(chart_id, chart_type, keys, values, color_palettes);
            });
        }
    </script>
@endpush
