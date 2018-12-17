<option value="">Select a Level</option>

@foreach ($levels as $level)
    @if (isset($user->level))
        <option value="{{ $level->id }}" {{ $level->id == old('level', $user->level->id)  ? 'selected' : '' }}> {{ ucwords($level->label) }} </option>
    @else
        <option value="{{ $level->id }}" {{ $level == old('level')  ? 'selected' : '' }}> {{ ucwords($level->label) }} </option>
    @endif
@endforeach
