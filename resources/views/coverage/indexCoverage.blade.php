@extends('layouts.main')

@section('content')
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
        <p class="text-lg font-medium text-slate-500 tracking-wider">Coverage Maps</p>
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center">
                <input id="user-coor"
                    class="my-4 p-2 block text-sm border focus:outline-none focus:border-sky-500 focus:ring-sky-500 border-gray-300 rounded-lg cursor-pointer bg-gray-50 w-[300px]"
                    type="text" name="test_result" placeholder="Cari berdasarkan coordinate...">
                <button id="find"
                    class="mx-2 px-4 h-9 text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm text-center">Find</button>
                <button id="gps"
                    class="px-4 h-9 text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm text-center">GPS</button>
            </div>

            <!-- Routing Container -->
            <div id="routing-container"
                class="routing-instructions p-4 border rounded-lg bg-gray-50 shadow-md w-[400px]">
                <!-- Content for routing -->
                <p class="text-sm text-gray-700">Routing instructions will appear here.</p>
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
                            icon: createMarkerIconUrl('https://uhuy.fiberone.net.id/ODPTOSCA.png')
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