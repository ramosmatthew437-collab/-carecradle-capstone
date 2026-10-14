<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $action = trim((string) $request->query('action', ''));
        $module = trim((string) $request->query('module', ''));
        $actor = trim((string) $request->query('actor', ''));

        $allowedPresets = [
            'today',
            'yesterday',
            'last_7_days',
            'last_30_days',
            'custom',
            'all_time',
        ];

        $datePreset = (string) $request->query('date_preset', 'today');

        if (!in_array($datePreset, $allowedPresets, true)) {
            $datePreset = 'today';
        }

        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        // Start with the full activity-log set and eager-load the related user.
        $query = ActivityLog::query()->with('user');

        // Search fields together so OR conditions cannot bypass other filters.
        if ($search !== '') {
            $query->where(function (Builder $subQuery) use ($search) {
                $subQuery
                    ->where('description', 'like', "%{$search}%")
                    ->orWhere('module', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('actor_name', 'like', "%{$search}%")
                    ->orWhere('actor_username', 'like', "%{$search}%")
                    ->orWhere('record_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function (Builder $userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });
            });
        }

        if ($action !== '') {
            $query->where('action', $action);
        }

        if ($module !== '') {
            $query->where('module', $module);
        }

        if ($actor !== '') {
            $query->where(function (Builder $subQuery) use ($actor) {
                $subQuery
                    ->where('actor_username', $actor)
                    ->orWhere(function (Builder $legacyQuery) use ($actor) {
                        $legacyQuery
                            ->where(function (Builder $snapshotQuery) {
                                $snapshotQuery
                                    ->whereNull('actor_username')
                                    ->orWhere('actor_username', '');
                            })
                            ->whereHas('user', function (Builder $userQuery) use ($actor) {
                                $userQuery->where('username', $actor);
                            });
                    });
            });
        }

        // Apply date filters using the application timezone.
        switch ($datePreset) {
            case 'today':
                $query->whereBetween('created_at', [
                    now()->startOfDay(),
                    now()->endOfDay(),
                ]);
                break;

            case 'yesterday':
                $query->whereBetween('created_at', [
                    now()->subDay()->startOfDay(),
                    now()->subDay()->endOfDay(),
                ]);
                break;

            case 'last_7_days':
                $query->whereBetween('created_at', [
                    now()->subDays(6)->startOfDay(),
                    now()->endOfDay(),
                ]);
                break;

            case 'last_30_days':
                $query->whereBetween('created_at', [
                    now()->subDays(29)->startOfDay(),
                    now()->endOfDay(),
                ]);
                break;

            case 'custom':
                $validFromDate = is_string($fromDate)
                    && $fromDate !== ''
                    && Carbon::hasFormat($fromDate, 'Y-m-d');

                $validToDate = is_string($toDate)
                    && $toDate !== ''
                    && Carbon::hasFormat($toDate, 'Y-m-d');

                if ($validFromDate && $validToDate) {
                    $query->whereBetween('created_at', [
                        Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay(),
                        Carbon::createFromFormat('Y-m-d', $toDate)->endOfDay(),
                    ]);
                } elseif ($validFromDate) {
                    $query->where('created_at', '>=',
                        Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay());
                } elseif ($validToDate) {
                    $query->where('created_at', '<=',
                        Carbon::createFromFormat('Y-m-d', $toDate)->endOfDay());
                }
                break;

            case 'all_time':
                // Intentionally do not add a created_at condition.
                break;
        }

        $logs = (clone $query)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        $actions = ActivityLog::query()
            ->whereNotNull('action')
            ->where('action', '!=', '')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $modules = ActivityLog::query()
            ->whereNotNull('module')
            ->where('module', '!=', '')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        // Include legacy records where actor snapshots were not saved.
        $actors = ActivityLog::query()
            ->whereNotNull('actor_username')
            ->where('actor_username', '!=', '')
            ->select('actor_username', 'actor_name')
            ->distinct()
            ->orderBy('actor_name')
            ->get();

        $totalLogs = ActivityLog::count();

        $todayLogs = ActivityLog::query()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->count();

        $yesterdayLogs = ActivityLog::query()
            ->whereBetween('created_at', [
                now()->subDay()->startOfDay(),
                now()->subDay()->endOfDay(),
            ])
            ->count();

        $matchingLogs = (clone $query)->count();

        return view('admin.activity-logs.index', compact(
            'logs',
            'search',
            'action',
            'module',
            'actor',
            'actions',
            'modules',
            'actors',
            'datePreset',
            'fromDate',
            'toDate',
            'totalLogs',
            'todayLogs',
            'yesterdayLogs',
            'matchingLogs'
        ));
    }
}
