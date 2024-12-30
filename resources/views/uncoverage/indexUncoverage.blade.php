@extends('layouts.main')

@section('content')
<!-- Script -->
<script>
  function toggleModal() {
          const modal = document.getElementById('modal');
          modal.classList.toggle('hidden');
        }
</script>
<style>
  #map {
    height: 500px;
    width: 100%;
    z-index: 1;
  }

  .routing-instructions {
    padding: 10px;
    margin: 10px 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    max-height: 150px;
    overflow-y: auto;
  }

  /* Hide the default routing container that appears on map */
  .leaflet-routing-container {
    display: none;
  }
</style>
<div class="gap-6">
  <div class="p-4 bg-white rounded-md shadow-lg w-full overflow-x-auto">
    <div class="justify-between mb-4 flex items-center">
      <p class="text-lg font-medium text-slate-500 tracking-wider">UnCoverage Maps</p>
      <!-- Button to open the modal -->
      <button
        class="px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        onclick="toggleModal()">
        Create Uncover
      </button>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
      <div class="bg-white rounded-lg shadow-lg max-w-lg w-full">
        <!-- Modal header -->
        <div class="flex justify-between items-center px-4 py-2 border-b">
          <h2 class="text-lg font-medium text-gray-700">Create Uncover</h2>
          <button class="text-gray-400 hover:text-gray-600" onclick="toggleModal()">
            &times;
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4">
          <form id="uncoverForm" action="{{ route('storeUncoverage') }}" method="POST">
            <!-- CSRF Token -->
            @csrf
            <!-- Nama Subs -->
            <div class="mb-4">
              <label for="nama_subs" class="block text-sm font-medium text-gray-700">Nama Subs</label>
              <input type="text" id="nama_subs" name="nama_subs" required
                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- No HP -->
            <div class="mb-4">
              <label for="no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
              <input type="text" id="no_hp" name="no_hp" required
                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- Maps Locations -->
            <div class="mb-4">
              <label for="maps_locations" class="block text-sm font-medium text-gray-700">Maps Locations</label>
              <input type="text" id="maps_locations" name="maps_locations" required
                placeholder="Masukan Longtitude dan Latitude"
                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            </div>
          </form>
        </div>
        <!-- Modal footer -->
        <div class="flex justify-end items-center px-4 py-2 border-t">
          <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400" onclick="toggleModal()">
            Cancel
          </button>
          <button class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
            onclick="document.getElementById('uncoverForm').submit()">
            Save
          </button>
        </div>
      </div>
    </div>
    <div id="map" class="h-[400px] z-0"></div>
  </div>
