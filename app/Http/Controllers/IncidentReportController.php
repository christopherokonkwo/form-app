<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidentReportRequest;
use App\Http\Requests\UpdateIncidentReportRequest;
use App\Models\IncidentReport;

class IncidentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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

        $report = IncidentReport::create($data);

        return redirect()->route('home')->with('msg', 'Report submitted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncidentReport  $incidentReport
     * @return \Illuminate\Http\Response
     */
    public function show(IncidentReport $incidentReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncidentReport  $incidentReport
     * @return \Illuminate\Http\Response
     */
    public function edit(IncidentReport $incidentReport)
    {
        //
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
