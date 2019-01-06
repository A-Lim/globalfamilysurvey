
{{-- {{ dd($permissions->toArray()) }} --}}

@foreach ($permissions as $permission)
    <div class="col-md-3">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                    @if (old('permissions'))
                        {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? ' checked' : '' }}
                    @elseif (isset($role))
                        {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}
                    @endif
                    >{{ $permission->label }}
            </label>
        </div>
    </div>
@endforeach
