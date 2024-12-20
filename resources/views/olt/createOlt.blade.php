@extends('layouts.main')

@section('content')
<div class=" gap-6">


  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">
      <div class="flex justify-between">
        <h2 class="text-2xl font-bold mb-6">Add Olt</h2>
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
                <label for="olt_name" class="block text-gray-700 dark:text-gray-800 mb-1">Olt Name</label>
                <input type="text" placeholder="input name" id="olt_name" name="olt_name"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
              <div>
                <label for="olt_location_maps" class="block text-gray-700 dark:text-gray-800 mb-1">Maps Olt</label>
                <input placeholder="input latitude longitude" type="text" id="olt_location_maps"
                  name="olt_location_maps"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
              <div>
                <label for="olt_port_capacity" class="block text-gray-700 dark:text-gray-800 mb-1">Port</label>
                <input type="number" min="0" name="olt_port_capacity" id="olt_port_capacity" placeholder="input port"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
              <div>
                <label for="olt_addres" class="block text-gray-700 dark:text-gray-800 mb-1">Address </label>
                <input type="text" name="olt_addres" placeholder="input address" id="olt_addres"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
              <div>
                <label for="olt_description" class="block text-gray-700 dark:text-gray-800 mb-1">Description</label>
                <input type="text" name="olt_description" placeholder="Description For OLT" id="olt_description"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
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
    $('#userForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah form disubmit secara default

        // Mengambil data dari form
        var formData = $(this).serialize();
        console.log(formData);

        $.ajax({
            url: '{{ route('storeOlt') }}', // Ubah dengan route yang sesuai
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
                    window.location.href = '/olt'; // Ubah dengan route yang sesuai
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
            }
        });
    });
});
</script>
@endsection