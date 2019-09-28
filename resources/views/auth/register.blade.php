@extends('layouts.login')

@section('page-title', 'Register')

@section('content')
    <div class="login-box-body">
        <p class="login-box-msg">Select Registration Type</p>
        @include('components.status')
        <a class="btn btn-primary btn-block btn-flat" href="/register/network">Register Network</a>
        <a class="btn btn-default btn-block btn-flat" href="/register/church">Register Church</a>

        <div class="login-box-footer">
          <br/>
          <p>
              Already have an account? <a href="{{ url('/login') }}">Login Here</a>
          </p>
        </div>
    </div>



    <!-- /.login-box-body -->
@endsection


@section('scripts')

@endsection
