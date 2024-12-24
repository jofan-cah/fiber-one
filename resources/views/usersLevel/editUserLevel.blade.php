@extends('layouts.main')

@section('content')
<div class=" gap-6">


  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">

      <div class="flex justify-between">
        <h2 class="text-2xl font-bold mb-6">Edit Level</h2>
        <div>

          <a href="javascript:history.back()"
            class="px-5 py-2.5 rounded-lg text-sm tracking-wider font-medium border border-blue-700 outline-none bg-transparent hover:bg-blue-700 text-blue-700 hover:text-white transition-all duration-300">
            Back
          </a>
        </div>

      </div>

      <form action="" method="POST" id="userForm" class="font-[sans-serif] max-w-4xl mx-auto">
        @csrf
        <div class="grid sm:grid-cols-2 gap-6">
          <input type="hidden" name="user_level_id" id="user_level_id" value="{{$userLevel['user_level_id']}}" />
          <div class="relative flex items-center">
            <input type="text" id="user_name" value="{{$userLevel['user_name']}}" name="user_name"
              placeholder="Level Name"
              class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" />
            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2"
              viewBox="0 0 24 24">
              <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
              <path
                d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"
                data-original="#000000"></path>
            </svg>
          </div>

          <div class="relative flex items-center">
            <input type="text" id="user_description" value="{{$userLevel['user_description']}}" name="user_description"
              placeholder="Level Description"
              class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" />
            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2"
              viewBox="0 0 24 24">
              <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
              <path
                d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"
                data-original="#000000"></path>
            </svg>
          </div>
        </div>

        <button type="submit"
          class="mt-10 px-6 py-2.5 w-full text-sm bg-[#007bff] text-white hover:bg-[#006bff] rounded-sm">Submit</button>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#userForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah form disubmit secara default

    const submitButton = $(this).find('button[type="submit"]');
      console.log("Submit Button found:", submitButton); // Cek apakah tombol ditemukan
      
      submitButton.prop('disabled', true).text('Loading...');
      console.log("Button disabled and text changed to 'Loading'"); // Pastikan tombol disabled
        // Mengambil data dari form
          var formData = $(this).serialize();
          var userId = $('#user_level_id').val();

        $.ajax({
            url: '/level/update/' + userId, // Ubah dengan route yang sesuai
            method: 'PUT',
            data: formData,
            success: function(response) {
                // Menampilkan alert jika berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data has been saved successfully.',
                }).then((result) => {
                    // Redirect ke route indexUsers setelah alert ditutup
                    window.location.href = '/level'; // Ubah dengan route yang sesuai
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
            // Mengaktifkan tombol submit kembali jika terjadi error
            submitButton.prop('disabled', false).text('Submit');
            console.log("Button re-enabled and text changed back to 'Submit'");
        });
    });
});
</script>
@endsection