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
      smooth: { type: 'continuous' }
    },
    groups: {
      OLT: { color: { background: '#ff6b6b' } },
      ODC: { color: { background: '#4dabf7' } },
      ODP: { color: { background: '#f39c12' } },
      Subs: { color: { background: '#2ecc71' } }
    },
    physics: {
      enabled: true,
      solver: 'barnesHut',
      stabilization: { iterations: 200 }
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