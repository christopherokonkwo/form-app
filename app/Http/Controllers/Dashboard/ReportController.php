<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreReportRequest;
use App\Http\Requests\TagRequest;
use App\Models\IncidentReport;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            IncidentReport::query()
               ->select('id', 'name', 'created_at')
               ->latest()
               ->paginate(),
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return response()->json(IncidentReport::query()->make([
            'id' => Uuid::uuid4()->toString(),
        ]), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagRequest  $request
     * @param $id
     * @return JsonResponse
     */
    public function store(StoreReportRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $report = IncidentReport::query()->find($id);

        if (! $report) {
            $report = new IncidentReport(['id' => $id]);
        }

        $report->fill($data);

        $report->save();

        return response()->json($report->refresh(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $report = IncidentReport::query()->findOrFail($id);

        return response()->json($report, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return mixed
     *
     * @throws Exception
     */
    public function destroy($id)
    {
        $report = IncidentReport::query()->findOrFail($id);

        $report->delete();

        return response()->json(null, 204);
    }
}
