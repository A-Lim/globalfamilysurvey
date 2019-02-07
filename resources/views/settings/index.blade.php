@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Settings</h1>
        <ol class="breadcrumb">
            <li><a class="active"><i class="fa fa-wrench"></i> Settings</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('components.status')
        <div class="box box-primary">
            <form method="post" action="/settings">
                @csrf
                @method('patch')
                <div class="box-body">
                    @foreach ($settings as $setting)
                        <div class="row">
                            <div class="form-group {{ $errors->has($setting->key) ? ' has-error' : '' }} col-md-6">
                                <label for="label">{{ ucwords($setting->name) }}</label>
                                @switch($setting->type)
                                    @case(\App\Setting::TYPE_TEXT)
                                        <input type="text" class="form-control" name="{{ $setting->key }}" placeholder="{{ ucwords($setting->name) }}" value="{{ old($setting->key, $setting->value) }}">
                                        @if ($setting->key == 'survey_base_url')
                                            <small class="text-muted">Links end with "/" eg. https://google.com/</small>
                                        @endif
                                        @break

                                    @case(\App\Setting::TYPE_TEXTAREA)
                                        <textarea class="form-control" name="{{ $setting->key }}" placeholder="{{ ucwords($setting->name) }}" rows="5">{{ old($setting->key, $setting->value) }}</textarea>
                                        @break

                                    @default
                                        @break
                                @endswitch


                                <span class="text-danger">{{ $errors->first($setting->key) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection
