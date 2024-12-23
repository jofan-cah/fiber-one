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
            $odps = Odp::select('odp_location_maps', 'odp_id', 'odp_name')->whereNotNull('odp_location_maps')->get();

            // Kembalikan data dalam format JSON
            return response()->json($odps, 200);
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan respons error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allSite(Request $request)
    {
        $olts = OLt::all();

        return view('coverage.siteAllData', compact('olts'));
    }


    // OltController.php
    public function getOlts(Request $request)
    {
        // Ambil data ODC berdasarkan OLT
        $odcs = Odc::where('olt_id', $request->olt_id)->get();
        return response()->json(['odcs' => $odcs]);
    }
    public function getOdcs(Request $request)
    {
        // Ambil data ODC berdasarkan OLT
        $odps = Odp::where('odc_id', $request->odc_id)->get();
        return response()->json(['odps' => $odps]);
    }


    // Controller method
    public function filterDataAll(Request $request)
    {
        $query = Subscription::with(['odp.odc.olt']);

        // Filter berdasarkan OLT
        if ($request->filled('olt_id')) {
            $query->whereHas('odp.odc', function ($query) use ($request) {
                $query->where('olt_id', $request->olt_id);
            });
        }

        // Filter berdasarkan ODC
        if ($request->filled('odc_id')) {
            $query->whereHas('odp', function ($query) use ($request) {
                $query->where('odc_id', $request->odc_id);
            });
        }

        // Filter berdasarkan ODP
        if ($request->filled('odp_id')) {
            $query->where('odp_id', $request->odp_id);

            $subscriptions = $query->get();
            $data = $subscriptions->map(function ($subscription) {
                return [
                    'subs_name' => $subscription->subs_name,
                    'odp_name' => $subscription->odp->odp_name,
                    'odc_name' => $subscription->odp->odc->odc_name,
                    'olt_name' => $subscription->odp->odc->olt->olt_name,
                    'port_available' => $subscription->odp->odp_port_capacity - $subscription->odp->subs()->count(),
                    'odp_id' => $subscription->odp_id,
                    'odc_id' => $subscription->odp->odc_id
                ];
            });
        } elseif ($request->filled('odc_id')) {
            // Jika hanya OLT yang dipilih
            $odcs = Odp::where('odc_id', $request->odc_id)
                ->with('odc')
                ->get();

            $data = $odcs->map(function ($subscription) {
                $odpCount = $subscription->subs()->count();
                return [
                    'subs_name' => $subscription->subs_name ?? '-',
                    'odp_name' => $subscription->odp_name,
                    'odc_name' => $subscription->odc->odc_name,
                    'olt_name' => $subscription->odc->olt->olt_name,
                    'port_available' => $subscription->odc->odc_port_capacity -  $odpCount,
                    'odp_id' => $subscription->odp_id,
                    'odc_id' => $subscription->odc_id
                ];
            });
        } else {
            // Jika hanya OLT yang dipilih
            $odcs = Odc::where('olt_id', $request->olt_id)
                ->with('olt')
                ->get();

            $data = $odcs->map(function ($odc) {
                $odpCount = $odc->odps()->count();
                return [
                    'subs_name' => '-',
                    'odp_name' => '-',
                    'odc_name' => $odc->odc_name,
                    'olt_name' => $odc->olt->olt_name,
                    'port_available' => $odc->odc_port_capacity - $odpCount,
                    'odc_id' => $odc->odc_id,
                    'odp_id' => null
                ];
            });
        }



        return response()->json(['data' => $data]);
    }


    public function topology()
    {
        return view('coverage.topologi');
    }


    public function getTopologyData()
    {
        // Ambil data OLT dengan semua relasi terkait
        $olts = Olt::with(['odcs.childOdcs', 'odcs.odps.childOdps.subs', 'odps.subs'])->get();

        $nodes = [];
        $edges = [];

        foreach ($olts as $olt) {
            // Node untuk OLT
            $nodes[] = [
                'id' => "{$olt->olt_id}",
                'label' => $olt->olt_name,
                'group' => 'OLT'
            ];

            // ODC yang langsung terhubung ke OLT
            foreach ($olt->odcs as $odc) {
                $nodes[] = [
                    'id' => "{$odc->odc_id}",
                    'label' => $odc->odc_name,
                    'group' => 'ODC'
                ];

                $edges[] = [
                    'from' => "{$olt->olt_id}",
                    'to' => "{$odc->odc_id}"
                ];

                // Tambahkan relasi parent-child ODC
                foreach ($odc->childOdcs as $childOdc) {
                    $nodes[] = [
                        'id' => "{$childOdc->odc_id}",
                        'label' => $childOdc->odc_name,
                        'group' => 'ODC'
                    ];

                    $edges[] = [
                        'from' => "{$odc->odc_id}",
                        'to' => "{$childOdc->odc_id}"
                    ];
                }

                // ODP yang terhubung ke ODC ini
                foreach ($odc->odps as $odp) {
                    $nodes[] = [
                        'id' => "{$odp->odp_id}",
                        'label' => $odp->odp_name,
                        'group' => 'ODP'
                    ];

                    $edges[] = [
                        'from' => "{$odc->odc_id}",
                        'to' => "{$odp->odp_id}"
                    ];

                    // Tambahkan relasi parent-child ODP
                    foreach ($odp->childOdps as $childOdp) {
                        $nodes[] = [
                            'id' => "{$childOdp->odp_id}",
                            'label' => $childOdp->odp_name,
                            'group' => 'ODP'
                        ];

                        $edges[] = [
                            'from' => "{$odp->odp_id}",
                            'to' => "{$childOdp->odp_id}"
                        ];
                    }

                    // Subs yang terhubung ke ODP ini
                    foreach ($odp->subs as $subs) {
                        $nodes[] = [
                            'id' => "{$subs->subs_id}",
                            'label' => $subs->subs_name,
                            'group' => 'Subs'
                        ];

                        $edges[] = [
                            'from' => "{$odp->odp_id}",
                            'to' => "{$subs->subs_id}"
                        ];
                    }
                }
            }

            // ODP yang langsung terhubung ke OLT
            foreach ($olt->odps as $odp) {
                $nodes[] = [
                    'id' => "{$odp->odp_id}",
                    'label' => $odp->odp_name,
                    'group' => 'ODP'
                ];

                $edges[] = [
                    'from' => "{$olt->olt_id}",
                    'to' => "{$odp->odp_id}"
                ];

                foreach ($odp->subs as $subs) {
                    $nodes[] = [
                        'id' => "{$subs->subs_id}",
                        'label' => $subs->subs_name,
                        'group' => 'Subs'
                    ];

                    $edges[] = [
                        'from' => "{$odp->odp_id}",
                        'to' => "{$subs->subs_id}"
                    ];
                }
            }
        }

        return response()->json(['nodes' => $nodes, 'edges' => $edges]);
    }
}
