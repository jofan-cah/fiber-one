<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OltController extends Controller
{
    // Menampilkan semua data OLT
    public function index()
    {
        return view('olt.indexOlt');
    }

    public function getAllData()
    {
        // Ambil semua data OLT dan hitung jumlah ODC yang terhubung dengan setiap OLT
        $data = Olt::withCount('odcs as odc_ports_count')->get();
        // Menambahkan kolom available_ports berdasarkan perhitungan
        $data->map(function ($olt) {
            $olt->available_ports = $olt->olt_port_capacity - $olt->odc_ports_count;
            return $olt;
        });

        // Mengembalikan response dalam bentuk JSON
        return response()->json($data);
    }

    public function create()
    {

        return view('olt.createOlt');
    }
    public function showOlt($id)
    {
        // Ambil data OLT berdasarkan olt_id
        $olt = Olt::find($id);

        $odp = Odc::where('olt_id', $olt->olt_id)->get();

        // Hitung jumlah port yang sudah digunakan
        $usedPorts = $odp->count();
        $availablePorts = $olt->olt_port_capacity - $usedPorts;

        return view('olt.showOlt', compact('olt', 'availablePorts'));
    }

    // Menampilkan detail OLT berdasarkan ID
    public function show($id)
    {
        $olt = Olt::find($id);

        return view('olt.editOlt', compact('olt'));
    }

    // Menyimpan data OLT baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'olt_name' => 'required|string|max:255',
            'olt_description' => 'nullable|string',
            'olt_location_maps' => 'nullable|string',
            'olt_addres' => 'nullable|string',
            'olt_port_capacity' => 'required|integer|min:1',
        ]);

        $oltId = $this->generateOltId();
        $olt = Olt::create([
            'olt_id' => $oltId,
            'olt_name' => $validatedData['olt_name'],
            'olt_description' => $validatedData['olt_description'],
            'olt_location_maps' => $validatedData['olt_location_maps'],
            'olt_addres' => $validatedData['olt_addres'],
            'olt_port_capacity' => $validatedData['olt_port_capacity'],
        ]);
        return response()->json(['message' => 'OLT created successfully', 'data' => $olt], 201);
    }

    // Memperbarui data OLTuse Illuminate\Support\Facades\Log;
    public function update(Request $request, $id)
    {
        $olt = Olt::find($id);

        if (!$olt) {
            return response()->json(['message' => 'OLT not found'], 404);
        }

        $validatedData = $request->validate([
            'olt_name' => 'sometimes|required|string|max:255',
            'olt_description' => 'nullable|string',
            'olt_location_maps' => 'nullable|string',
            'olt_addres' => 'nullable|string',
            'olt_port_capacity' => 'sometimes|required|integer|min:1',
        ]);

        $olt->update($validatedData);
        return response()->json(['message' => 'OLT updated successfully', 'data' => $olt]);
    }

    // Menghapus data OLT
    public function destroy($id)
    {
        $olt = Olt::find($id);

        if (!$olt) {
            return response()->json(['message' => 'OLT not found'], 404);
        }

        $olt->delete();
        return response()->json(['message' => 'OLT deleted successfully']);
    }

    public function generateOltId()
    {
        $oltId = 'OLT-' . rand(1000, 9999);
        return $oltId;
    }

    // Tampilkan halaman utama
    public function siteIndex()
    {
        return view('olt.site');
    }


    public function coverage(Request $request)
    {

        return view('coverage.indexCoverage');
    }

    public function site(Request $request)
    {
        $olts = Olt::select('olt_name', 'olt_location_maps')->get();
        $odcs = Odc::select('odc_name', 'odc_location_maps')->get();
        $odps = Odp::select('odp_name', 'odp_location_maps')->get();
        $subs = Subscription::select('subs_name', 'subs_location_maps', 'odp_id')->get();

        return view('coverage.siteAll', compact('olts', 'odcs', 'odps', 'subs'));
    }

    public function getOdp(Request $request)
    {

        if (!$request->ajax()) {
            return abort(403, 'Forbidden');
        };
        try {
            // Ambil data site_location_maps dari database
            $odps = Odp::select('odp_location_maps', 'odp_id')->whereNotNull('odp_location_maps')->get();

            // Kembalikan data dalam format JSON
            return response()->json($odps, 200);
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan respons error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function allSite(Request $request)
    {
        $olts = Olt::select('olt_name', 'olt_location_maps')->get();
        $odcs = Odc::select('odc_name', 'odc_location_maps')->get();
        $odps = Odp::select('odp_name', 'odp_location_maps')->get();
        $subs = Subscription::select('subs_name', 'subs_location_maps', 'odp_id')->get();

        return view('coverage.siteAll', compact('olts', 'odcs', 'odps', 'subs'));
    }
}
