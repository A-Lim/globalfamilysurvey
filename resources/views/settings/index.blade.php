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
                                @switch($setting->type)
                                    @case(\App\Setting::TYPE_TEXT)
                                        <label for="label">{{ ucwords($setting->name) }}</label>
                                        <input type="text" class="form-control" name="{{ $setting->key }}" placeholder="{{ ucwords($setting->name) }}" value="{{ old($setting->key, $setting->value) }}">
                                        @break

                                    @case(\App\Setting::TYPE_TEXTAREA)
                                        <label for="label">{{ ucwords($setting->name) }}</label>
                                        <textarea class="form-control" name="{{ $setting->key }}" placeholder="{{ ucwords($setting->name) }}" rows="5">{{ old($setting->key, $setting->value) }}</textarea>
                                        @break

                                    @case(\App\Setting::TYPE_CHECKBOX)
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="{{ $setting->key }}" value="1" {{ old($setting->key, $setting->value) == 1 ? 'checked' : '' }}><strong>{{ ucwords($setting->name) }}</strong></label>
                                        </div>
                                        @break

                                    @case(\App\Setting::TYPE_SELECT)
                                        <label for="label">{{ ucwords($setting->name) }}</label>
                                        <select class="form-control" name="{{ $setting->key }}">
                                            @foreach(json_decode($setting->options) as $option)
                                                <option value="{{ $option->value }}" {{ old($setting->key, $setting->value) == $option->value ? 'selected' : '' }} > {{ $option->label }}</option>
                                            @endforeach
                                        </select>
                                        @break;

                                    @default
                                        @break
                                @endswitch

                                @if ($setting->help_text != '')
                                    <span class="help-block">{{ $setting->help_text }}</span>
                                @endif
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
