@component('mail::message')
# Hello sir!

A new report has been created with the data below.

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

{{-- <b>Recieved By</b>: {{ $report->recieved_by }} <br>
<b>Recieved Date</b>: {{ $report->recieved_at }} <br>
<b>Reported By</b>: {{ $report->reported_by }} <br>
<b>Solved By</b>: {{ $report->solved_by }} <br> --}}

@component('mail::button', ['url' => url("/dashboard/reports/{$report->id}/edit")])
    View Report in Dashboard
@endcomponent

Thanks,<br>
<b>{{ config('app.name') }}
@endcomponent
