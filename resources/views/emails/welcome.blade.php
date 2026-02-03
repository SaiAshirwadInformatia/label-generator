@component('mail::message')
    # Dear {{ $user->name }}

    Your account is ready, please click on below button to activate your account.

    @component('mail::button', ['url' => route('activation.index', ['user' => $user->ott])])
        Activate Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
