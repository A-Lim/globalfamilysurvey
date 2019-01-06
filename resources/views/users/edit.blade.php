@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit User</h1>
        <ol class="breadcrumb">
            <li><a href="/users"><i class="fa fa-user"></i> Users</a></li>
            <li><a class="active"></i> Edit User</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <form method="post" action="/users/{{ $user->id }}">
                        @method('patch')
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                                    <label for="name">Name</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>@</strong></span>
                                        <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name', $user->name)}}">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                                    <label for="email">Email address</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email', $user->email)}}">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            @if (auth()->user()->hasRole('super_admin'))
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
                                    </div>
                                    <span class="text-danger">{{ $errors->first('level') }}</span>
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
                            @endif

                            @if (auth()->user()->id == $user->id)
                                <div class="row">
                                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} col-md-12">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><li class="fa fa-key"></li></span>
                                            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="password-confirm">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><li class="fa fa-check"></li></span>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Edit</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="church">Church</label>
                                <select class="form-control select2" name="church" disabled>
                                    @include('components.options.churches')
                                </select>
                            </div>
                        </div>

                        <label>Survey Links</label>
                        {{-- <input id="foo" value="https://github.com/zenorocha/clipboard.js.git">

                        <!-- Trigger -->
                        <button class="copy-btn" data-clipboard-target="#foo">
                            <img src="assets/clippy.svg" alt="Copy to clipboard">
                        </button> --}}

                        @foreach ($surveys as $survey)
                            <div class="row">
                                <div class="form-group col-md-12">
                                    @php
                                    $url = $survey_base_url->value.$survey->id.'?church='.$church->uuid;
                                    @endphp
                                    <div><i class="fa fa-link"></i>  <a target="_blank" href="{{ $url }}">{{ $survey->title }}</a></div>
                                    <div class="input-group">
                                        <input id="link-{{ $survey->id }}" type="text" class="form-control" value="{{ $url }}" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="copy-btn btn btn-primary" data-clipboard-target="#link-{{ $survey->id }}"><i class="fa fa-copy"></i>&nbsp;</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script src="{{ asset('/plugins/clipboard/clipboard.min.js') }}"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $('.copy-btn').tooltip({
            trigger: 'click',
            placement: 'bottom'
        });
        var clipboard = new ClipboardJS('.copy-btn');
        clipboard.on('success', function(e) {
            setTooltip(e.trigger, 'Copied!');
        });
    });
    </script>
@endpush
