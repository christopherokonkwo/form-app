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
        $all_reports_last_month = $this->incidentQuery();
        $my_reports_last_month = $this->myReports();
        $pending_reports_last_month = $this->incidentQuery('pending');
        $assigned_reports_last_month = $all_reports_last_month - $pending_reports_last_month;
        $assigned_reports_last_month = $this->incidentQuery('assigned');
        $resolved_reports_last_month = $this->incidentQuery('done');

        $results = [
            'pending_reports_last_month' => $pending_reports_last_month,
            'assigned_reports_last_month' => $assigned_reports_last_month,
            'resolved_reports_last_month' => $resolved_reports_last_month,
            'all_reports_last_month' => $all_reports_last_month,
            'my_reports_last_month' => $my_reports_last_month,
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
            ->whereBetween('created_at', [
                today()->subDays(30)->startOfDay()->toDateTimeString(),
                today()->endOfDay()->toDateTimeString(),
            ])
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
            ->whereBetween('created_at', [
                today()->subDays(30)->startOfDay()->toDateTimeString(),
                today()->endOfDay()->toDateTimeString(),
            ])
            ->count();
    }
}
