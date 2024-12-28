@extends('layouts.main')

@section('content')
<script src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
<style>
  #network {
    width: 100%;
    height: 600px;
    border: 1px solid lightgray;
  }

  #tooltip {
    position: absolute;
    display: none;
    background: white;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    pointer-events: none;
    transform: translate(-50%, -100%);
  }
</style>

<div class="gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">
      <div id="network"></div>
      <div id="tooltip"></div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('network');
      const tooltip = document.getElementById('tooltip');

      const options = {
        nodes: {
          shape: 'box',
          font: { size: 14 },
          margin: 20,
          widthConstraint: { minimum: 100 },
          fixed: { x: false, y: false }
        },
        edges: {
          arrows: { to: true },
          font: {
            align: 'middle',
            size: 12,
            color: '#343a40',
            vadjust: -10
          },
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
            nodeDistance: 200,
            centralGravity: 0.1,
            springLength: 200,
            springConstant: 0.01,
            damping: 0.5
          },
          solver: 'hierarchicalRepulsion'
        },
        interaction: {
          dragNodes: true,
          dragView: true,
          zoomView: true,
          hover: true,
          multiselect: true
        },
        manipulation: {
          enabled: false
        }
      };

      // Fetch data and create network
      fetch('/site/topology-data')
        .then(response => response.json())
        .then(data => {
          const network = new vis.Network(container, data, options);

          // Show tooltip on node hover
          network.on('hoverNode', function (params) {
            const nodeId = params.node;
            const node = data.nodes.find(n => n.id === nodeId);

            if (node) {
              tooltip.innerHTML = `
                <strong>${node.label}</strong><br>
                Group: ${node.group}<br>
                ID: ${node.id} <br>
                Spllitter: ${node.splliter}
              `;

              // Dapatkan posisi node di canvas
              const nodePosition = network.getPosition(nodeId);
              // Konversi posisi canvas ke posisi DOM
              const domPosition = network.canvasToDOM(nodePosition);

              tooltip.style.display = 'block';
              tooltip.style.left = `${domPosition.x}px`;
              tooltip.style.top = `${domPosition.y}px`;
            }
          });

          // Hide tooltip when mouse leaves node
          network.on('blurNode', function () {
            tooltip.style.display = 'none';
          });

          // Hide tooltip when dragging
          network.on('dragStart', function () {
            tooltip.style.display = 'none';
          });

          // Update tooltip position when dragging or zooming
          network.on('afterDrawing', function() {
            const tooltipNode = tooltip.getAttribute('data-node');
            if (tooltipNode && tooltip.style.display !== 'none') {
              const nodePosition = network.getPosition(tooltipNode);
              const domPosition = network.canvasToDOM(nodePosition);
              tooltip.style.left = `${domPosition.x}px`;
              tooltip.style.top = `${domPosition.y}px`;
            }
          });

          network.once('afterDrawing', () => {
            network.fit();
          });
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
