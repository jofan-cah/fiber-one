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
        margin: 20,  // Menambahkan jarak antar node lebih banyak
      },
      edges: {
        arrows: { to: { enabled: true, scaleFactor: 0.5 } },
        color: { color: '#848484', hover: '#ff6b6b' },
        smooth: { type: 'continuous' }
      },
      groups: {
        OLT: { color: { background: '#ff6b6b' } },
        ODC: { color: { background: '#4dabf7' } },
        ODP: { color: { background: '#f39c12' } },
        Subs: { color: { background: '#2ecc71' } }
      },
      physics: {
        enabled: false, // Mematikan fisika agar node lebih statis
      },
      layout: {
        hierarchical: {
          enabled: true,  // Mengaktifkan layout hierarkis untuk mencegah tumpang tindih
          levelSeparation: 150,  // Menambah jarak antar level
          nodeSpacing: 200,  // Menambah jarak antar node
          treeSpacing: 300,  // Menambah jarak antar cabang pohon
          direction: 'UD',  // Menuju arah atas ke bawah (Up-Down)
          sortMethod: 'directed'  // Menjaga urutan yang lebih teratur
        },
        randomSeed: 2,  // Tentukan seed random untuk posisi node
        improvedLayout: true,  // Mengaktifkan layout yang lebih baik untuk mencegah node bertumpuk
      }
    };

    // Fetch topology data
    fetch('/site/topology-data')
      .then(response => response.json())
      .then(data => {
        const network = new vis.Network(container, data, options);
      })
      .catch(error => console.error('Error fetching topology data:', error));
  });
</script>



@endsection