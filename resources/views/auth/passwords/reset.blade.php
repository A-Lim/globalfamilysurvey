@extends('layouts.login')

@section('page-title', 'Reset Password')

@section('content')
    <div class="login-box-body">
        <p class="text-center">Please key in your new password.</p>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback {{ $errors->has('email') ? ' icon-danger' : '' }}"></span>
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >
                        <span class="glyphicon glyphicon-lock form-control-feedback {{ $errors->has('password') ? ' icon-danger' : '' }}"></span>
                        @if ($errors->has('password'))
                            <span class="text-danger" role="alert">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" >
                        <span class="glyphicon glyphicon-lock form-control-feedback {{ $errors->has('password_confirmation') ? ' icon-danger' : '' }}"></span>
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger" role="alert">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Reset Password') }}</button>
                </div>
            </div>
        </form>
        <a href="/login">Back to login</a><br>
    </div>
@endsection
