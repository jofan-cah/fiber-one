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
      margin: 20,
      widthConstraint: {
        minimum: 100
      },
      fixed: {
        x: false,     // Lock horizontal position
        y: false     // Allow vertical movement
      }
    },
    edges: {
      arrows: { to: true },
      smooth: {
        type: 'straightCross',
        roundness: 0.2
      }
    },
    groups: {
      OLT: { color: { background: '#ff6b6b' } },
      ODC: { color: { background: '#4dabf7' } },
      ODP: { color: { background: '#f39c12' } },
      Subs: { color: { background: '#2ecc71' } }
      },
    layout: {
      improvedLayout: true,
      hierarchical: {
        enabled: true,
        direction: 'UD',
        sortMethod: 'directed',
        levelSeparation: 200,
        nodeSpacing: 250,
        treeSpacing: 300
      }
    },
    physics: {
      enabled: true,
      hierarchicalRepulsion: {
        nodeDistance: 200,    // Minimum distance between nodes
        centralGravity: 0.1,  // How much nodes are attracted to their level
        springLength: 200,    // Preferred edge length
        springConstant: 0.01, // How much edges pull nodes together
        damping: 0.5         // Damping factor for node movement
      },
      solver: 'hierarchicalRepulsion'
    },
    interaction: {
      dragNodes: true,        // Enable node dragging
      dragView: true,         // Enable view dragging
      zoomView: true,         // Enable zooming
      hover: true,
      multiselect: true      // Allow selecting multiple nodes
    },
    manipulation: {
      enabled: false         // Disable editing capabilities
    }
  };

  // Fetch data and create network
  fetch('/site/topology-data')
    .then(response => response.json())
    .then(data => {
      const network = new vis.Network(container, data, options);
      
      // Event saat node mulai di-drag
      network.on("dragStart", function (params) {
        if (params.nodes.length > 0) {
          // Lock horizontal position while dragging
          params.nodes.forEach(nodeId => {
            const node = network.body.nodes[nodeId];
            if (node) {
              node.options.fixed.x = true;
              node.options.fixed.y = false;
            }
          });
        }
      });

      // Event saat drag selesai
      network.on("dragEnd", function (params) {
        // Maintain the vertical position but snap back horizontally
        network.setOptions({physics: {enabled: true}});
      });

      network.once('afterDrawing', () => {
        network.fit();
      });
    })
    .catch(error => console.error('Error:', error));
});
</script>


@endsection