@extends('layouts.main')

@section('content')
    <div class="gap-6">
        <div
            class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
            <div class="container mx-auto px-4 py-8">
                <div class="flex justify-between">
                    <h2 class="text-2xl font-bold mb-6">Edit Paket</h2>
                    <div>
                        <a href="javascript:history.back()"
                            class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
                            Back
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-100 p-8 rounded-lg shadow-md border">
                    <form action="" method="PUT" id="userForm">
                        @csrf
                        <input type="hidden" id="pakets_id" name="pakets_id" value="{{ $paket->pakets_id }}">

                        <!-- Nama Paket -->
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="nama_paket" class="block text-gray-700 dark:text-gray-800 mb-1"> Nama
                                    Paket</label>
                                <input placeholder="Nama Paket" type="text" id="nama_paket" name="nama_paket"
                                    value="{{ $paket->nama_paket }}"
                                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                            </div>

                            <!-- Status Toggle -->
                            <div>
                                <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                                <div x-data="{ isActive: {{ old('status', $paket->status ?? 0) }} }">
                                    <!-- Toggle Switch -->
                                    <button :class="isActive ? 'bg-green-500' : 'bg-gray-300'" @click="isActive = !isActive"
                                        type="button"
                                        class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors duration-300 ease-in-out">
                                        <span :class="isActive ? 'translate-x-5' : 'translate-x-0'"
                                            class="inline-block w-5 h-5 transform bg-white rounded-full transition-transform duration-200 ease-in-out"></span>
                                    </button>
                                    <!-- Hidden Input to send status value -->
                                    <input type="hidden" name="status" :value="isActive ? 1 : 0">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-700 dark:bg-teal-600 dark:text-white dark:hover:bg-teal-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {

            $('#userForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form disubmit secara default
                // Disable submit button and change text to "Loading"
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true).text('Loading...');

                // Mengambil data dari form
                var formData = $(this).serialize();
                var userId = $('#pakets_id')
            .val(); // Ambil ID user dari form (pastikan input ini ada di form)
                console.log(userId);
                $.ajax({
                    url: '/paket/update/' + userId, // Route dengan ID user
                    method: 'put', // Method untuk update
                    data: formData,
                    success: function(response) {
                        // Menampilkan alert jika berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been updated successfully.',
                        }).then((result) => {
                            // Redirect ke route indexUsers setelah alert ditutup
                            window.location.href = '/paket'; // Ubah sesuai kebutuhan
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
