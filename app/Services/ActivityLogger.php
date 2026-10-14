<?php

namespace  App\Services;




use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public function log(
        string $action,
        string $module,
        string $description,
        ?int $recordId = null
    ): ActivityLog {
        $request = request();
        $user = Auth::user();

        return ActivityLog::create([
            'user_id' => Auth::id(),

            // Preserve the actor's identity for historical audit records.
            'actor_name' => $user?->name,
            'actor_username' => $user?->username,

            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'description' => $description,

            'ip_address' => $request instanceof Request
                ? $request->ip()
                : null,

            'user_agent' => $request instanceof Request
                ? substr((string) $request->userAgent(), 0, 500)
                : null,
        ]);
    }
}