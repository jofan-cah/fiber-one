<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    // Menampilkan data subscriptions
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('subs.indexSubs', compact('subscriptions'));
    }
    public function getAllData()
    {
        $subscriptions = Subscription::all();
        return response()->json($subscriptions);
    }

    // Menampilkan form untuk membuat subscription baru
    public function create()
    {
        $odps = Odp::all();
        return view('subs.createSubs', compact('odps'));
    }

    // Menyimpan data subscription baru
    public function store(Request $request)
    {
        $request->validate([
            'subs_id' => 'required|string|unique:subscriptions',
            'subs_name' => 'required|string|max:255',
            'subs_location_maps' => 'required|string',
            'odp_id' => 'required|string|exists:odps,odp_id',
        ]);

        $data = Subscription::create($request->all());
        return response()->json(['message' => 'Subs created successfully', 'data' => $data], 201);
    }

    // Menampilkan form untuk mengedit subscription
    public function edit($subs_id)
    {
        $subscription = Subscription::findOrFail($subs_id);
        return view('subs.editSubs', compact('subscription'));
    }

    // Memperbarui data subscription
    public function update(Request $request, $subs_id)
    {
        $request->validate([
            'subs_name' => 'required|string|max:255',
            'subs_location_maps' => 'required|string',
            'odp_id' => 'required|string|exists:odps,odp_id',
        ]);

        $subscription = Subscription::findOrFail($subs_id);
        $subscription->update($request->all());

        return response()->json(['message' => 'Subs created successfully'], 201);
    }

    // Menghapus data subscription
    public function destroy($subs_id)
    {
        $subscription = Subscription::findOrFail($subs_id);
        $subscription->delete();
        return response()->json(['message' => 'Subs deleted successfully'], 201);
    }
}
