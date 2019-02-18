@extends('layouts.admin')
@section('title', 'Member\'s Report | GFS')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard <small>Members Report</small></h1>
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


        @foreach ($categories as $category)
            <h2>{{ $category->name }}</h2>
            @php $i = 0; @endphp
            <div class="row">
                @foreach ($category->questions as $question)
                    <div class="{{ $question->type != 'matrix' ? 'col-lg-6 col-md-6' : 'col-lg-8 col-md-8' }} col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">{{ $question->title }}</h3>
                            </div>
                            <div class="box-body">
                                <canvas id="question-{{ $question->id }}" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                    {{-- @php $i++; @endphp --}}
                    {{-- if there is 4 col in one row already, open a new row --}}
                    {{-- @if ($i % 4 == 0)
                        </div>
                        <div class="row">
                    @endif --}}
                @endforeach
            </div>
        @endforeach
    </section>

    <!-- /.content -->
    @endsection

    @prepend('scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    @endprepend

    {{-- @php
        // $questions = [];
        // $exclude = ['Z7Qf3TBhFyzu', 'mh5iJ7YeCPGr', 'iXNVXrRRhjjH', 'mgU53hRD8kek', 'OkWq9Kh6x8SJ', 'lsxEB9b0Psz6',
        //             'owI7AqSydQpK', 'KqLHWxTiKXXx', 'IatoKUsfy9KU', 'pdQdVDTLcd6p', 'JO2oxdd9vPaa', 'f9gkhmF0cgAx',
        //             'XI91zKHIlUfo', 'pj919CvbWdO6'];
        // // retrieve all questions
        // foreach ($categories as $category) {
        //     foreach ($category->questions as $question) {
        //         // exclude certain questions that we do not want to display as chart
        //         if (!in_array($question->id, $exclude)) {
        //             array_push($questions, $question);
        //         }
        //     }
        // }
    @endphp --}}

    @push('scripts')
        <script>
            $(document).ready(function() {
                load_reports();
            });

            function load_reports() {
                var question_ids = {!! json_encode($question_ids) !!};
                for (var x = 0; x < question_ids.length; x++) {
                    (function(question_id) {
                        $.ajax({
                            headers: {
                                Accept: "application/json",
                            },
                            dataType: 'json',
                            url: "/questions/" + question_id + "/data",
                        }).done(function(data) {
                            var chart_id = "question-" + question_id;
                            var chart_type = 'bar';
                            var keys = data.keys;
                            var values = data.values;

                            if (data.type == 'matrix') {
                                generateBarChart(chart_id, chart_type, keys, values, color_palettes);
                            } else {
                                generatePieChart(chart_id, 'pie', keys, values, other_color_palettes);
                            }
                        });
                    })(question_ids[x]);
                }
            }
        </script>
    @endpush
