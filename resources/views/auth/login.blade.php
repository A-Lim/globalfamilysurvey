@extends('layouts.login')

@section('page-title', 'Login')

@section('content')
<div class="login-box-body">
    <p class="text-center">Please enter your credentials.</p>
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback {{ $errors->has('email') ? ' icon-danger' : '' }}"></span>
                    @if ($errors->has('email'))
                        <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Password" name="password" >
                    <span class="glyphicon glyphicon-lock form-control-feedback {{ $errors->has('password') ? ' icon-danger' : '' }}"></span>
                    @if ($errors->has('password'))
                        <span class="text-danger" role="alert">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
        </div>
    </form>
    <a href="{{ route('password.request') }}">I forgot my password</a><br>
</div>
<!-- /.login-box-body -->
@endsection
