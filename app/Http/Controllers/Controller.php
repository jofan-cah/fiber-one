<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Subscription;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $totalOLT = Olt::count(); // Hitung total OLT
        $totalODP = Odp::count(); // Hitung total ODP
        $totalODC = Odc::count(); // Hitung total ODC
        $totalSubscriptions = Subscription::count(); // Hitung total Subscriptions
        return view('dashboard.index',compact('totalOLT', 'totalODP', 'totalODC', 'totalSubscriptions'));
    }
}
