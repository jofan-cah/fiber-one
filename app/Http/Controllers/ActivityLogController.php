<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{

    public function index()
    {
        $logs = ActivityLog::latest()->paginate(20);
        return view('logs.indexlogs', compact('logs'));
    }
}
