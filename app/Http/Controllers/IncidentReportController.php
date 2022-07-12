<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidentReportRequest;
use App\Http\Requests\UpdateIncidentReportRequest;
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

        return redirect()->route('home')->with('msg', 'Report submitted successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIncidentReportRequest  $request
     * @param  \App\Models\IncidentReport  $incidentReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIncidentReportRequest $request, IncidentReport $incidentReport)
    {
        $data = $request->validated();

        $incidentReport->update($data);

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncidentReport  $incidentReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncidentReport $incidentReport)
    {
        $incidentReport->delete();

        return redirect()->route('home')->with('msg', 'report deleted!');
    }
}
