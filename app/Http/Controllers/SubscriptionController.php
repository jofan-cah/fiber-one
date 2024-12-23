<?php

namespace App\Http\Controllers;

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

    // Menampilkan form untuk membuat subscription baru
    public function create()
    {
        return view('subs.createSubs');
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

        Subscription::create($request->all());
        return redirect()->route('subs.index')->with('success', 'Subscription created successfully');
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

        return redirect()->route('subs.index')->with('success', 'Subscription updated successfully');
    }

    // Menghapus data subscription
    public function destroy($subs_id)
    {
        $subscription = Subscription::findOrFail($subs_id);
        $subscription->delete();

        return redirect()->route('subs.index')->with('success', 'Subscription deleted successfully');
    }
}
