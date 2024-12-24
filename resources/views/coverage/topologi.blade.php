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
        solver: 'barnesHut',
        barnesHut: {
          gravitationalConstant: -2000, // Mengurangi kemungkinan tumpang tindih
          centralGravity: 0.3, // Menjaga node tetap terpusat tetapi dengan ruang
          springLength: 250, // Jarak minimum antar node
          springConstant: 0.04,
          avoidOverlap: 1, // Menghindari overlap node
        },
        stabilization: {
          enabled: true,
          iterations: 500, // Meningkatkan iterasi untuk memastikan node tidak menumpuk
        },
      },
      layout: {
        randomSeed: 42, // Memastikan layout konsisten
        improvedLayout: true,
      },
    };

    // Fetch topology data
    fetch('/site/topology-data')
      .then((response) => response.json())
      .then((data) => {
        const network = new vis.Network(container, data, options);

        // Event listener untuk melihat apakah jaringan sudah stabil
        network.on('stabilized', () => {
          console.log('Network layout stabilized.');
        });

        // Atur ulang posisi node untuk memastikan jarak antar node cukup
        network.on('afterDrawing', () => {
          const positions = network.getPositions();
          const newPositions = {};
          const padding = 50; // Menambahkan jarak minimum antar node
          for (const [nodeId, position] of Object.entries(positions)) {
            newPositions[nodeId] = {
              x: position.x + Math.random() * padding,
              y: position.y + Math.random() * padding,
            };
          }
          network.setData({ nodes: data.nodes, edges: data.edges }); // Reset posisi untuk mengurangi tumpang tindih
        });
      })
      .catch((error) => console.error('Error fetching topology data:', error));
  });
</script>



@endsection