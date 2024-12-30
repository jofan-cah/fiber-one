@extends('layouts.main')

@section('content')



<div class=" gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">

      <div class="flex justify-between">
        <h2 class="text-2xl font-bold mb-6">Data ODP</h2>
        <div>

          <a href="{{ route('createOdp') }}"
            class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
            Add ODP
          </a>
        </div>

      </div>
      <div class="overflow-x-auto">
        <table id="user-table" class="min-w-full bg-white">
          <thead class="whitespace-nowrap bg-gray-700">
            <tr>
              <th class="p-4 text-left text-sm font-semibold text-white">ODP Name</th>
              <th class="p-4 text-left text-sm font-semibold text-white">ODC</th>
              <th class="p-4 text-left text-sm font-semibold text-white">Avalaible Port</th>
              <th class="p-4 text-left text-sm font-semibold text-white">Port</th>
              <th class="p-4 text-left text-sm font-semibold text-white">Description</th>
              {{-- <th class="p-4 text-left text-sm font-semibold text-white">Address</th> --}}
              <th class="p-4 text-left text-sm font-semibold text-white">Actions</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Initialize DataTables -->
<script>
  $(document).ready(function () {
    $('#user-table').DataTable({
        ajax: {
            url: '/odp/allData', // Ganti dengan URL endpoint API Anda
            type: 'GET',
            dataSrc: '',
        },
        scrollX: true,
        columns: [
          { data: 'odp_name' },
            { data: 'odc.odc_name' },
            { data: 'available_ports' },
            { data: 'odp_port_capacity' },
            { data: 'odp_description' },
           {
          data: null,
          render: function (data, type, row) {
          return `
          <div class="flex space-x-2">
            <a class="cursor-pointer flex items-center px-2 py-1 rounded-full bg-yellow-400 text-white"
              onclick="editOdp('${row.odp_id}')">
              <i class='bx bx-xs bx-edit'></i>
            </a>
            <a class="cursor-pointer flex items-center px-2 py-1 rounded-full bg-green-500 text-white"
              onclick="showOdp('${row.odp_id}')"><i class='bx bx-xs bx-show-alt'></i></a>
            <a class="cursor-pointer flex items-center px-2 py-1 rounded-full bg-red-500 text-white"
             onclick="deleteOdp('${row.odp_id}')">
             <i class='bx bx-xs bx-trash'></i>
             </a>

          </div>
          `;
          },
          },
        ],
       dom: '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
        language: {
            paginate: {
                previous: "<",
                next: ">",
            },
            lengthMenu: "Show _MENU_ entries",
            search: "Search:",
        },
         createdRow: function (row, data, dataIndex) {
            if (dataIndex % 2 === 1) {
                // Apply the 'even' class for even rows (starts from 0)
                $(row).addClass('even:bg-blue-50');
            }
        },
    });
});

  // Edit User Action
  function editOdp(odpId) {
     window.location.href = `/odp/edit/${odpId}`;
      // Addkan logika edit di sini
  }
  // Edit User Action
    function showOdp(odpId) {
    window.location.href = `/odp/${odpId}`;
    // Addkan logika edit di sini
    }

function deleteOdp(odpId) {
    // Tampilkan konfirmasi dengan SweetAlert2
    Swal.fire({
        title: 'Are you sure?',
        text: `You won't be able to revert this! User ID: ${odpId}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim permintaan AJAX untuk menghapus user
            $.ajax({
                url: `/odp/${odpId}`, // Endpoint penghapusan
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        `${odpId} has been deleted.`,
                        'success'
                    ).then(() => {
                        // Reload halaman atau perbarui data tabel
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again later.',
                        'error'
                    );
                }
            });
        }
    });
}


</script>


@endsection
