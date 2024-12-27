@extends('layouts.main')

@section('content')
<div class=" gap-6">


  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">
      <div class="flex justify-between">
        <h2 class="text-2xl font-bold mb-6">Add OLT</h2>
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
                <label for="olt_name" class="block text-gray-700 dark:text-gray-800 mb-1">OLT Name</label>
                <input type="text" placeholder="input name" id="olt_name" name="olt_name"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
              <div>
                <label for="olt_location_maps" class="block text-gray-700 dark:text-gray-800 mb-1">Maps OLT</label>
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
           <!-- Port Dynamic Inputs -->
           <div id="portFields" class="mt-6"></div>

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


    $('#olt_port_capacity').on('input', function() {
    let portCapacity = $(this).val(); // Ambil jumlah port yang dimasukkan
    $('#portFields').empty(); // Kosongkan div portFields sebelum menambahkan input baru

    // Tambahkan input port sesuai dengan jumlah yang dimasukkan
    for (let i = 1; i <= portCapacity; i++) {
        $('#portFields').append(`
          <div class="mb-4">
            <label for="port_${i}" class="block text-gray-700 dark:text-gray-800 mb-1">Port ${i} - Status</label>
            <select name="port_${i}" id="port_${i}"
              class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              <option value="available">Aktive</option>
              <option value="occupied">Terisi</option>
              <option value="inactive">TidakAktif</option>
            </select>
          </div>
          <div class="mb-4">
            <label for="directions_${i}" class="block text-gray-700 dark:text-gray-800 mb-1">Port ${i} - Direction</label>
           <input type="text" name="directions[]" placeholder="Description For OLT" id="directions_${i}"
              class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
          </div>
        `);
    }
});


  console.log("Document ready"); // Memastikan jQuery berhasil dimuat

  $('#userForm').on('submit', function(e) {
    event.preventDefault(); // Mencegah pengiriman form standar

        let ports = [];
        let directions = [];
        const portCapacity = $('#olt_port_capacity').val(); // Kapasitas port yang diinput

        for (let i = 1; i <= portCapacity; i++) {
            const portValue = $(`#port_${i}`).val();
            const directionValue = $(`#directions_${i}`).val();

            if (portValue) ports.push(portValue);
            if (directionValue) directions.push(directionValue);

            console.log(`Port ${i}:`, portValue);
            console.log(`Direction ${i}:`, directionValue);
        }
        console.log('Collected Ports:', ports);
        console.log('Collected Directions:', directions);


        // Create the form data object
        const formData = {
            olt_name: $('#olt_name').val(),
            olt_description: $('#olt_description').val(),
            olt_location_maps: $('#olt_location_maps').val(),
            olt_addres: $('#olt_addres').val(),
            olt_port_capacity: portCapacity,
            'ports[]': ports,  // Array data
            'directions[]': directions
        };



    // Disable tombol submit dan ubah teksnya menjadi "Loading"
    const submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true).text('Loading...');



    $.ajax({
      url: '{{ route('storeOlt') }}', // Ubah dengan route yang sesuai
      method: 'POST',
      data: formData,
      headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'Data has been saved successfully.',
        }).then((result) => {
          window.location.href = '/olt'; // Ubah dengan route yang sesuai
        });
      },
      error: function(xhr, status, error) {
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          var errors = xhr.responseJSON.errors;
          var errorMessages = '';
          $.each(errors, function(field, messages) {
            errorMessages += messages.join(', ') + '\n';
          });

          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: errorMessages,
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong, please try again.',
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