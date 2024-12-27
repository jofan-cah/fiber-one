@extends('layouts.main')

@section('content')
<!-- Selamat Datang -->
<div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white p-6 rounded-lg shadow-lg mb-6">
    <h1 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->full_name }}!</h1>
    <p class="mt-2 text-sm">Kami senang melihat Anda kembali. Berikut adalah ringkasan data terbaru Anda.</p>
</div>

<!-- Statistik Dashboard -->
<div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-6">
    <!-- Total OLT -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
        <div class="text-5xl">
            <i class="fas fa-network-wired"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold">Total OLT</h2>
            <p class="mt-2 text-3xl font-extrabold">{{ $totalOLT }}</p>
        </div>
    </div>

    <!-- Total ODP -->
    <div class="bg-gradient-to-r from-green-500 to-green-700 text-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
        <div class="text-5xl">
            <i class="fas fa-server"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold">Total ODP</h2>
            <p class="mt-2 text-3xl font-extrabold">{{ $totalODP }}</p>
        </div>
    </div>

    <!-- Total ODC -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
        <div class="text-5xl">
            <i class="fas fa-database"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold">Total ODC</h2>
            <p class="mt-2 text-3xl font-extrabold">{{ $totalODC }}</p>
        </div>
    </div>

    <!-- Total Subscriptions -->
    <div class="bg-gradient-to-r from-pink-500 to-pink-700 text-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
        <div class="text-5xl">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold">Total Pelanggan</h2>
            <p class="mt-2 text-3xl font-extrabold">{{ $totalSubscriptions }}</p>
        </div>
    </div>
</div>
@endsection
