<?php


use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('logActivity')) {
    function logActivity($action, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id() ?? null, // Ambil user_id jika login, null jika tidak
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}
