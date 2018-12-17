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
                    <div class="col-lg-3 col-md-12 col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">{{ $question->title }}</h3>
                            </div>
                            <div class="box-body">
                                {!! get_report_body($question ) !!}
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                    {{-- if there is 4 col in one row already, open a new row --}}
                    @if ($i % 4 == 0)
                        </div>
                        <div class="row">
                    @endif
                @endforeach
            </div>
        @endforeach
    </section>

    <!-- /.content -->
    @endsection

    @prepend('scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    @endprepend

    @php
        $questions = [];
        $exclude = ['Z7Qf3TBhFyzu', 'mh5iJ7YeCPGr', 'iXNVXrRRhjjH', 'mgU53hRD8kek', 'OkWq9Kh6x8SJ', 'lsxEB9b0Psz6',
                    'owI7AqSydQpK', 'KqLHWxTiKXXx', 'IatoKUsfy9KU', 'pdQdVDTLcd6p', 'JO2oxdd9vPaa', 'f9gkhmF0cgAx',
                    'XI91zKHIlUfo', 'pj919CvbWdO6'];
        // retrieve all questions
        foreach ($categories as $category) {
            foreach ($category->questions as $question) {
                // exclude certain questions that we do not want to display as chart
                if (!in_array($question->id, $exclude)) {
                    array_push($questions, $question);
                }
            }
        }
    @endphp

    @push('scripts')
        <script>
            var delay = 2;
            setTimeout("load_charts();", delay * 1000);

            function load_charts() {
                @foreach ($questions as $question)
                @php
                    $answers = $question->answers->pluck('value')->toArray();
                    $report_data = chart_data($answers);
                @endphp
                    var id = "{!! $question->id !!}";
                    var labels = {!! $report_data['labels'] !!};
                    var values = {!! $report_data['values'] !!};
                    var chartType = "{!! get_chart_type($question) !!}";
                    var palette = {!! json_encode(get_color_palettes(1)) !!};

                    switch (chartType) {
                        case 'pie':
                            generatePieChart(id, chartType, labels, values, palette);
                            break;

                        case 'bar':
                            generateBarChart(id, chartType, labels, values, palette);
                            break;

                        default:
                            break;
                    }
                @endforeach
            }
        </script>
    @endpush
