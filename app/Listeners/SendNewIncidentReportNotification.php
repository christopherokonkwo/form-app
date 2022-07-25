<?php

namespace App\Listeners;

use App\Events\IncidentReportCreated;
use App\Mail\IncidentReported;
use App\Mail\IncidentReportRecieved;
use Illuminate\Support\Facades\Mail;

class SendNewIncidentReportNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\IncidentReportCreated  $event
     * @return void
     */
    public function handle(IncidentReportCreated $event)
    {
        Mail::to([
            'xtopherc43@gmail.com',
            // 'maxwelnzekwe@gmail.com',
            'it@promatic.ng',
        ])
        ->send(new IncidentReported($event->report->load('machines')));

        Mail::to($event->report->user)
            ->send(new IncidentReportRecieved($event->report));
    }
}
