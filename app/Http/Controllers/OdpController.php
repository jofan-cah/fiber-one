<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Subscription;
use Illuminate\Http\Request;

class OdpController extends Controller
{
    // Menampilkan semua data Odp
    public function index()
    {
        return view('odp.indexOdp');
    }

    public function getAllData()
    {
        // $data =  Odp::with('odc')->get();
        // $data =  Odc::with('olt')->get();
        $data = Odp::withCount('subs as odp_ports_count')->with('odc')->get();
        $data->map(function ($odp) {
            $odp->available_ports = $odp->odp_port_capacity - $odp->odp_ports_count;
        });


        return response()->json($data);
    }

    public function showOdp($id)
    {
        // Ambil data OLT berdasarkan odc_id
        $odp = Odp::find($id);
        $odc = Subscription::where('odp_id', $odp->odp_id)->get();

        // Hitung jumlah port yang sudah digunakan
        $usedPorts = $odc->count();
        $availablePorts = $odp->odp_port_capacity - $usedPorts;

        return view('odp.showOdp', compact(
            'odp',
            'availablePorts'
        ));
    }

    public function create()
    {
        $odcs = Odc::all();
        $odps = Odp::all();
        return view('odp.createOdp', compact('odps', 'odcs'));
    }

    // Menampilkan detail Odp berdasarkan ID
    public function show($id)
    {
        $odp = Odp::find($id);
        $odps = Odp::all();
        $odcs = Odc::all();

        return view('odp.editOdp', compact('odp', 'odcs', 'odps'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'odp_name' => 'required|string|max:255',
            'odp_description' => 'nullable|string',
            'odp_location_maps' => 'nullable|string',
            'odp_addres' => 'nullable|string',
            'parent_odp_id' => 'nullable|string',
            'odc_id' => 'nullable|exists:odcs,odc_id', // Pastikan `odc_id` valid di tabel `odcs`
            'odp_port_capacity' => 'required|integer|min:1',
        ]);

        // Generate ID untuk ODP
        $OdpId = $this->generateOdpId();

        // Buat data baru di tabel ODP
        $Odp = Odp::create([
            'odp_id' => $OdpId,
            'odp_name' => $validatedData['odp_name'],
            'odp_description' => $validatedData['odp_description'],
            'odp_location_maps' => $validatedData['odp_location_maps'],
            'odp_addres' => $validatedData['odp_addres'],
            'odc_id' => $validatedData['odc_id'] ?? null,
            'odp_port_capacity' => $validatedData['odp_port_capacity'],
            'parent_odp_id' => $validatedData['parent_odp_id'] ?? null,
        ]);

        return response()->json(['message' => 'Odp created successfully', 'data' => $Odp], 201);
    }


    public function update(Request $request, $id)
    {
        $Odp = Odp::find($id);

        if (!$Odp) {
            return response()->json(['message' => 'Odp not found'], 404);
        }

        $validatedData = $request->validate([
            'odp_name' => 'sometimes|required|string|max:255',
            'odp_description' => 'nullable|string',
            'odp_location_maps' => 'nullable|string',
            'odp_addres' => 'nullable|string',
            'parent_odp_id' => 'nullable|string',
            'odc_id' => 'sometimes|required|exists:odcs,odc_id', // Validasi `odc_id`
            'odp_port_capacity' => 'sometimes|required|integer|min:1',
        ]);

        // Update data ODP
        $Odp->update([
            'odp_name' => $validatedData['odp_name'],
            'odp_description' => $validatedData['odp_description'],
            'odp_location_maps' => $validatedData['odp_location_maps'],
            'odp_addres' => $validatedData['odp_addres'],
            'odc_id' => $validatedData['odc_id'] ?? null,
            'odp_port_capacity' => $validatedData['odp_port_capacity'],
            'parent_odp_id' => $validatedData['parent_odp_id'] ?? null,
        ]);

        return response()->json(['message' => 'Odp updated successfully', 'data' => $Odp]);
    }


    // Menghapus data Odp
    public function destroy($id)
    {
        $Odp = Odp::find($id);

        if (!$Odp) {
            return response()->json(['message' => 'Odp not found'], 404);
        }

        $Odp->delete();
        return response()->json(['message' => 'Odp deleted successfully']);
    }

    public function generateOdpId()
    {
        $OdpId = 'ODP-' . rand(1000, 9999);
        return $OdpId;
    }
}