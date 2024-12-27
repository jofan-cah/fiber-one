@extends('layouts.main')

@section('content')
<style>
  #map {
    z-index: 1;
    /* Map di bawah */
    position: relative;
  }
</style>

<style>
  .tab-button.active {
    color: #1a56db;
    border-bottom: 2px solid #1a56db;
  }
  
  .tab-pane {
    display: none;
  }
  
  .tab-pane.active {
    display: block;
  }
  </style>




<div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-end">
      <div>
        <a href="javascript:history.back()" class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
          Back
        </a>
      </div>
    </div>
    
    <div class="bg-white p-4 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
      <div class="border-b border-gray-200 dark:border-gray-700 my-4">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
          <li class="me-2">
            <button class="tab-button inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 active" data-tab="detail">
              <svg class="w-4 h-4 me-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
            </svg>Detail
            </button>
          </li>
          <li class="me-2">

            <button class="tab-button inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" data-tab="pelanggan">
              <svg class="w-4 h-4 me-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
            </svg>Pelanggan
            </button>
          </li>
        </ul>
      </div>
      
      <!-- Tab Content -->
      <div class="tab-content">
        <div id="detail" class="tab-pane active">
          <!-- Detail Content -->
          <div class="bg-white grid lg:grid-cols-2 sm:grid-cols-1 items-center shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] w-full max-w-full mx-auto rounded-lg font-[sans-serif] overflow-hidden">
        
            <!-- Map Section -->
            <div class="w-full h-[300px] lg:h-[400px] relative">
              <div id="map" class="absolute inset-0 w-full h-full rounded-lg"></div>
            </div>
        
            <!-- Content Section -->
            <div class="p-6 lg:p-8 bg-white rounded-lg">
              <h3 class="text-2xl font-bold text-gray-800">{{$odp->odp_name }}</h3>
        
              <div class="mt-4">
                <p class="text-sm text-gray-600"><strong>ODP ID:</strong> {{$odp->odp_id }}</p>
                <p class="mt-2 text-sm text-gray-600"><strong>Deskripsi:</strong> {{$odp->odp_description }}</p>
                <p class="mt-2 text-sm text-gray-600"><strong>Alamat:</strong> {{$odp->odp_addres }}</p>
                <p class="mt-2 text-sm text-gray-600"><strong>Lokasi:</strong> {{$odp->odp_location_maps }}</p>
                <p class="mt-2 text-sm text-gray-600"><strong>Kapasitas Port:</strong> {{ $availablePorts ?? 0 }} / {{$odp->odp_port_capacity }}</p>
              </div>
        
              <hr class="my-4">
        
              <div class="mt-4">
                <p class="text-sm text-gray-600"><strong>Informasi Lainnya:</strong></p>
                <ul class="list-disc pl-5 text-sm text-gray-600">
                  <li>Port yang tersedia: {{ $availablePorts ?? 0 }}</li>
                  <li>Total kapasitas: {{ $odp->odp_port_capacity }}</li>
                  <!-- Tambahkan informasi lain jika diperlukan -->
                </ul>
              </div>
            </div>
        
          </div>
        </div>
        
        <div id="pelanggan" class="tab-pane hidden">
          <div class="overflow-x-auto mt-6">
            <table class="min-w-full border-collapse border border-gray-200 shadow-lg rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">Subscription ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">Subscription Name</th>
                    
                        <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">ODP Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">Port</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($odc as $index => $subscription)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $subscription->subs_id }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $subscription->subs_name }}</td>
                          
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $subscription->odp->odp_name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $subscription->port }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
       
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.tab-button');
  const tabPanes = document.querySelectorAll('.tab-pane');

  function switchTab(tabId) {
    // Remove active class from all buttons and panes
    tabButtons.forEach(button => button.classList.remove('active'));
    tabPanes.forEach(pane => pane.classList.remove('active', 'block'));
    tabPanes.forEach(pane => pane.classList.add('hidden'));

    // Add active class to selected button and pane
    const selectedButton = document.querySelector(`[data-tab="${tabId}"]`);
    const selectedPane = document.getElementById(tabId);
    
    selectedButton.classList.add('active');
    selectedPane.classList.remove('hidden');
    selectedPane.classList.add('active', 'block');
  }

  // Add click handlers to all tab buttons
  tabButtons.forEach(button => {
    button.addEventListener('click', () => {
      const tabId = button.getAttribute('data-tab');
      switchTab(tabId);
    });
  });

  // Set default active tab
  switchTab('detail');
});
</script>

</script>


<script>
  

  document.addEventListener("DOMContentLoaded", function() {
    // Ambil koordinat dari database
    var coordinates = @json($odp->odp_location_maps); // Format: "latitude,longitude"
    var nameOlt = @json($odp->odp_name);

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

    // Tambahkan marker
    var marker = L.marker([latitude, longitude]).addTo(map);

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