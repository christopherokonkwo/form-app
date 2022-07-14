@component('mail::message')
# Hi {{$report->user->name}}

Your incident report filed on: {{$report->created_at->format('d M, Y ')}} has been resolved!

@component('mail::button', ['url' => route('dashboard')])
Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
