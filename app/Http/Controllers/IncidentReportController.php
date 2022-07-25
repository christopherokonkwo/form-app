<?php

namespace App\Http\Controllers;

use App\Events\IncidentReportCreated;
use App\Http\Requests\StoreIncidentReportRequest;
use App\Models\IncidentReport;
use Ramsey\Uuid\Uuid;

class IncidentReportController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('incident-form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIncidentReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIncidentReportRequest $request)
    {
        // dd($request);
        $data = $request->validated();

        $report = new IncidentReport([
            'id' => Uuid::uuid4()->toString(),
            'user_id' => auth()->id(),
         ]);
        $report->fill($data);
        $report->save();

        $machines = [];

        foreach ($data['machine_type'] as $key => $value) {
            $machines[$key]['type'] = $value;
            $machines[$key]['number'] = $data['machine_number'][$key];
            $machines[$key]['details'] = $data['incident_detail_option'][$key];
        }
        $report->machines()->createMany($machines);

        if (request()->hasFile('attachments')) {
            // dd(request()->attachments);
            foreach (request()->file('attachments') as $key => $attachment) {
                logger($key);
                $report->addMedia($attachment)->toMediaCollection('attachment');
            }
        }

        event(new IncidentReportCreated($report));

        return redirect()->route('home')->with('msg', 'Report submitted successfully!');
    }
}
