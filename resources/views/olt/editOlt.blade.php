@extends('layouts.main')

@section('content')
<div class="gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">
      <div class="flex justify-between">
        <h2 class="text-2xl font-bold mb-6">Edit OLT</h2>
        <div>
          <a href="javascript:history.back()" class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
            Back
          </a>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-100 p-8 rounded-lg shadow-md border">
        <!-- OLT Address -->
        <div class="mb-6">
          <form action="" method="PUT" id="userForm">
            @csrf
            <div class="grid grid-cols-2 gap-4">
              <input type="hidden" id="olt_id" name="olt_id" value="{{$olt->olt_id}}">
              <div>
                <label for="olt_name" class="block text-gray-700 dark:text-gray-800 mb-1">OLT Name</label>
                <input type="text" value="{{$olt->olt_name}}" placeholder="input name" id="olt_name" name="olt_name"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
              <div>
                <label for="olt_location_maps" class="block text-gray-700 dark:text-gray-800 mb-1">Maps OLT</label>
                <input placeholder="input latitude longitude" type="text" id="olt_location_maps"
                  name="olt_location_maps" value="{{$olt->olt_location_maps}}"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
              <div>
                <label for="olt_port_capacity" class="block text-gray-700 dark:text-gray-800 mb-1">Port</label>
                <input type="number" min="0" value="{{$olt->olt_port_capacity}}" name="olt_port_capacity"
                  id="olt_port_capacity" placeholder="input port"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
              <div>
                <label for="olt_addres" class="block text-gray-700 dark:text-gray-800 mb-1">Address</label>
                <input type="text" value="{{$olt->olt_addres}}" name="olt_addres" placeholder="input address"
                  id="olt_addres"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
              <div>
                <label for="olt_description" class="block text-gray-700 dark:text-gray-800 mb-1">Description</label>
                <input type="text" value="{{$olt->olt_description}}" name="olt_description"
                  placeholder="Description For OLT" id="olt_description"
                  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
              </div>
            </div>

   <!-- Pre-populate Port Fields from DB -->
   <div id="portFields">
    {{-- @dd($olt->ports) --}}
              @foreach($olt->ports as $index => $port)
                <div class="mb-4">
                  <label for="port_{{ $index+1 }}" class="block text-gray-700 dark:text-gray-800 mb-1">Port {{ $index+1 }} - Status</label>
                  <select name="port_{{ $index+1 }}" id="port_{{ $index+1 }}"
                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                    <option value="enabled" {{ $port->status == 'enabled' ? 'selected' : '' }}>Enabled</option>
                    <option value="disabled" {{ $port->status == 'disabled' ? 'selected' : '' }}>Disabled</option>
                   </select>
                </div>
                <div class="mb-4">
                  <label for="directions_{{ $index+1 }}" class="block text-gray-700 dark:text-gray-800 mb-1">Port {{ $index+1 }} - Direction</label>
                  <input type="text" name="directions[]" value="{{ $port->directions }}" placeholder="Description For OLT" id="directions_{{ $index+1 }}"
                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                </div>
              @endforeach
            </div>

            <div class="mt-8 flex justify-end">
              <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-700 dark:bg-teal-600 dark:text-white dark:hover:bg-teal-700">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    // Handle port capacity input dynamically
    $('#olt_port_capacity').on('input', function() {
      let portCapacity = $(this).val(); // Get the port capacity value
      let currentPortCount = $('#portFields').children().length;

      if (portCapacity > currentPortCount) {
        // Add more port fields if needed
        for (let i = currentPortCount + 1; i <= portCapacity; i++) {
          $('#portFields').append(`
            <div class="mb-4">
              <label for="port_${i}" class="block text-gray-700 dark:text-gray-800 mb-1">Port ${i} - Status</label>
              <select name="port_${i}" id="port_${i}"
                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
                <option value="enabled">Enabled</option>
                <option value="disabled">Disabled</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="directions_${i}" class="block text-gray-700 dark:text-gray-800 mb-1">Port ${i} - Direction</label>
              <input type="text" name="directions[]" placeholder="Description For OLT" id="directions_${i}"
                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-200 dark:text-gray-900 dark:border-gray-300">
            </div>
          `);
        }
      } else {
        // Remove extra port fields if needed
        for (let i = portCapacity + 1; i <= currentPortCount; i++) {
          $('#portFields').children().last().remove();
          $('#portFields').children().last().remove();
        }
      }
    });

// Handle form submission
    $('#userForm').on('submit', function(e) {
        e.preventDefault();

        // Disable submit button and change text to "Loading"
        const submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true).text('Loading...');

        // Gather all port statuses and directions
        let ports = [];
        let directions = [];
        const portCapacity = $('#olt_port_capacity').val();

        for (let i = 1; i <= portCapacity; i++) {
            ports.push($(`#port_${i}`).val());
            directions.push($(`#directions_${i}`).val());
        }

        // Create the form data object
        const formData = {
            olt_name: $('#olt_name').val(),
            olt_description: $('#olt_description').val(),
            olt_location_maps: $('#olt_location_maps').val(),
            olt_addres: $('#olt_addres').val(),
            olt_port_capacity: portCapacity,
            ports: ports,
            directions: directions
        };

        $.ajax({
            url: '/olt/update/' + $('#olt_id').val(),
            method: 'PUT',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data has been updated successfully.',
                }).then((result) => {
                    window.location.href = '/olt';
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

                // Re-enable the submit button if there's an error
                submitButton.prop('disabled', false).text('Submit');
            }
        });
    });
  });
</script>

@endsection
