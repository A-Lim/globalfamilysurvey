@component('mail::message')
# Hi {{ $user->name }},

We have just created an account for you. Your credential are as follows:

@component('mail::panel', ['url' => ''])
    <strong>Email:</strong> {{ $user->email }} <br />
    <strong>Password:</strong> {{ $password }} <br />
@endcomponent

{{-- if church has network_uuid --}}
@if ($type == 'network' && $church->network_uuid )
Click on the link below to register any other churches that you want to be under your network.
@component('mail::panel', ['url' => ''])
    <a href="{{ url('register/church?network_uuid='.$church->network_uuid) }}">Register here</a>
@endcomponent
@endif

@if($type == 'church' && count($surveys) > 0)
  Your church can access the links for the survey as follows:

  @component('mail::panel', ['url' => ''])
      @foreach ($surveys as $survey)
          <a href="{{ $survey->url.'?ch='.$church->uuid }}">{{ $survey->title }} [{{ ucfirst($survey->type) }}]</a><br />
      @endforeach
  @endcomponent
@endif

{{-- @if ($church->church_uuid != null)
  Your church can access the links for the survey as follows:

  @component('mail::panel', ['url' => ''])
      @foreach ($surveys as $survey)
          <a href="{{ $survey->url.'?ch='.$church->uuid }}">{{ $survey->title }} [{{ ucfirst($survey->type) }}]</a><br />
      @endforeach
  @endcomponent
@endif --}}

@component('mail::button', ['url' => url('/login')])
    Login Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
