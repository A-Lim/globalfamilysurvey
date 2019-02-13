@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Webhooks</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-broadcast-tower"></i> Webhooks</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <div class="box-body">
                {{-- @can('retrieve', App\Survey::class) --}}
                    <div class="box-header with-border">
                        <a href="/webhooks/create" class="btn btn-primary pull-right">Create Webhook</a>
                    </div>
                {{-- @endcan --}}
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Survey Name</th>
                            <th>Event Type</th>
                            <th class="col-action">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($webhooks as $webhook)
                            <tr>
                                <td> {{ str_limit($webhook->name, 50) }} </td>
                                <td> {{ $webhook->survey->title }} </td>
                                <td> {{ ucwords(str_replace('_', ' ', $webhook->event_type)) }} </td>
                                <td>
                                    @can('update', $webhook)
                                        <a class="link-btn" href="/webhooks/{{ $webhook->id }}/edit" title="View">
                                            <button type="button" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                    @endcan

                                    @can('delete', $webhook)
                                        <form action="/webhooks/{{ $webhook->id }}" method="post" class="form-btn">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger" title="delete" onclick="return confirm('Are you sure you want to delete webhook?')">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    {{ $webhooks->links() }}
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
