<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use App\Models\PortOdps;
use App\Models\Subscription;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule as ValidationRule;

class SubscriptionController extends Controller
{

    // Menampilkan data subscriptions
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('subs.indexSubs', compact('subscriptions'));
    }
    public function getAllData(Request $request)
    {
        // harus request Ajax
        if (!$request->ajax()) {
            return abort(403, 'Forbidden');
        };
        $subscriptions = Subscription::with('odp.odc.olt')->get();
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
        DB::beginTransaction(); // Memulai transaction
        try {
            // Validasi data
            $validatedData = $request->validate([
                'subs_id' => 'required|string|unique:subscriptions',
                'subs_name' => 'required|string|max:255',
                'subs_location_maps' => 'required|string',
                'odp_id' => 'required|string|exists:odps,odp_id',
                'splitter_id' => 'required|exists:port_odps,id', // Pastikan splitter_id valid,
                'sn' => 'required|string',
                'type_modem'=> 'required|string',
            ]);

            // Buat data baru di tabel Subscription
            $data = Subscription::create([
                'subs_id' => $validatedData['subs_id'],
                'subs_name' => $validatedData['subs_name'],
                'subs_location_maps' => $validatedData['subs_location_maps'],
                'odp_id' => $validatedData['odp_id'],
                'sn'=> $validatedData['sn'],
                'type_modem'=> $validatedData['type_modem'],
            ]);

            // Update splitter jika splitter_id tersedia
            $portODCtoOLT = PortOdps::find($validatedData['splitter_id']);
            if ($portODCtoOLT) {
                $portODCtoOLT->update(['subs_id' => $validatedData['subs_id']]);
            }

            // Log aktivitas
            logActivity('create', Auth::user()->full_name . ' Created a new Pelanggan with ID: ' . $validatedData['subs_id']);

            DB::commit(); // Commit transaction jika semua berhasil
            return response()->json(['message' => 'Subscription created successfully', 'data' => $data], 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika terjadi error
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage(),
            ], 500);
        }
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
            'sn' => 'required|string',
            'type_modem'=> 'required|string',
            'subs_id' => [
                'required',
                ValidationRule::unique('subscriptions', 'subs_id')->ignore($subscription->subs_id, 'subs_id'),
            ],
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
