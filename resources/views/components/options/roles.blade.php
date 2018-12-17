<option value=""> Select a role </option>
@foreach ($roles as $role)
    @if (isset($user) && isset($user->roles->first()->id))
        <option value="{{ $role->id }}" {{ $role->id == old('role', $user->roles->first()->id) ? 'selected' : '' }}> {{ $role->label }} </option>
    @else
        <option value="{{ $role->id }}" {{ $role->id == old('role') ? 'selected' : '' }}> {{ $role->label }} </option>
    @endif
@endforeach
