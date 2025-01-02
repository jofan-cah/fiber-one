<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\Port;
use App\Models\Splitter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OdcController extends Controller
{
    // Menampilkan semua data Odp
    public function index()
    {
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }
        return view('odc.indexOdc');
    }

    public function getAllData()
    {
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }
        // $data =  Odc::with('olt')->get();
        $data = Odc::withCount('odpss as odp_ports_count')->with('olt')->get();
        $data->map(function ($odp) {
            $odp->available_ports = $odp->odc_port_capacity - $odp->odp_ports_count;
        });

        return response()->json($data);
    }

    public function create()
    {
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }
        $olts = Olt::all();
        $odcs = Odc::all();
        return view('odc.createOdc', compact('olts', 'odcs'));
    }

    public function getPorts($id)
    {
        $ports = Port::where('olt_id', $id)->get();
        return response()->json($ports);
    }

    // Menampilkan detail Odp berdasarkan ID
    public function show($id)
    {
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }
        $odc = Odc::find($id);
        $odcs = Odc::all();
        $olts = Olt::all();

        $ports = Port::where('olt_id', $odc->olt_id)->get();
        // dd($ports);

        return view('odc.editOdc', compact('odc', 'olts', 'odcs','ports'));
    }

    public function showOdc($id)
    {
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }
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
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }

        DB::beginTransaction(); // Memulai transaction
        try {
            // Validasi data
            $validatedData = $request->validate([
                'odc_name' => 'required|string|max:255',
                'odc_description' => 'nullable|string',
                'odc_location_maps' => 'nullable|string',
                'odc_addres' => 'nullable|string',
                'olt_id' => 'nullable|exists:olts,olt_id',
                'odc_port_capacity' => 'required|integer|min:1',
                'parent_odc_id' => 'nullable|string',
                'port_number' => 'required|string',
            ]);

            // Generate ID dan buat data ODC
            $OdpId = $this->generateOdcId();
            $Odp = Odc::create([
                'odc_id' => $OdpId,
                'odc_name' => $validatedData['odc_name'],
                'odc_description' => $validatedData['odc_description'],
                'odc_location_maps' => $validatedData['odc_location_maps'],
                'odc_addres' => $validatedData['odc_addres'],
                'olt_id' => $validatedData['olt_id'] ?? null,
                'odc_port_capacity' => $validatedData['odc_port_capacity'],
                'parent_odc_id' => $validatedData['parent_odc_id'] ?? null,
            ]);

            // Update port ODC to OLT
            if ($validatedData['port_number']) {
                $portODCtoOLT = Port::find($validatedData['port_number']);
                if ($portODCtoOLT) {
                    $portODCtoOLT->odc_id = $OdpId;
                    $portODCtoOLT->save();
                } else {
                    throw new \Exception('Port number not found.');
                }
            }

            // Buat splitter
            for ($i = 1; $i <= $validatedData['odc_port_capacity']; $i++) {
                Splitter::create([
                    'odc_id' => $OdpId,
                    'port_start' => $validatedData['odc_port_capacity'],
                    'port_end' => $i,
                    'port_number' => $i,
                    'direction' => 'Arah ODP '
                ]);
            }

            // Log aktivitas
            logActivity('create', Auth::user()->full_name . ' Created a new ODC with ID: ' . $OdpId);

            DB::commit(); // Commit transaction jika semua berhasil
            return response()->json(['message' => 'ODC created successfully', 'data' => $Odp], 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction jika terjadi error
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Memperbarui data Odpuse Illuminate\Support\Facades\Log;
    public function update(Request $request, $id)
    {
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }
        $Odp = Odc::find($id);

        if (!$Odp) {
            return response()->json(['message' => 'Odp not found'], 404);
        }

        $validatedData = $request->validate([
            'odc_name' => 'required|string|max:255',
            'odc_description' => 'nullable|string',
            'odc_location_maps' => 'nullable|string',
            'odc_addres' => 'nullable|string',
            'olt_id' => 'nullable|exists:olts,olt_id',
            'odc_port_capacity' => 'required|integer|min:1',
            'parent_odc_id' => 'nullable|string',
            'port_number' => 'required|string',
        ]);

        if ($validatedData['port_number']) {
            $portODCtoOLT = Port::find($validatedData['port_number']);
            $portODCtoOLT->odc_id = $id;
            $portODCtoOLT->save();
        }


        $Odp->update([
            'odc_name' => $validatedData['odc_name'],
            'odc_description' => $validatedData['odc_description'],
            'odc_location_maps' => $validatedData['odc_location_maps'],
            'odc_addres' => $validatedData['odc_addres'],
            'olt_id' => $validatedData['olt_id'] ?? null, // Tetapkan null jika tidak ada
            'odc_port_capacity' => $validatedData['odc_port_capacity'],
            'parent_odc_id' => $validatedData['parent_odc_id'] ?? null,
        ]);


        logActivity('update', Auth::user()->full_name .' Updated a new ODC with ID: ' . $id);

        return response()->json(['message' => 'Odp updated successfully', 'data' => $Odp]);
    }

    // Menghapus data Odp
    public function destroy($id)
    {
        if (Gate::denies('isAdminOrNoc')) {
            abort(403, 'Unauthorized action.');
        }
        $Odp = Odc::find($id);

        if (!$Odp) {
            return response()->json(['message' => 'Odp not found'], 404);
        }

        $Odp->delete();
        logActivity('delete', Auth::user()->full_name .' Deleted a new ODC with ID: ' . $id);
        return response()->json(['message' => 'Odp deleted successfully']);
    }

    public function generateOdcId()
    {
        $OdcId = 'ODC-' . rand(1000, 9999);
        return $OdcId;
    }
}
