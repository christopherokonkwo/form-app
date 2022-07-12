<?php

namespace App\Mail;

use App\Models\IncidentReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidentReportAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $incidentReport;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(IncidentReport $incidentReport)
    {
        $this->incidentReport = $incidentReport;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.incident-report-assigned')
            ->subject('Admin has assigned you a new incident report');
    }
}
