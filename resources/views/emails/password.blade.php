@component('mail::message')
# Dear {{ $user->name }}

Please reset your password by click on below button

@component('mail::button', ['url' => route('activation.index', ['user' => $user->ott])])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
