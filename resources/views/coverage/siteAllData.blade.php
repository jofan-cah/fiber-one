@extends('layouts.main')

@section('content')

<div class=" gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">
      <div class="flex space-x-4 mb-4">
        <!-- Dropdown OLT -->
        <select id="olt_filter"
          class="block w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
          <option value="">Pilih OLT</option>
          @foreach($olts as $olt)
          <option value="{{ $olt->olt_id }}">{{ $olt->olt_name }}</option>
          @endforeach
        </select>

        <!-- Dropdown ODC -->
        <select id="odc_filter"
          class="block w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          disabled>
          <option value="">Pilih ODC</option>
        </select>

        <!-- Dropdown ODP -->
        <select id="odp_filter"
          class="block w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          disabled>
          <option value="">Pilih ODP</option>
        </select>
      </div>

      <!-- Tabel Data -->
      <table id="filter-table" class="table table-bordered w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="border border-gray-300 px-4 py-2">Subs</th>
            <th class="border border-gray-300 px-4 py-2">Nama ODP</th>
            <th class="border border-gray-300 px-4 py-2">Nama ODC</th>
            <th class="border border-gray-300 px-4 py-2">Nama OLT</th>
            <th class="border border-gray-300 px-4 py-2">Port Available</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>
<div class="gap-6">


</div>

<script>
  $(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#filter-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        info: false, // Menonaktifkan informasi "Showing X to Y of Z entries"
        lengthChange: false,
        paging: false,
        ajax: {
            url: '{{ route("filterData") }}',
            data: function(d) {
                d.olt_id = $('#olt_filter').val() || null;
                d.odc_id = $('#odc_filter').val() || null;
                d.odp_id = $('#odp_filter').val() || null;
            },
           dataSrc: 'data'
        },
        columns: [
            { 
                data: 'subs_name',
               
            },
            { 
                data: 'odp_name', 
                render: function(data, type, row) {
                    return row.odp_id ? 
                        `<a href="/odp/${row.odp_id}" class="text-blue-500 hover:underline">${data}</a>` : 
                        '-';
                }
            },
            { 
                data: 'odc_name', 
                render: function(data, type, row) {
                    return row.odc_id ? 
                        `<a href="/odc/${row.odc_id}" class="text-blue-500 hover:underline">${data}</a>` : 
                        '-';
                }
            },
            { 
                data: 'olt_name',
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: 'port_available',
                render: function(data) {
                    return data || '0';
                }
            }
        ],
        dom: '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
            language: {
            paginate: {
            previous: "<", next: ">" , }, lengthMenu: "Show _MENU_ entries" , search: "Search:" , }, createdRow: function (row,
              data, dataIndex) { if (dataIndex % 2===1) { // Apply the 'even' class for even rows (starts from 0)
              $(row).addClass('even:bg-blue-50'); } },
    });

    // Handle OLT filter change
    $('#olt_filter').change(function() {
        const olt_id = $(this).val();
        
        // Reset and disable dependent dropdowns
        $('#odc_filter')
            .empty()
            .append('<option value="">Pilih ODC</option>')
            .prop('disabled', !olt_id);
        
        $('#odp_filter')
            .empty()
            .append('<option value="">Pilih ODP</option>')
            .prop('disabled', true);

        if (olt_id) {
            $.ajax({
                url: '{{ route("get.odcs.by.olt") }}',
                method: 'GET',
                data: { olt_id },
                success: function(response) {
                    response.odcs.forEach(function(odc) {
                        $('#odc_filter').append(
                            $('<option>', {
                                value: odc.odc_id,
                                text: odc.odc_name
                            })
                        );
                    });
                }
            });
        }
        
        table.ajax.reload();
    });

    // Handle ODC filter change
    $('#odc_filter').change(function() {
        const odc_id = $(this).val();
        
        // Reset and disable ODP dropdown
        $('#odp_filter')
            .empty()
            .append('<option value="">Pilih ODP</option>')
            .prop('disabled', !odc_id);

        if (odc_id) {
            $.ajax({
                url: '{{route("get.odps.by.odc")}}',
                method: 'GET',
                data: { odc_id },
                success: function(response) {
                    response.odps.forEach(function(odp) {
                        $('#odp_filter').append(
                            $('<option>', {
                                value: odp.odp_id,
                                text: odp.odp_name
                            })
                        );
                    });
                }
            });
        }
        
        table.ajax.reload();
    });

    // Handle ODP filter change
    $('#odp_filter').change(function() {
        table.ajax.reload();
    });
});

</script>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


@endsection