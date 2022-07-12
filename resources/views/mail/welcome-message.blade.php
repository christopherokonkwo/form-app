@component('mail::message')
# Howdy {{ $user->name }}!

Your account with {{config('app.name')}} has been setup.

Here are your credentials:
<b> email: {{$user->email}}</b>

For security purposes, we did not attach your password with this email but you can reset it via the link below.

@component('mail::button', ['url' => route('password.request')])
Request Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
