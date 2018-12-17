@extends('layouts.login')

@section('content')
<div class="login-box-body">
    <p class="text-center">Please key in your new password.</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="post" action="{{ route('password.request') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $email ?? old('email') }}" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback {{ $errors->has('email') ? ' icon-danger' : '' }}"></span>
                    @if ($errors->has('email'))
                        <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Password" name="password" >
                    <span class="glyphicon glyphicon-lock form-control-feedback {{ $errors->has('password') ? ' icon-danger' : '' }}"></span>
                    @if ($errors->has('password'))
                        <span class="text-danger" role="alert">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('password-confirm') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="password-confirm">
                    <span class="glyphicon glyphicon-lock form-control-feedback {{ $errors->has('password-confirm') ? ' icon-danger' : '' }}"></span>
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
            </div>
        </div>
    </form>
    <a href="/login">Back to login</a><br>
</div>
<!-- /.login-box-body -->
@endsection
