<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Uncoverage;
use Illuminate\Support\Facades\Auth;

class UncoverageController extends Controller
{
    public function index()
    {

        $uncoverages = Uncoverage::all();
        return view('uncoverage.indexUncoverage', compact('uncoverages'));
    }

    public function create()
    {
        return view('uncoverage.create');
    }
    public function generateIdSubs()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz123456789';
        $idLength = 7;
        $randomId = '';

        for ($i = 0; $i < $idLength; $i++) {
            $randomId .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Optional: Ensure ID is unique in the database
        if (Uncoverage::where('subs_id_uncover', $randomId)->exists()) {
            return $this->generateIdSubs();
        }

        return $randomId;
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_subs' => 'required',
            'no_hp' => 'required',
            'maps_locations' => 'required',
        ]);
        $idUncover = $this->generateIdSubs();

        Uncoverage::create([
            'subs_id_uncover' =>$idUncover,
            'nama_subs' => $request->nama_subs,
            'no_hp' => $request->no_hp,
            'maps_locations' => $request->maps_locations
        ]);
        logActivity('create', Auth::user()->full_name .' Created a new Uncoverage with ID: ' . $idUncover);

        return redirect()->route('uncoverage')->with('success', 'Data berhasil disimpan.');
    }
    public function getMapsLocations()
    {
        $locations = Uncoverage::select('maps_locations', 'nama_subs', 'no_hp')->get();

        return response()->json($locations);
    }
}
