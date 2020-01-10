@extends('layouts.login')

@section('page-title', 'Forget Password')

@section('content')
<div class="login-box-body">
    <p class="text-center">Please enter your email.</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="post" action="{{ route('password.email') }}">
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
                <button type="submit" class="btn btn-block btn-flat" style="background-color:#ff6508; color:white">Send Password Reset Link</button>
            </div>
        </div>
    </form>
    <a href="/login">Back to login</a><br>
</div>
<!-- /.login-box-body -->
@endsection
