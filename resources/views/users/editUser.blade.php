@extends('layouts.main')

@section('content')
<div class=" gap-6">


  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">
      <div class="flex justify-between">
        <h2 class="text-2xl font-bold mb-6">Edit User</h2>
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
          <div class="relative flex items-center">
            <input type="hidden" id="user_id" name="user_id" value="{{ $user['user_id'] }}">
            <input type="text" value="{{$user['full_name']}}" id="full_name" name="full_name" placeholder="Full Name"
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
            <input type="text" value="{{$user['username']}}" id="username" name="username" placeholder="Username"
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
            <input type="text" value="{{$user['email']}}" id="email" name="email" placeholder="Email"
              class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" />
            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2"
              viewBox="0 0 682.667 682.667">
              <defs>
                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                  <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                </clipPath>
              </defs>
              <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                <path fill="none" stroke-miterlimit="10" stroke-width="40"
                  d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z"
                  data-original="#000000"></path>
                <path
                  d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z"
                  data-original="#000000"></path>
              </g>
            </svg>
          </div>

          <div class="relative flex items-center">
            <select id="user_level_id" name="user_level_id"
              class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none">
              @foreach ($userLevel as $item)
              <option value="{{$item['user_level_id']}}" {{($user['user_level_id']==$item['user_level_id'] ? 'selected'
                : '' )}}>{{$item['user_name']}}</option>
              @endforeach
            </select>
          </div>
          <div class="relative flex items-center sm:col-span-2">
            <input type="password" id="password" name="password" placeholder="Kosongkan Password Jika tidak di ubah"
              class="px-2 py-3 bg-white text-black w-full text-sm border-b-2 focus:border-[#007bff] outline-none" />
            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
              class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
              <path
                d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"
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

        // Mengambil data dari form
        var formData = $(this).serialize();
        var userId = $('#user_id').val(); // Ambil ID user dari form (pastikan input ini ada di form)

        $.ajax({
            url: '/users/update/' + userId, // Route dengan ID user
            method: 'PUT', // Method untuk update
            data: formData,
            success: function(response) {
                // Menampilkan alert jika berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data has been updated successfully.',
                }).then((result) => {
                    // Redirect ke route indexUsers setelah alert ditutup
                    window.location.href = '/users'; // Ubah sesuai kebutuhan
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