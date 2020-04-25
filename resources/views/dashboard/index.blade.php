@extends('layouts.admin')
@section('title', 'Dashboard | GFS')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard <small><i class="fas fa-caret-right"></i> Leadership Report</small></h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @if (auth()->user()->hasRole('super_admin') && count($permission_role) == 0)
            <div class="callout callout-warning">
                <h4>Site Setup</h4>
                <p>The roles and permissions for this site required setup. Go to <a href="/roles">Roles and Permission</a> page to configure permissions.</p>
            </div>
        @endif
        @include('components.status')
        <!-- Small boxes (Stat box) -->
        @if (auth()->user()->hasRole('super_admin'))
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $data['submissions_count'] }}</h3>
                            <p>Submitted Results</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-contacts"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>{{ $data['churches_count'] }}</h3>
                            <p>Churches Registered</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-merge"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>{{ $data['countries_count'] }}</h3>
                            <p>Countries Participated</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-earth"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                                        <option value="church">My Own Church</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($reports)
          @foreach ($reports as $report)
              <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">{{ $report->name }}</h1>
                  </div>

                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-6">
                              <canvas id="report-leader-{{ $report->id }}"></canvas>
                              <div class="text-center fa-3x" id="loading-leader-canvas-{{ $report->id }}" style="display:none">
                                <i class="fa fa-sync fa-spin"></i>
                              </div>
                              
                              <h4>{{ $report->leader_question->title }}</h4>
                              <table id="table-leader-{{ $report->id }}" class="table table-bordered" style="font-size: 14px;">
                                  <thead>
                                      <tr>
                                          <th style="width: 50%;">Label</th>
                                          <th colspan="2" style="width: 50%;">Percentage</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
                              <div class="text-center fa-3x" id="loading-leader-table-{{ $report->id }}" style="display:none">
                                <i class="fa fa-sync fa-spin"></i>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <canvas id="report-member-{{ $report->id }}"></canvas>
                              <div class="text-center fa-3x" id="loading-member-canvas-{{ $report->id }}" style="display:none">
                                <i class="fa fa-sync fa-spin"></i>
                              </div>
                              <h4>{{ $report->member_question->title }}</h4>
                              <table id="table-member-{{ $report->id }}" class="table table-bordered" style="font-size: 14px;">
                                  <thead>
                                      <tr>
                                          <th style="width: 50%;">Label</th>
                                          <th colspan="2" style="width: 50%;">Percentage</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
                              <div class="text-center fa-3x" id="loading-member-table-{{ $report->id }}" style="display:none">
                                <i class="fa fa-sync fa-spin"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          @endforeach
        @endif

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
            var all_tables = [];

            $(document).ready(function() {
                load_all_reports();
            });

            @if (auth()->user()->hasRole('network_leader'))
                $('#select-filter').on('change', function() {
                    reset();
                    load_all_reports(this.value);
                });
            @endif

            function load_all_reports(filter) {
                // preload 
                var report_ids = {!! json_encode($reports->pluck('id')->toArray()) !!};
                for (var x = 0; x < report_ids.length; x++) {
                    startLoading('leader', report_ids[x]);
                    startLoading('member', report_ids[x]);
                }

                var params = '';
                if (filter != '' && filter != undefined)
                    params = "?filter="+filter;
                
                $.ajax({
                    headers: { Accept: "application/json" },
                    dataType: 'json',
                    url: "/reports/data" + params,
                }).done(function (data) {
                    for (var x = 0; x < data.length; x++) {
                        load_charts(data[x].report_id, data[x]);
                        // clear table for appending data
                        load_percentage_table(data[x].report_id, data[x]);

                        stopLoading('leader', data[x].report_id);
                        stopLoading('member', data[x].report_id);
                    }
                });
            }

            function load_reports(filter) {
                var report_ids = {!! json_encode($reports->pluck('id')->toArray()) !!};
                var params = '';
                if (filter != '' && filter != undefined)
                    params = "?filter="+filter;

                for (var x = 0; x < report_ids.length; x++) {

                    startLoading('leader', report_ids[x]);
                    startLoading('member', report_ids[x]);

                    // https://stackoverflow.com/questions/750486/javascript-closure-inside-loops-simple-practical-example
                    // immediately invoked function expression
                    (function(report_id) {
                        $.ajax({
                            headers: {
                                Accept: "application/json",
                            },
                            dataType: 'json',
                            url: "/reports/" + report_id + "/data" + params,
                        }).done(function(data) {
                            load_charts(report_id, data);

                            // clear table for appending data

                            load_percentage_table(report_id, data);

                            stopLoading('leader', report_id);
                            stopLoading('member', report_id);
                        });
                    })(report_ids[x]);
                }
            }

            function load_charts(id, data) {
                var l_chart_id = "report-leader-" + id;
                var m_chart_id = "report-member-" + id;

                var l_chart = generateBarChart(l_chart_id, 'bar', data.leader_data.keys, data.leader_data.values,color_palettes);
                var m_chart = generateBarChart(m_chart_id, 'bar', data.member_data.keys, data.member_data.values,other_color_palettes);

                all_charts.push(l_chart);
                all_charts.push(m_chart);
            }

            function load_percentage_table(report_id, data) {
                var leader_html = '', member_html = '';

                for (var x = 0; x < data.leader_data.values.length; x++) {
                    var text = data.leader_data.keys[x];
                    var percentage = data.leader_data.total == 0 ? 0 : ((data.leader_data.values[x] / data.leader_data.total) * 100).toFixed(2);
                    var color = color_palettes[x];
                    leader_html += row_template(text, percentage, color);
                }

                for (var x = 0; x < data.member_data.values.length; x++) {
                    var text = data.member_data.keys[x];
                    var percentage = data.member_data.total == 0 ? 0 : ((data.member_data.values[x] / data.member_data.total) * 100).toFixed(2);
                    var color = other_color_palettes[x];
                    member_html += row_template(text, percentage, color);
                }

                all_tables.push('#table-leader-'+report_id);
                all_tables.push('#table-member-'+report_id);

                $('#table-leader-'+report_id).append(leader_html);
                $('#table-member-'+report_id).append(member_html);
            }

            function reset() {
                // clear chart
                for (var i = 0; i < all_charts.length; i++) {
                    all_charts[i].destroy();
                }

                // clear table
                for (var i = 0; i < all_tables.length; i++) {
                    $(all_tables[i] + '> tbody').empty();
                }

                // empty array
                all_charts = [];
                all_tables = [];
            }

            function startLoading(type, id) {
                // spinner
                $('#loading-' + type + '-canvas-' +id).css('display', 'block');
                $('#loading-'+ type + '-table-' +id).css('display', 'block');

                // canvas
                $('#report-' + type + '-' + id).css('display', 'none');
                // table
                $('#table-' + type + '-' + id).css('display', 'none');
            }

            function stopLoading(type, id) {
                // spinner
                $('#loading-' + type + '-canvas-' +id).css('display', 'none');
                $('#loading-'+ type + '-table-' +id).css('display', 'none');

                // canvas
                $('#report-' + type + '-' + id).css('display', 'block');
                // table
                $('#table-' + type + '-' + id).css('display', 'block');
            }
        </script>
    @endpush
