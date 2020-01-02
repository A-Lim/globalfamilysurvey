@extends('layouts.admin')
@section('title', 'Member\'s Report | GFS')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard <small><i class="fas fa-caret-right"></i> Congregational Report</small></h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @if (auth()->user()->hasRole('super_admin') && count($permission_role) == 0)
            <div class="callout callout-warning">
                <h4>Site Setup</h4>
                <p>The roles and permissions for this site required setup. Go to <a href="/settings">settings</a> to add roles and permissions.</p>
            </div>
        @endif
        @include('components.status')

        @if (auth()->user()->hasRole('network_leader'))
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Filter By:</label>
                                    <select class="form-control" id="select-filter">
                                        <option value="network">Whole Network</option>
                                        <option value="church">Own Church</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($categories as $category)
            <h2>{{ $category->name }}</h2>
            @php $i = 0; @endphp
            <div class="row">
                @foreach ($category->questions as $question)
                    {{-- <div class="{{ $question->type != 'matrix' ? 'col-lg-6 col-md-6' : 'col-lg-8 col-md-8' }} col-xs-12"> --}}
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">{{ $question->title }}</h3>
                            </div>
                            <div class="box-body">
                                <canvas id="question-{{ $question->id }}" height="150"></canvas>
                                <div class="text-center fa-3x" id="loading-canvas-{{ $question->id }}" style="display:none">
                                    <i class="fa fa-sync fa-spin"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </section>

    <!-- /.content -->
    @endsection

    @prepend('scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.6.0/dist/chartjs-plugin-datalabels.min.js"></script>
    @endprepend

    @push('scripts')
        <script>
            var all_charts = [];
            $(document).ready(function() {
                load_reports();
            });

            @if (auth()->user()->hasRole('network_leader'))
                $('#select-filter').on('change', function() {
                    reset();
                    load_reports(this.value);
                });
            @endif

            function load_reports(filter) {
                var question_ids = {!! json_encode($question_ids) !!};
                var params = '';
                if (filter != '')
                    params = "?filter="+filter;

                for (var x = 0; x < question_ids.length; x++) {
                    startLoading(question_ids[x]);

                    (function(question_id) {
                        $.ajax({
                            headers: {
                                Accept: "application/json",
                            },
                            dataType: 'json',
                            url: "/questions/" + question_id + "/data" + params,
                        }).done(function(data) {
                            var chart;
                            var chart_id = "question-" + question_id;
                            var chart_type = 'bar';
                            var keys = data.keys;
                            var values = data.values;

                            if (data.type == 'matrix' || data.type == 'multiple_choice') {
                                chart = generateBarChart(chart_id, chart_type, keys, values, color_palettes);
                            } else {
                                chart = generatePieChart(chart_id, 'pie', keys, values, other_color_palettes);
                            }
                            all_charts.push(chart);

                            stopLoading(question_id);
                        });
                    })(question_ids[x]);
                }
            }

            function reset() {
                // clear chart
                for (var i = 0; i < all_charts.length; i++) {
                    all_charts[i].destroy();
                }

                // empty array
                all_charts = [];
            }

            function startLoading(id) {
                // spinner
                $('#loading-canvas-' +id).css('display', 'block');
                // canvas
                $('#question-' + id).css('display', 'none');
            }

            function stopLoading(id) {
                // spinner
                $('#loading-canvas-' +id).css('display', 'none');
                // canvas
                $('#question-' + id).css('display', 'block');
            }
        </script>
    @endpush
