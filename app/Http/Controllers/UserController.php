<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        $userLevel = UserLevel::all();
        return view('users.userCreate', compact('userLevel'));
    }

    public function getAllData()
    {
        $users = User::with('userLevel')->get(); // Menggunakan get() untuk mendapatkan data
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'user_level_id' => 'required|exists:user_levels,user_level_id',
        ]);
        // Menghasilkan ID pengguna baru
        $userId = $this->generateUserId();


        $user = User::create([
            'user_id' =>  $userId,
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_level_id' => $request->user_level_id,
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'full_name' => 'sometimes|required',
            'username' => 'sometimes|required|unique:users,username,' . $id . ',user_id',
            'email' => 'sometimes|required|email|unique:users,email,' . $id . ',user_id',
            'password' => 'nullable|min:6',
            'user_level_id' => 'sometimes|required|exists:user_levels,user_level_id',
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui hanya data yang valid
        $dataToUpdate = $request->only(['full_name', 'username', 'email', 'user_level_id']);

        // Jika password diisi, hash dan Addkan ke data yang akan diperbarui
        if ($request->filled('password')) {
            $dataToUpdate['password'] = bcrypt($request->password);
        }

        // Lakukan pembaruan
        $user->update($dataToUpdate);

        // Backkan respons
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }


    // show user by id 
    public function show($id)
    {
        $user = User::find($id);
        $userLevel = UserLevel::all();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return view('users.editUser', compact('user', 'userLevel'));
    }

    function generateUserId()
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
        $lastUser = User::whereDate('created_at', $today)->latest('created_at')->first();

        // Tentukan nomor urut berdasarkan urutan terakhir atau mulai dari 1 jika belum ada
        $counter = $lastUser ? (intval(substr($lastUser->user_id, -3)) + 1) : 1;

        // Pastikan nomor urut selalu 3 digit
        $counterFormatted = str_pad($counter, 3, '0', STR_PAD_LEFT);

        // Gabungkan semuanya menjadi ID pengguna
        $userId = "USR{$year}{$month}{$day}{$counterFormatted}";

        return $userId;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
