@component('mail::message')
# Hello {{ Str::before($report->user->name, ' ') }}

We recieved your report created for {{$report->name}} with the data below.

<b>Name</b>: {{ $report->name }} <br>
<b>Phone</b>: {{ $report->phone }} <br>
<b>Location</b>: {{ $report->location }} <br>

<b>Machine Details</b><br />
@foreach($report->machines as $key => $machine)
<b>{{ $loop->iteration }}.</b>
<b> Type</b>: {{ $machine->type }},
<b> Number</b>: {{ $machine->number }},
<b>Incident Detail</b>: {{ $machine->details }} <br>
@endforeach

<b>Additional Notes</b>: {{ $report->additional_notes }} <br>

<b>Date and Time</b>: {{ $report->created_at->format('M d, Y h:m A') }} <br>

@component('mail::button', ['url' => url("/dashboard/reports/{$report->id}/edit")])
    Check report status
@endcomponent

Thanks,<br>
<b>{{ config('app.name') }}
@endcomponent
