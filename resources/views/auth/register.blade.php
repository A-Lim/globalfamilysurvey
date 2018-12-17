@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Register User</h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-user"></i> Users</a></li>
        <li><a class="active"></i> Register User</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
        @include('components.status')
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="box-body">
              <div class="row">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-7">
                  <label for="name">Name</label>
                  <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                  <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>

                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} col-md-7">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
                  <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>

                {{-- <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} col-md-7">
                  <label for="password">Password</label>
                  <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                  <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>

                <div class="form-group col-md-7">
                  <label for="password-confirm">Confirm Password</label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                </div> --}}
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Register</button>
            </div>
            <!-- /.box-footer -->
        </form>
      </div>
    </section>
    <!-- /.content -->
@endsection
