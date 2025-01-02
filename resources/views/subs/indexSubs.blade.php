@extends('layouts.main')

@section('content')
    <div class=" gap-6">
        <div
            class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
            <div class="container mx-auto px-4 py-8">

                <div class="flex justify-between">
                    <h2 class="text-2xl font-bold mb-6">Data Pelangan</h2>
                    <div>

                        <a href="{{ route('createSubs') }}"
                            class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
                            Tambah Pelangan
                        </a>
                    </div>

                </div>
                <div class="overflow-x-auto">
                    <table id="user-table" class="min-w-full bg-white">
                        <thead class="whitespace-nowrap bg-gray-700">
                            <tr>
                                <th class="p-4 text-left text-sm font-semibold text-white">Pelangan ID</th>
                                <th class="p-4 text-left text-sm font-semibold text-white">Pelangan Name</th>
                                {{-- <th class="p-4 text-left text-sm font-semibold text-white">Nama Odp</th> --}}
                                <th class="p-4 text-left text-sm font-semibold text-white">Route</th>
                                <th class="p-4 text-left text-sm font-semibold text-white">Type</th>
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
        $(document).ready(function() {
            $('#user-table').DataTable({
                ajax: {
                    url: '/subs/allData', // Ganti dengan URL endpoint API Anda
                    type: 'GET',
                    dataSrc: '',
                },
                scrollX: true,
                columns: [{
                        data: 'subs_id'
                    },
                    {
                        data: 'subs_name'
                    },
                    // {
                    //     data: 'odp.odp_name'
                    // },
                    {
                        data: null,
                        render: function(data, type, row) {
                            // Akses nama ODP, ODC, dan OLT serta ID mereka
                            const odpName = row.odp ? row.odp.odp_name : '';
                            const odcName = row.odp && row.odp.odc ? row.odp.odc.odc_name : '';
                            const oltName = row.odp && row.odp.odc && row.odp.odc.olt ? row.odp.odc
                                .olt.olt_name : '';
                            const odpId = row.odp ? row.odp.odp_id : '';
                            const odcId = row.odp && row.odp.odc ? row.odp.odc.odc_id : '';
                            const oltId = row.odp && row.odp.odc && row.odp.odc.olt ? row.odp.odc
                                .olt.olt_id : '';

                            // Membuat link untuk ODP, ODC, dan OLT
                            return `
                        <div class="flex space-x-2">
                            <a href="/odp/${odpId}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold py-1 px-2 rounded-md border border-blue-400 hover:border-blue-600 transition-all duration-200">
                                ${odpName}
                            </a>
                            <span class="text-gray-500">=> </span>
                            <a href="/odc/${odcId}" target="_blank" class="text-green-600 hover:text-green-800 font-semibold py-1 px-2 rounded-md border border-green-400 hover:border-green-600 transition-all duration-200">
                                ${odcName}
                            </a>
                            <span class="text-gray-500">=> </span>
                            <a href="/olt/${oltId}" target="_blank" class="text-red-600 hover:text-red-800 font-semibold py-1 px-2 rounded-md border border-red-400 hover:border-red-600 transition-all duration-200">
                                ${oltName}
                            </a>
                        </div>
                    `;
                        },
                    },
                    {
                        data: null,
                        render: function(data, type, row) {

                            const oltName = row.odp.odc.olt.type_olt;

                            // Gabungkan nama-nama tersebut menjadi satu string untuk ditampilkan
                            return `
                               <button type="button" class="flex items-center text-red-600 text-sm bg-red-50 px-3 py-1.5 tracking-wide rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 mr-2 fill-current" viewBox="0 0 24 24">
                                <g fill-rule="evenodd" clip-rule="evenodd">
                                    <path d="M8.651 2.5c-2.52 0-4.15 1.729-4.15 4.404v8.146c0 2.676 1.63 4.404 4.15 4.404h8.647c2.525 0 4.156-1.728 4.156-4.404V6.904c.001-1.363-.415-2.501-1.203-3.29-.728-.729-1.747-1.114-2.949-1.114zm8.647 18.454H8.65C5.27 20.954 3 18.581 3 15.05V6.904C3 3.373 5.27 1 8.65 1h8.651c1.608 0 2.995.537 4.01 1.554 1.061 1.062 1.643 2.607 1.641 4.351v8.145c0 3.531-2.273 5.904-5.656 5.904z" data-original="#000000" />
                                    <path d="M9.856 6.69a1.096 1.096 0 1 0 .003 2.192 1.096 1.096 0 0 0-.003-2.193zm.001 3.69a2.598 2.598 0 0 1-2.596-2.595A2.598 2.598 0 0 1 9.857 5.19a2.6 2.6 0 0 1 2.597 2.595 2.599 2.599 0 0 1-2.597 2.596zM4.75 19.111a.75.75 0 0 1-.653-1.117c.06-.108 1.494-2.645 3.073-3.945 1.252-1.03 2.6-.464 3.686-.007.64.27 1.243.523 1.823.523.532 0 1.2-.94 1.79-1.769.818-1.156 1.748-2.464 3.11-2.464 2.17 0 4.043 1.936 5.05 2.976l.116.12a.751.751 0 0 1-.016 1.061.748.748 0 0 1-1.06-.016l-.118-.122c-.852-.88-2.438-2.519-3.972-2.519-.588 0-1.278.973-1.889 1.832-.838 1.18-1.705 2.401-3.01 2.401-.884 0-1.693-.34-2.406-.64-1.134-.479-1.648-.632-2.15-.218-1.365 1.124-2.707 3.498-2.72 3.521a.749.749 0 0 1-.655.383z" data-original="#000000" />
                                </g>
                                </svg>
                                ${oltName}
                            </button>
                            `;
                        },
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                    <div class="flex space-x-2">
                        <a class="cursor-pointer flex items-center px-2 py-1 rounded-full bg-yellow-400 text-white"
                          onclick="editOlt('${row.subs_id}')">
                          <i class='bx bx-xs bx-edit'></i>
                        </a>

                        <a class="cursor-pointer flex items-center px-2 py-1 rounded-full bg-red-500 text-white"
                         onclick="deleteOlt('${row.subs_id}')">
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
                createdRow: function(row, data, dataIndex) {
                    if (dataIndex % 2 === 1) {
                        // Apply the 'even' class for even rows (starts from 0)
                        $(row).addClass('even:bg-blue-50');
                    }
                },
            });
        });

        // Edit User Action
        function editOlt(oltId) {
            window.location.href = `/subs/edit/${oltId}`;
            // Addkan logika edit di sini
        }

        // Edit User Action
        function showOlt(oltId) {
            window.location.href = `/subs/${oltId}`;
            // Addkan logika edit di sini
        }

        function deleteOlt(oltId) {
            // Tampilkan konfirmasi dengan SweetAlert2
            Swal.fire({
                title: 'Are you sure?',
                text: `You won't be able to revert this! User ID: ${oltId}`,
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
                        url: `/subs/${oltId}`, // Endpoint penghapusan
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                `User ${oltId} has been deleted.`,
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
