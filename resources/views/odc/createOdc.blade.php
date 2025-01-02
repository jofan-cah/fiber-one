@extends('layouts.main')

@section('content')
    <div class=" gap-6">
        <div
            class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
            <div class="container mx-auto px-4 py-8">
                <div class="flex justify-between">
                    <h2 class="text-2xl font-bold mb-6">Add ODC</h2>
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
                                    <label for="odc_name" class="block text-gray-700 dark:text-gray-800 mb-1">Name ODC
                                    </label>
                                    <input type="text" placeholder="input name" id="odc_name" name="odc_name"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                </div>
                                <div>
                                    <label for="odc_location_maps" class="block text-gray-700 dark:text-gray-800 mb-1">Maps
                                        ODC</label>
                                    <input placeholder="input latitude longitude" type="text" id="odc_location_maps"
                                        name="odc_location_maps"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="odc_port_capacity"
                                        class="block text-gray-700 dark:text-gray-800 mb-1">Splitter</label>
                                    <select name="odc_port_capacity" id="odc_port_capacity"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                        <option value="" selected disabled>Splitter </option>
                                        <option value="2">1 : 2 </option>
                                        <option value="4">1 : 4 </option>
                                        <option value="8">1 : 8 </option>
                                        <option value="16">1 : 16 </option>
                                    </select>

                                </div>
                                <div>
                                    <label for="odc_addres" class="block text-gray-700 dark:text-gray-800 mb-1">Address
                                    </label>
                                    <input type="text" name="odc_addres" placeholder="input address" id="odc_addres"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="odc_description"
                                        class="block text-gray-700 dark:text-gray-800 mb-1">Description</label>
                                    <input type="text" name="odc_description" placeholder="Description For odc"
                                        id="odc_description"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                </div>

                                <div>
                                    <label for="olt_id" class="block text-gray-700 dark:text-gray-800 mb-1">OLT</label>
                                    <select name="olt_id" id="olt_id"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                        <option value="" disabled selected>Select OLT</option>
                                        @foreach ($olts as $olt)
                                            <option value="{{ $olt->olt_id }}">{{ $olt->olt_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label for="parent_odc_id" class="block text-gray-700 dark:text-gray-800 mb-1">ODC
                                        Parent</label>
                                    <select name="parent_odc_id" id="parent_odc_id"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                        <option value="" selected>Select ODC</option>
                                        @foreach ($odcs as $odc)
                                            <option value="{{ $odc->odc_id }}">{{ $odc->odc_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="odc-container" class="hidden">
                                    <label for="port_number" class="block text-gray-700 dark:text-gray-800 mb-1">PON</label>
                                    <select name="port_number" id="port_number"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                                        <option value="" selected disabled>PON </option>

                                    </select>

                                </div>

                            </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" id="submitButton"
                            class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-700 dark:bg-teal-600 dark:text-white dark:hover:bg-teal-700">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // var odcId = $('#parent_odc_id').val();
            // console.log('ODC ID:', odcId);


            $('#olt_id').on('change', function() {
                var odcId = $(this).val();
                console.log('Selected ODC ID:', odcId);

                if (odcId) {
                    // Tampilkan div ODC jika ODC dipilih
                    $('#odc-container').removeClass('hidden');

                    // Panggil AJAX untuk mendapatkan data splitter
                    $.ajax({
                        url: '/odc/getPorts/' + odcId, // URL ke route splitterOdp
                        method: 'GET',
                        success: function(response) {
                            var portSelect = $('#port_number');
                            portSelect.empty(); // Hapus semua opsi sebelumnya

                            // Tambahkan opsi pertama (Select PON)
                            portSelect.append(
                                '<option value="" disabled selected>Select PON</option>');

                            // Tambahkan opsi berdasarkan respons
                            response.forEach(function(port) {
                                var option = $('<option></option>')
                                    .attr('value', port.id)
                                    .text('No Pon :' + port.port_number +
                                        ' |  Status : ' + port.status);

                                // Disable opsi jika port.odp_id !== null
                                if (port.odp_id !== null) {
                                    option.prop('disabled', true);
                                }

                                portSelect.append(option);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching PON data:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong, please try again.',
                            });

                            // Mengaktifkan tombol submit kembali jika terjadi error
                            submitButton.prop('disabled', false).text('Submit');
                        }
                    });
                } else {
                    // Sembunyikan div ODC jika tidak ada ODC yang dipilih
                    $('#odc-container').addClass('hidden');
                }
            });







            $('#userForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form disubmit secara default

                // Disable tombol submit dan ubah teksnya menjadi "Loading"
                const submitButton = $('#submitButton');
                submitButton.prop('disabled', true).text('Loading...');
                // Mengambil data dari form
                var formData = $(this).serialize();
                console.log(formData);

                $.ajax({
                    url: '{{ route('storeOdc') }}', // Ubah dengan route yang sesuai
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
                            '/odc'; // Ubah dengan route yang sesuai
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
                    },
                    complete: function() {
                        // Mengaktifkan kembali tombol submit setelah proses selesai
                        submitButton.prop('disabled', false).text('Submit');
                    }
                });

            });
        });
    </script>
@endsection
