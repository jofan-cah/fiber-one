@extends('layouts.main')

@section('content')
<script src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
<style>
  #network {
    width: 100%;
    height: 600px;
    border: 1px solid lightgray;
  }
</style>


<div class=" gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">

      <div id="network"></div>

    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('network');
    const options = {
      nodes: {
        shape: 'box',
        font: { size: 14 },
        borderWidth: 2,
      },
      edges: {
        arrows: { to: { enabled: true, scaleFactor: 0.5 } },
        color: { color: '#848484', hover: '#ff6b6b' },
        smooth: { type: 'continuous' },
      },
      groups: {
        OLT: { color: { background: '#ff6b6b' } },
        ODC: { color: { background: '#4dabf7' } },
        ODP: { color: { background: '#f39c12' } },
        Subs: { color: { background: '#2ecc71' } },
      },
      physics: {
        enabled: true,
        solver: 'forceAtlas2Based', // Menggunakan solver yang lebih baik untuk jarak node
        forceAtlas2Based: {
          gravitationalConstant: -50, // Mengatur gaya tarik menarik antar node
          centralGravity: 0.005, // Mengatur gravitasi pusat
          springLength: 200, // Mengatur panjang pegas (jarak antar node)
          springConstant: 0.08, // Kekakuan pegas
        },
        stabilization: {
          enabled: true,
          iterations: 200, // Iterasi stabilisasi untuk memastikan posisi stabil
          updateInterval: 50,
        },
      },
      layout: {
        improvedLayout: true, // Menambahkan perbaikan layout untuk mencegah tumpang tindih
        hierarchical: false, // Tidak menggunakan layout hierarkis
      },
    };

    // Fetch topology data
    fetch('/site/topology-data')
      .then((response) => response.json())
      .then((data) => {
        const network = new vis.Network(container, data, options);

        // Event listener untuk mencegah node menumpuk saat stabilisasi
        network.on("stabilized", function () {
          console.log("Network stabilized");
        });
      })
      .catch((error) => console.error('Error fetching topology data:', error));
  });
</script>



@endsection