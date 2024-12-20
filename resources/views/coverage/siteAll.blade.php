@extends('layouts.main')

@section('content')
<div class="gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-2xl font-bold mb-6 text-gray-800">Fiber One </h1>
      <div id="map" class="w-full h-96 rounded-lg overflow-hidden shadow-md"></div>
    </div>
  </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi peta
    const map = L.map('map').setView([-7.710692641092517, 110.60535617120988], 14);

    // Tambahkan tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Fungsi untuk membuat ikon dengan URL ikon spesifik
    function createMarkerIcon(iconUrl) {
      return new L.Icon({
        iconUrl: iconUrl,
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
      });
    }

    // Data OLT
    const olts = @json($olts);
    olts.forEach(olt => {
      if (olt.olt_location_maps) {
        const coords = olt.olt_location_maps.split(',').map(Number);
        const googleMapsUrl = `https://www.google.com/maps?q=${coords[0]},${coords[1]}`;
        L.marker(coords, {
          icon: createMarkerIcon('https://cdn.icon-icons.com/icons2/522/PNG/512/data-add_icon-icons.com_52370.png'),
          title: `OLT: ${olt.olt_name}`,
        })
          .addTo(map)
          .bindPopup(`
            <b>OLT: ${olt.olt_name}</b><br>
            <a href="${googleMapsUrl}" target="_blank" class="text-blue-500">Buka di Google Maps</a>
          `);
      }
    });

    // Data ODC
    const odcs = @json($odcs);
    odcs.forEach(odc => {
      if (odc.odc_location_maps) {
        const coords = odc.odc_location_maps.split(',').map(Number);
        const googleMapsUrl = `https://www.google.com/maps?q=${coords[0]},${coords[1]}`;
        L.marker(coords, {
          icon: createMarkerIcon('https://cdn.icon-icons.com/icons2/585/PNG/256/HomeServer_icon-icons.com_55232.png'),
          title: `ODC: ${odc.odc_name}`,
        })
          .addTo(map)
          .bindPopup(`
            <b>ODC: ${odc.odc_name}</b><br>
            <a href="${googleMapsUrl}" target="_blank" class="text-blue-500">Buka di Google Maps</a>
          `);
      }
    });

    // Data ODP
    const odps = @json($odps);
    odps.forEach(odp => {
      if (odp.odp_location_maps) {
        const coords = odp.odp_location_maps.split(',').map(Number);
        const googleMapsUrl = `https://www.google.com/maps?q=${coords[0]},${coords[1]}`;
        L.marker(coords, {
          icon: createMarkerIcon('https://cdn.icon-icons.com/icons2/350/PNG/512/gnome-mime-x-directory-nfs-server_36146.png'),
          title: `ODP: ${odp.odp_name}`,
        })
          .addTo(map)
          .bindPopup(`
            <b>ODP: ${odp.odp_name}</b><br>
            <a href="${googleMapsUrl}" target="_blank" class="text-blue-500">Buka di Google Maps</a>
          `);
      }
    });

    // Data Subs
    const subs = @json($subs);
    subs.forEach(sub => {
      if (sub.subs_location_maps) {
        const coords = sub.subs_location_maps.split(',').map(Number);
        const googleMapsUrl = `https://www.google.com/maps?q=${coords[0]},${coords[1]}`;
        L.marker(coords, {
          icon: createMarkerIcon('https://cdn.icon-icons.com/icons2/2237/PNG/512/home_safety_protection_real_estate_icon_134776.png'),
          title: `Subs: ${sub.subs_name}`,
        })
          .addTo(map)
          .bindPopup(`
            <b>Subs: ${sub.subs_name}</b><br>
            <a href="${googleMapsUrl}" target="_blank" class="text-blue-500">Buka di Google Maps</a>
          `);
      }
    });

  });

  
</script>
@endsection