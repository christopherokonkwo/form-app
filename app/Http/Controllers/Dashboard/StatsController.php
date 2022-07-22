<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\IncidentReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $all_reports = $this->incidentQuery();
        $my_reports = $this->myReports();
        $pending_reports = $this->incidentQuery('pending');
        // $assigned_reports = $all_reports - $pending_reports;
        $assigned_reports = $this->assignedReports();
        $resolved_reports = $this->incidentQuery('done');

        $results = [
            'pending_reports' => $pending_reports,
            'assigned_reports' => $assigned_reports,
            'resolved_reports' => $resolved_reports,
            'all_reports' => $all_reports,
            'my_reports' => $my_reports,
        ];

        return response()->json($results);
    }

    public function incidentQuery($status = '')
    {
        return IncidentReport::query()
            ->when(in_array($status, ['done', 'pending']), function (Builder $query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($status == 'assigned', function (Builder $query) {
                return $query->where('assigned_to', request()->user()->id);
            })
            ->when(request()->user()->isContributor, function (Builder $query) {
                return $query->where('user_id', request()->user()->id);
            })
            ->when(request()->user()->isEditor, function (Builder $query) {
                return $query->where(function (Builder $query) {
                    return $query->where('user_id', request()->user()->id)
                    ->orWhere('assigned_to', request()->user()->id);
                });
            })
            ->count();
    }

    public function myReports()
    {
        return IncidentReport::query()
            ->where('user_id', request()->user()->id)
            ->count();
    }

    public function assignedReports()
    {
        return IncidentReport::query()
            // ->where('status', 'assigned')
            ->whereNotNull('assigned_to')
            ->when(request()->user()->isEditor, function (Builder $query) {
                return $query->where('assigned_to', request()->user()->id);
            })
            ->count();
    }
}
