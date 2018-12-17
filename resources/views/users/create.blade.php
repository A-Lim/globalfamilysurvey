@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Register User</h1>
        <ol class="breadcrumb">
            <li><a href="/users"><i class="fa fa-user"></i> Users</a></li>
            <li><a class="active"></i> Register User</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <form method="POST" action="/users">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                                    <label for="name">Name</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>@</strong></span>
                                        <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                                    <label for="email">Email address</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }} col-md-12">
                                    <label for="role">Role</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                        <select class="form-control select2" name="role">
                                            @include('components.options.roles')
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('role') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('level') ? ' has-error' : '' }} col-md-12">
                                    <label for="level">Level</label>
                                    <select class="form-control select2" name="level">
                                        @include('components.options.levels')
                                    </select>
                                    <span class="text-danger">{{ $errors->first('level') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('church') ? ' has-error' : '' }} col-md-12">
                                    <label for="church">Church</label>
                                    <select class="form-control select2" name="church">
                                        @include('components.options.churches')
                                    </select>
                                    <span class="text-danger">{{ $errors->first('church') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Register</button>
                        </div>
                    <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </section>
<!-- /.content -->
@endsection