</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script>
  // Fungsi untuk mendapatkan alamat dari koordinat
        async function getAddress(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                const data = await response.json();
                return data.display_name;
            } catch (error) {
                console.error('Error getting address:', error);
                return 'Alamat tidak ditemukan';
            }
        }
            function createMarkerIcon(color) {
                return new L.Icon({
                    iconUrl: 'https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-2x-' +
                        color +
                        '.png',
                    iconSize: [20, 30], // Ukuran kecil dan proporsional
                    iconAnchor: [10, 30], // Anchor untuk memastikan titik bawah icon sesuai
                    popupAnchor: [0, -25], // Posisi popup agar sejajar dengan marker
                });
            }

              // Fungsi untuk membuat ikon dengan URL ikon spesifik
            function createMarkerIconUrl(iconUrl) {
            return new L.Icon({
                iconUrl: iconUrl,
                iconSize: [40, 55],
                iconAnchor: [35, 50],
                popupAnchor: [1, -34],
            });
            }

            function findCoorNearestMaker(coorMarkers, coorLocation) {
                if (!coorMarkers || coorMarkers.length === 0) {
                    return null; // Return null jika tidak ada marker
                }

                // Fungsi untuk menghitung jarak Euclidean antara dua koordinat
                function getDistance(coor1, coor2) {
                    const lat1 = coor1[0];
                    const lon1 = coor1[1];
                    const lat2 = coor2[0];
                    const lon2 = coor2[1];

                    const dLat = lat2 - lat1;
                    const dLon = lon2 - lon1;

                    return Math.sqrt(dLat * dLat + dLon * dLon);
                }
                // Inisialisasi marker terdekat dan jarak awal
                let nearestMarker = coorMarkers[0];
                let nearestDistance = getDistance(coorLocation, coorMarkers[0]);

                // Iterasi melalui semua marker dan perbarui marker terdekat jika ditemukan yang lebih dekat
                for (let i = 1; i < coorMarkers.length; i++) {
                    const currentMarker = coorMarkers[i];
                    const distance = getDistance(coorLocation, currentMarker);

                    if (distance < nearestDistance) {
                        nearestMarker = currentMarker;
                        nearestDistance = distance;
                    }
                }
                return nearestMarker;
            }

            // Inisialisasi peta
            var map = L.map('map').setView([-7.710826, 110.605360], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            var coordinate = [];

              // Pengecekan hak akses
              const userRole = '{{ Auth::user()->user_level_id }}'; // Pastikan ini mendapatkan role pengguna

                $.ajax({
                    url: "{{ route('getOdp') }}",
                    type: "GET"
                }).then((result) => {
                    result.forEach(odpSite => {
                        console.log(odpSite);
                        let odp = [];
                        if (odpSite.odp_location_maps.includes(", ")) {
                            odp = odpSite.odp_location_maps.split(', ');
                        } else {
                            odp = odpSite.odp_location_maps.split(',');
                        }
                        let odpMarker = L.marker([odp[0], odp[1]], {
                            icon: createMarkerIconUrl('https://uhuy.fiberone.net.id/ODPIJO2.png')
                        }).addTo(map);
                        // Menambahkan popup hanya untuk Admin/Kordinator
                        if (userRole === 'LVL250101001' || userRole === 'LVL241219001') {
                        odpMarker.bindPopup(
                        "<strong>ODP Terdekat:</strong> " + odpSite.odp_name +
                        "<br><a style='margin-top: 1rem' href='http://www.google.com/maps/place/" +
                                            odp[0] + "," + odp[1] +
                                            "' target='__blank'>Go to Google Maps</a>"
                        );
                        }
                        coordinate.push([odp[0], odp[1]]);
                    });
                }).catch((err) => {
                    console.log(err);
                });


                 $.ajax({
                      url: "{{ route('getMapsLocations') }}",
                      type: "GET"
                  }).then((result) => {
                      result.forEach(location => {
                          let coordinates = [];
                          if (location.maps_locations.includes(", ")) {
                              coordinates = location.maps_locations.split(', ');
                          } else {
                              coordinates = location.maps_locations.split(',');
                          }

                          // Buat marker untuk lokasi rumah
                          let homeMarker = L.marker([coordinates[0], coordinates[1]], {
                              icon: L.icon({
                                  iconUrl: 'https://cdn.icon-icons.com/icons2/2237/PNG/512/home_safety_protection_real_estate_icon_134776.png',
                                iconSize: [40, 55],
                                  iconAnchor: [35, 50],
                                  popupAnchor: [0, -32] // posisi popup relatif terhadap icon
                              })
                          }).addTo(map);

                          // Tambahkan popup
                          homeMarker.bindPopup(
                              "<strong> Rumah:</strong> " + location.nama_subs + "/"
                              + location.no_hp  +
                              "<br><a href='http://www.google.com/maps/place/" +
                              coordinates[0] + "," + coordinates[1] +
                              "' target='_blank'>Go to Google Maps</a>"
                          );
                      });
                  }).catch((err) => {
                      console.error(err);
                  });

            let userCoor = $('#user-coor');
            let btnFind = $('#find');
            let btnGps = $('#gps');
            let regexCoor = /^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/
            let userMarker = L.marker([0, 0], {
                icon: createMarkerIcon('blue'),
                draggable: true
            }).addTo(map);

            // Buat marker berbeda untuk titik A dan B
            let markerA = null;
            let markerB = null;

            // Modifikasi routing control
            let route = L.Routing.control({
                show: false,
                containerClassName: 'display-none',
                createMarker: function(i, waypoint, n) {
                    // i adalah index waypoint (0 untuk start, 1 untuk end)
                    if (i === 0) {
                        // Hapus marker A yang lama jika ada
                        if (markerA) {
                            map.removeLayer(markerA);
                        }
                        // Buat marker A baru (warna merah)
                        markerA = L.marker(waypoint.latLng, {
                            icon: createMarkerIconUrl('https://cdn.icon-icons.com/icons2/2237/PNG/512/home_safety_protection_real_estate_icon_134776.png'),
                            draggable: true
                        }).bindPopup('Titik Rumah Customer');
                        return markerA;
                    } else {
                        // Hapus marker B yang lama jika ada
                        if (markerB) {
                            map.removeLayer(markerB);
                        }
                        // Buat marker B baru (warna blue)
                        markerB = L.marker(waypoint.latLng, {
                            icon: createMarkerIcon('blue'),
                            draggable: true
                        }).bindPopup('Titik B (Tujuan)');
                        return markerB;
                    }
                },
                lineOptions: {
                    styles: [{ color: '#03f', opacity: 0.7, weight: 5 }]
                }
            }).addTo(map);
            route.addTo(map);

            // Modifikasi event listener routing
            route.on('routesfound', async function(e) {
                let routes = e.routes;
                let summary = routes[0].summary;

                // Dapatkan koordinat awal dan akhir
                const startPoint = routes[0].coordinates[0];

                // Dapatkan alamat untuk kedua titik
                const startAddress = await getAddress(startPoint.lat, startPoint.lng);


                // Format dan tampilkan informasi rute
                let routingHtml = `
                    <div class="routing-info">
                        <p><strong>Alamat Rumah:</strong> ${startAddress}</p>
                        <p><strong>Jarak:</strong> ${(summary.totalDistance)} m</p>
                    </div>
                `;

                $('#routing-container').html(routingHtml);
            });

            let coorNearest
            btnFind.on('click', function() {
                if (regexCoor.test(userCoor.val())) {
                    let coor = userCoor.val().split(',');
                    coorNearest = findCoorNearestMaker(coordinate, coor);
                    route.setWaypoints([
                        L.latLng(coor[0], coor[1]),
                        L.latLng(coorNearest[0], coorNearest[1])
                    ] );
                    route.show();
                }
            });

            btnGps.on('click', function() {
                const gps = map.locate({setView: true, maxZoom: 16})._lastCenter;
                coorNearest = findCoorNearestMaker(coordinate, [gps.lat, gps.lng]);
                route.setWaypoints([
                    L.latLng(gps.lat, gps.lng),
                    L.latLng(coorNearest[0], coorNearest[1])
                ] );
                route.show();
            })
</script>
@endsection
