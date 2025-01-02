@extends('layouts.main')

@section('content')
    <div class=" gap-6">


        <div
            class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
            <div class="container mx-auto px-4 py-8">
                <div class="flex justify-between">
                    <h2 class="text-2xl font-bold mb-6">Add Pelanggan</h2>
                    <div>

                        <a href="javascript:history.back()"
                            class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
                            Back
                        </a>
                    </div>

                </div>

                <div class="bg-white dark:bg-gray-100 p-8 rounded-lg shadow-md border">

                    <!-- OLT Address -->
                    <div class="mb-6">
                        <form action="" method="POST" id="userForm">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="subs_id" class="block text-gray-700 dark:text-gray-800 mb-1"> ID Pelangan
                                    </label>
                                    <input placeholder="input Subs ID" type="text" id="subs_id" name="subs_id"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                </div>
                                <div>
                                    <label for="subs_name" class="block text-gray-700 dark:text-gray-800 mb-1"> Nama
                                        Pelangan</label>
                                    <input type="text" placeholder="input name" id="subs_name" name="subs_name"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                </div>

                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="subs_location_maps"
                                        class="block text-gray-700 dark:text-gray-800 mb-1">Location
                                        (Maps)</label>
                                    <input placeholder="input latitude longitude" type="text" id="subs_location_maps"
                                        name="subs_location_maps"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                </div>
                                <div>
                                    <label for="odp_id" class="block text-gray-700 dark:text-gray-800 mb-1">ODP
                                        Nama</label>
                                    <select name="odp_id" id="odp_id"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                        <option value="" disabled selected>Select ODP</option>
                                        @foreach ($odps as $odp)
                                            <option value="{{ $odp->odp_id }}">
                                                {{ $odp->odp_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="sn" class="block text-gray-700 dark:text-gray-800 mb-1">SN Modem</label>
                                    <input placeholder="input SN Modem" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300" type="text" name="sn" id="sn">
                                </div>
                                <div>
                                    <label for="type_modem"  class="block text-gray-700 dark:text-gray-800 mb-1">Type Modem</label>
                                    <input placeholder="input type modem" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300" type="text" name="type_modem" id="type_modem">
                                </div>

                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">



                                <div id="splitter-container" class="hidden">
                                    <label for="splitter_id" class="block text-gray-700 dark:text-gray-800 mb-1"> Pilih
                                        Port</label>
                                    <select name="splitter_id" id="splitter_id"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                        <option value="" disabled selected>Select Port</option>
                                    </select>
                                </div>

                            </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-700 dark:bg-teal-600 dark:text-white dark:hover:bg-teal-700">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#odp_id').on('change', function() {
                var odcId = $(this).val();

                if (odcId) {
                    // Tampilkan div splitter setelah memilih ODC
                    $('#splitter-container').removeClass('hidden');

                    $.ajax({
                        url: '/odp/portOdps/' + odcId, // URL ke route splitterOdp
                        method: 'GET',
                        success: function(response) {
                            var splitterSelect = $('#splitter_id');
                            splitterSelect.empty(); // Hapus semua opsi sebelumnya

                            // Tambahkan opsi pertama (Select Splitter)
                            splitterSelect.append(
                                '<option value="" disabled selected>Select Port</option>');

                            // Tambahkan opsi splitter dari respons
                            response.forEach(function(splitter) {
                                var option = $('<option></option>').attr('value',
                                    splitter.id).text(splitter.port_number);

                                // Cek jika splitter.odp_id !== null dan disable opsi
                                if (splitter.subs_id !== null) {
                                    option.prop('disabled',
                                        true
                                        ); // Menonaktifkan opsi jika odp_id tidak null
                                }

                                splitterSelect.append(option);
                            });

                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong, please try again.',
                            });
                        }
                    });
                } else {
                    // Sembunyikan div splitter jika ODC tidak dipilih
                    $('#splitter-container').addClass('hidden');
                }
            });

            $('#userForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form disubmit secara default

                // Mengambil data dari form
                var formData = $(this).serialize();
                console.log(formData);

                $.ajax({
                    url: '{{ route('storeSubs') }}', // Ubah dengan route yang sesuai
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Menampilkan alert jika berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been saved successfully.',
                        }).then((result) => {
                            // Redirect ke route indexUsers setelah alert ditutup
                            window.location.href =
                                '/subs'; // Ubah dengan route yang sesuai
                        });
                    },
                    error: function(xhr, status, error) {
                        // Menangani error validasi yang dikirim oleh server
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';

                            // Menggabungkan pesan error dari respons
                            $.each(errors, function(field, messages) {
                                errorMessages += messages.join(', ') + '\n';
                            });

                            // Menampilkan alert error dengan pesan kesalahan
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: errorMessages, // Menampilkan pesan error
                            });
                        } else {
                            // Jika ada error lain (misalnya server error)
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong, please try again.', // Pesan fallback jika tidak ada error detail
                            });
                        }
                        // Mengaktifkan tombol submit kembali jika terjadi error
                        submitButton.prop('disabled', false).text('Submit');
                    }
                });
            });
        });
    </script>
@endsection
