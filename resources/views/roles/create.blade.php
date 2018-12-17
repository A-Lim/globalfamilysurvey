@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Roles</h1>
        <ol class="breadcrumb">
            <li><a href="/roles"><i class="fa fa-user-astronaut"></i> Roles And Permissions</a></li>
            <li><a class="active"></i> Add Role</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form method="POST" action="/roles">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group {{ $errors->has('label') ? ' has-error' : '' }} col-md-4">
                                    <label for="label">Label</label>
                                    <input type="text" class="form-control" name="label" placeholder="Label" value="{{ old('label') }}">
                                    <span class="text-danger">{{ $errors->first('label') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group {{ $errors->has('permissions') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label>Permissions</label>
                                    </div>
                                    @include('components.options.permissions')
                                    <div class="col-md-12">
                                        <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
