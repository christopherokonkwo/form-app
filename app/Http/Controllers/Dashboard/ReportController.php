<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreReportRequest;
use App\Http\Requests\TagRequest;
use App\Mail\IncidentReportAssigned;
use App\Mail\IncidentReportResolved;
use App\Models\IncidentReport;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
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
                ->with(['assignedUser', 'machines'])
            //    ->select('id', 'name', 'created_at')
                ->when(request()->user()->isContributor, function (Builder $query) {
                    return $query->where('user_id', request()->user()->id);
                })
                ->when(request()->user()->isEditor, function (Builder $query) {
                    return $query->where('user_id', request()->user()->id)
                        ->orWhere('assigned_to', request()->user()->id);
                })
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
        return response()->json(['report' => IncidentReport::query()->make([
            'id' => Uuid::uuid4()->toString(),
        ])], 200);
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

        if ($data['status'] == 'done' && $report->status != 'done') {
            Mail::to($report->user)
                ->send(new IncidentReportResolved($report));
        }

        $report->fill($data);

        $report->save();

        if ($data['assigned_user'] && $data['assigned_user']['id'] != $report->assigned_to) {
            $report->assigned_to = $data['assigned_user']['id'];
            $report->assigned_at = now();
            $report->status = 'assigned';
            $report->save();

            Mail::to($report->assignedUser)
                ->send(new IncidentReportAssigned($report));
        }

        $report->load(['assignedUser:name,id', 'user:name,id']);

        return response()->json([
            'report' => $report->refresh(),
            'assignees' => User::where('role', User::EDITOR)->get(['id', 'name']),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $report = IncidentReport::query()
            ->with(['assignedUser:name,id', 'user:name,id', 'machines', 'media'])
            ->findOrFail($id);

        return response()->json([
            'report' => $report,
            'assignees' => User::where('role', User::EDITOR)->get(['id', 'name']),
        ], 200);
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
