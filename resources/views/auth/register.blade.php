@extends('layouts.login')

@section('page-title', 'Register')

@section('content')
    <div class="login-box-body">
        <p class="text-center">Fill in the fields for network registration.</p>
        @include('components.status')
        <form method="post" action="/register">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                        {{-- <span class="glyphicon glyphicon-envelope form-control-feedback {{ $errors->has('email') ? ' icon-danger' : '' }}"></span> --}}
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('city') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}">
                        {{-- <span class="glyphicon glyphicon-envelope form-control-feedback {{ $errors->has('city') ? ' icon-danger' : '' }}"></span> --}}
                        @if ($errors->has('city'))
                            <span class="text-danger" role="alert">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('district') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="District" name="district" value="{{ old('district') }}">
                        {{-- <span class="glyphicon glyphicon-envelope form-control-feedback {{ $errors->has('district') ? ' icon-danger' : '' }}"></span> --}}
                        @if ($errors->has('district'))
                            <span class="text-danger" role="alert">{{ $errors->first('district') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('state') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="State" name="state" value="{{ old('state') }}">
                        {{-- <span class="form-control-feedback {{ $errors->has('state') ? ' icon-danger' : '' }}"></span> --}}
                        @if ($errors->has('state'))
                            <span class="text-danger" role="alert">{{ $errors->first('state') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('country_id') ? ' has-error' : '' }}">
                        {{-- <input type="text" class="form-control" placeholder="Nation" name="nation" value="{{ old('nation') }}"> --}}
                        <select name="country_id" class="select2 form-control">
                            <option>Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        {{-- <span class="form-control-feedback {{ $errors->has('country_id') ? ' icon-danger' : '' }}"></span> --}}
                        @if ($errors->has('country_id'))
                            <span class="text-danger" role="alert">{{ $errors->first('country_id') }}</span>
                        @endif
                    </div>
                </div>

                @if(env('GOOGLE_RECAPTCHA_KEY'))
                    <div class="col-md-12">
                        <div class="form-group has-feedback {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger" role="alert">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                    </div>
                </div>
                @endif

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register Network</button>
                </div>
            </div>
        </form>
        <a href="{{ route('login') }}">Back to login</a><br>
    </div>
    <!-- /.login-box-body -->
@endsection


@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
