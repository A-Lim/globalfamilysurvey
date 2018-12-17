@extends('layouts.admin')
@section('title', 'Dashboard | GFS')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard</h1>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $data['submissions_count'] }}</h3>
                        <p>Submitted Results</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $data['churches_count'] }}</h3>
                        <p>Churches involved</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $data['countries_count'] }}</h3>
                        <p>Countries Participated</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            {{-- <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>
                        <p></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <!-- ./col -->
        </div>

        @foreach ($reports as $report)
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $report->name }}</h1>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="report-leader-{{ $report->id }}"></canvas>
                            <h4>{{ $report->leader_question->title }}</h4>
                            <table class="table table-bordered" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Label</th>
                                        <th colspan="2" style="width: 50%;">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $leader_values = $report->leader_question->answers->pluck('value')->toArray();
                                        $member_values = $report->member_question->answers->pluck('value')->toArray();
                                        $leader_chart_data = chart_data($leader_values);
                                        $member_chart_data = chart_data($member_values);
                                        $index = 0;
                                    @endphp
                                    @foreach ($leader_chart_data['percentage'] as $key => $percentage)
                                        <tr>
                                            <td>{{ ucwords($key) }}</td>
                                            <td style="width: 70%;">
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar" style="width: {{ round($percentage, 2) }}%; background-color: {{ get_color_palettes(1)[$index] }}"></div>
                                                </div>
                                            </td>
                                            <td style="width: 30%;"><span class="badge" style="background-color:{{ get_color_palettes(1)[$index] }}">{{ round($percentage, 2) }}%</span></td>
                                        </tr>
                                    @php $index++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <canvas id="report-member-{{ $report->id }}"></canvas>
                            <h4>{{ $report->member_question->title }}</h4>
                            <table class="table table-bordered" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Label</th>
                                        <th colspan="2" style="width: 50%;">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $leader_values = $report->leader_question->answers->pluck('value')->toArray();
                                        $member_values = $report->member_question->answers->pluck('value')->toArray();
                                        $leader_chart_data = chart_data($leader_values);
                                        $member_chart_data = chart_data($member_values);
                                        $index = 0;
                                    @endphp

                                    @foreach ($member_chart_data['percentage'] as $key => $percentage)
                                    <tr>
                                        <td>{{ ucwords($key) }}</td>
                                        <td style="width: 70%;">
                                            <div class="progress progress-xs">
                                                <div class="progress-bar" style="width: {{ round($percentage, 2) }}%; background-color:{{ get_color_palettes(2)[$index] }}"></div>
                                            </div>
                                        </td>
                                        <td style="width: 30%;"><span class="badge" style="background-color:{{ get_color_palettes(2)[$index] }}">{{ round($percentage, 2) }}%</span></td>
                                    </tr>
                                    @php $index++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    <!-- /.content -->
    @endsection

    @prepend('scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    @endprepend

    @push('scripts')
        <script>
            var delay = 2;
            setTimeout("load_report();", delay * 1000);
            function load_report() {
                @foreach ($reports as $report)
                    @php
                        $leader_values = $report->leader_question->answers->pluck('value')->toArray();
                        $member_values = $report->member_question->answers->pluck('value')->toArray();

                        $leader_chart_data = chart_data($leader_values);
                        $member_chart_data = chart_data($member_values);
                    @endphp
                        var leader_labels = {!! $leader_chart_data['labels'] !!};
                        var leader_values = {!! $leader_chart_data['values'] !!};
                        var member_labels = {!! $member_chart_data['labels'] !!};
                        var member_values = {!! $member_chart_data['values'] !!};

                        // leader's chart
                        new Chart(document.getElementById("report-leader-{{ $report->id }}"), {
                            type: 'bar',
                            data: {
                                labels: leader_labels,
                                datasets: [{
                                    label: "Responses",
                                    backgroundColor: {!! json_encode(get_color_palettes(1)) !!},
                                    data: leader_values
                                }]
                            },
                            options: {
                                legend: { display: false },
                                title: {
                                    display: false,
                                },
                                // scaleSetting is found in js file
                                scales: scaleSetting
                            }
                        });

                        // member's chart
                        new Chart(document.getElementById("report-member-{{ $report->id }}"), {
                            type: 'bar',
                            data: {
                                labels: member_labels,
                                datasets: [{
                                    label: "Responses",
                                    backgroundColor: {!! json_encode(get_color_palettes(2)) !!},
                                    data: member_values
                                }]
                            },
                            options: {
                                legend: { display: false },
                                title: {
                                    display: false,
                                },
                                scales: scaleSetting
                            }
                        });
                @endforeach
            }
        </script>
    @endpush
