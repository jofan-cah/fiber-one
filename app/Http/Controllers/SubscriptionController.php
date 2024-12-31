<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use App\Models\Subscription;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule as ValidationRule;

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
        $subscriptions = Subscription::with('odp')->get();
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
            'port' => 'required',
        ]);

        $data = Subscription::create($request->all());
        logActivity('create', Auth::user()->full_name .' Created a new Pelanggan with ID: ' . $request->subs_id);

        return response()->json(['message' => 'Subs created successfully', 'data' => $data], 201);
    }

    // Menampilkan form untuk mengedit subscription
    public function show($subs_id)
    {
        $subs = Subscription::findOrFail($subs_id);
        $odps = Odp::all();
        return view('subs.editSubs', compact('subs', 'odps'));
    }

    // Memperbarui data subscription
    public function update(Request $request, $subs_id)
    {
        // Find the subscription using subs_id as the primary key
        $subscription = Subscription::where('subs_id', $subs_id)->firstOrFail();

        // Validate the request data
        $request->validate([
            'subs_name' => 'required|string|max:255',
            'subs_location_maps' => 'required|string',
            'odp_id' => 'required|string|exists:odps,odp_id',
            'subs_id' => [
                'required',
                ValidationRule::unique('subscriptions', 'subs_id')->ignore($subscription->subs_id, 'subs_id'),
            ],
            'port' => 'required',
        ]);

        // Update the subscription
        $subscription->update($request->all());
        logActivity('update', Auth::user()->full_name .' Updated a new Pelanggan with ID: ' . $subs_id);

        return response()->json(['message' => 'Subscription updated successfully'], 200);
    }

    // Menghapus data subscription
    public function destroy($subs_id)
    {
        $subscription = Subscription::findOrFail($subs_id);
        $subscription->delete();
        logActivity('delete', Auth::user()->full_name .' Deleted a new Pelanggan with ID: ' . $subs_id);
        return response()->json(['message' => 'Subs deleted successfully'], 201);
    }
}
