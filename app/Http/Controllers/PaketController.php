<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaketController extends Controller
{
    // Menampilkan semua paket
    public function index()
    {
        $pakets = Paket::all();
        return view("paket.indexPaket", compact("pakets"));
    }

    public function create()
    {
        return view("paket.createPaket");
    }

    public function getAllData()
    {
        $pakets = Paket::all();
        return response()->json($pakets);
    }

    public function generatePaketID()
    {
        do {
            $paketID = 'PKT-' . strtoupper(Str::random(10));
        } while (Paket::where('pakets_id', $paketID)->exists()); // Pastikan tidak duplikat

        return $paketID;
    }

    // Menyimpan paket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'pakets_id' => 'required|unique:pakets|string|max:255',
            'nama_paket' => 'required|string|max:255',
            // 'description' => 'nullable|string',
            // 'price' => 'required|numeric|min:0',
            // 'speed' => 'required|string|max:50',
            // 'status' => 'required|boolean',
            // 'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Panggil fungsi generatePaketID
        $paketID = $this->generatePaketID();

        // Buat paket baru
        $paket = Paket::create([
            'pakets_id' => $paketID,
            'nama_paket' => $validated['nama_paket'],
        ]);
        return response()->json(['message' => 'paket created successfully', 'paket' => $paket]);
    }

    // Menampilkan paket berdasarkan ID
    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view("paket.editPaket", compact("paket"));
    }

    // Mengupdate paket
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $validated = $request->validate([
            'nama_paket' => 'nullable|string|max:255',
            // 'description' => 'nullable|string',
            // 'price' => 'nullable|numeric|min:0',
            // 'speed' => 'nullable|string|max:50',
            'status' => 'nullable|boolean',
            // 'discount' => 'nullable|numeric|min:0|max:10',
        ]);

        $paket->update($validated);
        return response()->json(['message' => 'paket updated successfully', 'paket' => $paket]);
    }

    // Menghapus paket
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return response()->json(['message' => 'paket deleted successfully']);
    }
}
