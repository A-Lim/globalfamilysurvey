@component('mail::message')
# Hi {{ $user->name }},

We have just created an account for you. Your credential are as follows:

@component('mail::panel', ['url' => ''])
<strong>Email:</strong> {{ $user->email }} <br />
<strong>Password:</strong> {{ $password }} <br />
@endcomponent

Your church can access the links for the survey as follows:

@component('mail::panel', ['url' => ''])
@foreach ($surveys as $survey)
    <a href="{{ $survey->url.'?ch='.$church->uuid; }}">{{ $survey->title }} [{{ $survey->type }}]</a><br />
@endforeach
@endcomponent

@component('mail::button', ['url' => url('/login')])
Login Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
