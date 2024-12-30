@extends('layouts.main')

@section('content')
<style>
  #map {
    z-index: 1;
    /* Map di bawah */
    position: relative;
  }
</style>

<div class=" gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">

      <div class="flex justify-end">

        <div>

          <a href="javascript:history.back()"
            class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
            Back
          </a>
        </div>

      </div>
      <div class="bg-white  p-4 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
        <div
          class="bg-white grid lg:grid-cols-2 sm:grid-cols-1 items-center shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] w-full max-w-full mx-auto rounded-lg font-[sans-serif] overflow-hidden">

          <!-- Map Section -->
          <div class="w-full h-[300px] lg:h-[400px] relative">
            <div id="map" class="absolute inset-0 w-full h-full rounded-lg"></div>
          </div>

          <div class="p-6 lg:p-8 bg-white rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800">{{ $olt->olt_name }}</h3>

            <div class="mt-4">

                <p class="mt-2 text-sm text-gray-600"><strong>Deskripsi:</strong> {{ $olt->olt_description }}</p>
                <p class="mt-2 text-sm text-gray-600"><strong>Alamat:</strong> {{ $olt->olt_addres }}</p>
                <p class="mt-2 text-sm text-gray-600"><strong>Lokasi:</strong> {{ $olt->olt_location_maps }}</p>
                <p class="mt-2 text-sm text-gray-600"><strong>Kapasitas Port:</strong> {{ $olt->olt_port_capacity }}</p>
            </div>
            <br>
            <hr>
            <br>
            <h4 class="text-xl font-bold text-gray-800">Daftar Port</h4>
            <table class="min-w-full table-auto mt-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-gray-600">PON</th>
                        <th class="px-4 py-2 text-left text-gray-600">Status</th>
                        <th class="px-4 py-2 text-left text-gray-600">Direction</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($olt->ports as $port)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $port->port_number }}</td>
                            <td class="px-4 py-2">{{ $port->status }}</td>
                            <td class="px-4 py-2">{{ $port->directions }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <!-- Port List -->

        </div>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Ambil koordinat dari database
    var coordinates = @json($olt->olt_location_maps); // Format: "latitude,longitude"
    var nameOlt = @json($olt->olt_name);

    // Pecah koordinat menjadi latitude dan longitude
    var coordsArray = coordinates.split(',');

    var latitude = parseFloat(coordsArray[0]);
    var longitude = parseFloat(coordsArray[1]);

    // Inisialisasi peta
    var map = L.map('map').setView([latitude, longitude], 16); // Koordinat dari DB

    // Tambahkan tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Buat URL untuk membuka koordinat di Google Maps
    var googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;

    // Buat ikon khusus menggunakan gambar
    var customIcon = L.icon({
      iconUrl: 'https://uhuy.fiberone.net.id/OLT5.png',  // URL gambar ikon
       iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
    });

    // Tambahkan marker dengan ikon khusus
    var marker = L.marker([latitude, longitude], { icon: customIcon }).addTo(map);

    // Buat popup untuk marker
    var popupContent = `
      <b>${nameOlt}</b><br>
      <a href="${googleMapsUrl}" target="_blank" class="text-blue-500">Buka di Google Maps</a>
    `;

    // Event hover untuk menampilkan popup dengan link ke Google Maps
    marker.on('mouseover', function() {
      marker.bindPopup(popupContent).openPopup();
    });

    // Event klik untuk toggle popup
    var popupOpen = false;  // Variabel untuk melacak apakah popup sudah terbuka

    marker.on('click', function() {
      if (popupOpen) {
        marker.closePopup();  // Jika popup terbuka, tutup popup
      } else {
        marker.bindPopup(popupContent).openPopup();  // Jika popup belum terbuka, buka popup
      }
      popupOpen = !popupOpen;  // Toggle status popup
    });
  });
</script>

@endsection
