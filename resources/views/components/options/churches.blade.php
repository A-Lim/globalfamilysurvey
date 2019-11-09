<option value="">Select a church</option>
@foreach ($churches as $church)
    @if (isset($user->church->id))
        <option value="{{ $church->id }}" {{ $church->id == old('church', $user->church->id)  ? 'selected' : '' }}> {{ $church->uuid }} </option>
    @else
        <option value="{{ $church->id }}" {{ $church->id == old('church')  ? 'selected' : '' }}> {{ $church->uuid }} </option>
    @endif
@endforeach
