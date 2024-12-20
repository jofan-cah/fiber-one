<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use App\Models\Odp;
use App\Models\Olt;
use Illuminate\Http\Request;

class OdcController extends Controller
{
    // Menampilkan semua data Odp
    public function index()
    {
        return view('odc.indexOdc');
    }

    public function getAllData()
    {
        // $data =  Odc::with('olt')->get();
        $data = Odc::withCount('odps as odp_ports_count')->with('olt')->get();
        $data->map(function ($odp) {
            $odp->available_ports = $odp->odc_port_capacity - $odp->odp_ports_count;
        });

        return response()->json($data);
    }

    public function create()
    {
        $olts = Olt::all();
        return view('odc.createOdc', compact('olts'));
    }

    // Menampilkan detail Odp berdasarkan ID
    public function show($id)
    {
        $odc = Odc::find($id);
        $olts = Olt::all();

        return view('odc.editOdc', compact('odc', 'olts'));
    }

    public function showOdc($id)
    {
        // Ambil data OLT berdasarkan olt_id
        $odc = Odc::find($id);

        $odp = Odp::where('odc_id', $odc->odc_id)->get();

        // Hitung jumlah port yang sudah digunakan
        $usedPorts = $odp->count();
        $availablePorts = $odc->odc_port_capacity - $usedPorts;

        return view('odc.showOdc', compact('odc', 'availablePorts'));
    }

    // Menyimpan data Odp baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'odc_name' => 'required|string|max:255',
            'odc_description' => 'nullable|string',
            'odc_location_maps' => 'nullable|string',
            'odc_addres' => 'nullable|string',
            'olt_id' => 'required',
            'odc_port_capacity' => 'required|integer|min:1',
        ]);

        $OdpId = $this->generateOdcId();
        $Odp = Odc::create([
            'odc_id' => $OdpId,
            'odc_name' => $validatedData['odc_name'],
            'odc_description' => $validatedData['odc_description'],
            'odc_location_maps' => $validatedData['odc_location_maps'],
            'odc_addres' => $validatedData['odc_addres'],
            'olt_id' => $validatedData['olt_id'],
            'odc_port_capacity' => $validatedData['odc_port_capacity'],
        ]);
        return response()->json(['message' => 'Odp created successfully', 'data' => $Odp], 201);
    }

    // Memperbarui data Odpuse Illuminate\Support\Facades\Log;
    public function update(Request $request, $id)
    {
        $Odp = Odc::find($id);

        if (!$Odp) {
            return response()->json(['message' => 'Odp not found'], 404);
        }

        $validatedData = $request->validate([
            'odp_name' => 'sometimes|required|string|max:255',
            'odp_description' => 'nullable|string',
            'odp_location_maps' => 'nullable|string',
            'odp_addres' => 'nullable|string',
            'olt_id' => 'required',
            'odp_port_capacity' => 'sometimes|required|integer|min:1',
        ]);

        $Odp->update($validatedData);
        return response()->json(['message' => 'Odp updated successfully', 'data' => $Odp]);
    }

    // Menghapus data Odp
    public function destroy($id)
    {
        $Odp = Odc::find($id);

        if (!$Odp) {
            return response()->json(['message' => 'Odp not found'], 404);
        }

        $Odp->delete();
        return response()->json(['message' => 'Odp deleted successfully']);
    }

    public function generateOdcId()
    {
        $OdcId = 'ODC-' . rand(1000, 9999);
        return $OdcId;
    }
}
