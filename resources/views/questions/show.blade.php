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
                        <label for="id">Typeform ID</label>
                        <input type="text" class="form-control" name="id" placeholder="Typeform ID" value="{{ $question->id }}" disabled>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endprepend

@push('scripts')
    <script>
    new Chart(document.getElementById("bar-chart"), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($grouped_answers)) !!},
            datasets: [{
                label: "Responses",
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850", "#f50057", "#ffeb3b", "#ff9800", "#607d8b", "#808080"],
                data: {!! json_encode(array_flatten($grouped_answers)) !!}
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: '{{ $question->type == "legal" ? "Terms and condition?" : $question->title }}'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fixedStepSize: 1
                    }
                }]
            }
        }
    });
    </script>
@endpush
