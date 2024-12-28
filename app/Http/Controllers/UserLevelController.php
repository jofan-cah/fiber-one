<?php

namespace App\Http\Controllers;

use App\Models\UserLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserLevelController extends Controller
{
    // Menampilkan daftar User Levels
    public function index()
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        $userLevels = UserLevel::all();
        return view('usersLevel.index', compact('userLevels'));
    }

    // Menampilkan daftar User Levels
    public function getAllData()
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        $userLevels = UserLevel::all();
        return response()->json(
            $userLevels
        );
    }

    // Menampilkan form untuk menambahkan User Level baru
    public function create()
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        return view('usersLevel.createUserLevel');
    }

    public function store(Request $request)
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        // Validasi data input
        $request->validate([
            'user_name' => 'required|unique:user_levels,user_name',
            'user_description' => 'nullable|string',
        ]);

        // Sanitasi input untuk menghindari XSS
        $userLevelName = strip_tags($request->user_name); // Menghapus tag HTML
        $userLevelDescription = htmlspecialchars($request->user_description, ENT_QUOTES, 'UTF-8'); // Mengkonversi karakter khusus
        $userLvlId = $this->generateUserLevelId();

        $userLevel = UserLevel::create([
            'user_level_id' =>
            $userLvlId,
            'user_name' => $userLevelName,
            'user_description' => $userLevelDescription,
        ]);
        logActivity('create', Auth::user()->full_name .' Created a new UserLevel with ID: ' . $userLvlId);


        return response()->json([
            'message' => 'User created successfully',
            'user' => $userLevel,
        ]);
    }

    // Mengupdate data User Level yang sudah ada
    public function update(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        // Validasi data input
        $request->validate([
            'user_name' => 'required|unique:user_levels,user_name,' .  $id . ',user_level_id',
            'user_description' => 'nullable|string',
        ]);

        // Sanitasi input untuk menghindari XSS
        $userLevelName = strip_tags($request->user_name); // Menghapus tag HTML
        $userLevelDescription = htmlspecialchars($request->user_description, ENT_QUOTES, 'UTF-8'); // Mengkonversi karakter khusus

        // Mencari dan memperbarui user level
        $userLevel = UserLevel::findOrFail($id);
        $userLevel->update([
            'user_name' => $userLevelName,
            'user_description' => $userLevelDescription,
        ]);
        logActivity('update', Auth::user()->full_name .' Updated a new UserLevel with ID: ' . $id);


        return response()->json([
            'message' => 'User updated successfully',
            'user' => $userLevel,
        ]);
    }

    // Menampilkan form untuk mengedit User Level
    public function edit($id)
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        $userLevel = UserLevel::findOrFail($id);
        return view('usersLevel.edit', compact('userLevel'));
    }

    // Menghapus User Level
    public function destroy($id)
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        $userLevel = UserLevel::findOrFail($id);
        $userLevel->delete();
        logActivity('delete', Auth::user()->full_name .' Deleted a new UserLevel with ID: ' . $id);
        return response()->json(
            [
                'message' => 'User deleted successfully'
            ],
            200
        );
    }

    function generateUserLevelId()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();

        // Format tahun (2 digit terakhir)
        $year = $today->format('y'); // Contoh: 24 untuk 2024

        // Format bulan (2 digit)
        $month = $today->format('m'); // Contoh: 12 untuk Desember

        // Format hari (2 digit)
        $day = $today->format('d'); // Contoh: 01 untuk tanggal 1

        // Ambil urutan terakhir untuk hari tersebut
        $lastUser = UserLevel::whereDate('created_at', $today)->latest('created_at')->first();

        // Tentukan nomor urut berdasarkan urutan terakhir atau mulai dari 1 jika belum ada
        $counter = $lastUser ? (intval(substr($lastUser->user_level_id, -3)) + 1) : 1;

        // Pastikan nomor urut selalu 3 digit
        $counterFormatted = str_pad($counter, 3, '0', STR_PAD_LEFT);

        // Gabungkan semuanya menjadi ID pengguna
        $userId = "LVL{$year}{$month}{$day}{$counterFormatted}";

        return $userId;
    }

    // show user by id
    public function show($id)
    {
        $userLevel = UserLevel::find($id);
        if (!$userLevel) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return view('usersLevel.editUserLevel', compact('userLevel'));
    }
}
