@extends('layouts.login')

@section('page-title', 'Register')

@section('content')
    <div class="login-box-body">
        <p class="text-center">Select registration type.</p>
        @include('components.status')
        <a class="btn btn-primary btn-block btn-flat" href="/register/network">Register Network</a>
        <a class="btn btn-default btn-block btn-flat" href="/register/church">Register Church</a>
    </div>
    <!-- /.login-box-body -->
@endsection


@section('scripts')

@endsection
