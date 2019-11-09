@extends('layouts.login')

@section('page-title', 'Register')

@section('content')
    <div class="login-box-body">
        @if ($is_opened)
            <p class="text-center">Fill in the fields for network registration.</p>
            @include('components.status')
            <form method="post" action="/register/church">
            @csrf
            @if (request()->has('network_uuid') && request('network_uuid') != '')
                <input type="hidden" name="network_uuid" value="{{ request('network_uuid') }}" / />
                @if ($errors->has('network_uuid'))
                    <div class="alert alert-danger" role="alert">{{ $errors->first('network_uuid') }}</div>
                @endif
            @endif
            <div class="row">
                @if (!request()->has('network_uuid'))
                    <div class="col-md-12">
                        <div class="form-group has-feedback {{ $errors->has('network_uuid') ? ' has-error' : '' }}">
                            <input type="network_uuid" class="form-control" placeholder="Network ID" name="network_uuid" value="{{ old('network_uuid') }}">
                            <p class="help-block"><small>Do you have a network to register under? If not just leave this field empty.</small></p>
                            <span class="text-danger" role="alert">{{ $errors->first('network_uuid') }}</span>
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                        <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('city') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}">
                        <span class="text-danger" role="alert">{{ $errors->first('city') }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('district') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="District" name="district" value="{{ old('district') }}">
                        <span class="text-danger" role="alert">{{ $errors->first('district') }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('state') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="State" name="state" value="{{ old('state') }}">
                        <span class="text-danger" role="alert">{{ $errors->first('state') }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback {{ $errors->has('country_id') ? ' has-error' : '' }}">
                        <select name="country_id" class="select2 form-control">
                            <option>Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" role="alert">{{ $errors->first('country_id') }}</span>
                    </div>
                </div>

                @if(env('ACTIVATE_RECAPTCHA') && env('GOOGLE_RECAPTCHA_KEY'))
                    <div class="col-md-12 text-center">
                        <div class="form-group has-feedback {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                            <span class="text-danger" role="alert">{{ $errors->first('g-recaptcha-response') }}</span>
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
            </div>
        </form>
            <a href="/register">Back to select registration type</a><br>
            <a href="/login">Back to login</a><br>
        @else
            <p class="text-primary text-center">Registration for Global Family Survey Challenge is closed.</p>
        @endif
    </div>
    <!-- /.login-box-body -->
@endsection


@section('scripts')

@endsection
