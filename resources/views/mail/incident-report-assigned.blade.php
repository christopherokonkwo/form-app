@component('mail::message')
# Hi {{$incidentReport->assignedUser->name}}

A new incident report has been assigned to you.

@component('mail::button', ['url' => route('dashboard')])
View Report
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
