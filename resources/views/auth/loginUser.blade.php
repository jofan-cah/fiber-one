<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
  <div class="font-[sans-serif]">
    <div
      class="grid lg:grid-cols-2 gap-4 max-lg:gap-12 bg-gradient-to-r from-blue-500 to-blue-700 px-8 py-12 h-[320px]">
      <div>
        <a href="javascript:void(0)"><img
            src="https://fiberone.net.id/wp-content/uploads/2023/03/cropped-Logo-Fiberone.png" alt="logo"
            class='w-40' />
        </a>
        <div class="max-w-lg mt-16 max-lg:hidden">
          <h3 class="text-3xl font-bold text-white">Sign in</h3>
          <p class="text-sm mt-4 text-white">Internet fiber optic dengan kecepatan up to 100 Mbps dengan harga
            terjangkau..</p>
        </div>
      </div>

      <div
        class="bg-white rounded-xl sm:px-6 px-4 py-8 max-w-md w-full h-max shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] max-lg:mx-auto">
        @if (session('error'))
        <div id="alert-3" class="flex p-4 mb-4 text-red-800 border-2 border-red-300 rounded-lg bg-red-50 " role="alert">
          <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd"></path>
          </svg>
          <span class="sr-only">Info</span>
          <div class="ml-3 text-sm font-medium">
            {{ session('error') }}
          </div>
          <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8  dark:hover:bg-gray-700"
            data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
        @endif
        <form action="{{ route('logged') }}" method="POST">
          @csrf
          <div class="mb-8">
            <h3 class="text-3xl font-extrabold text-gray-800">Sign in</h3>
          </div>
          <div class="sm:flex sm:items-start space-x-4 max-sm:space-y-4 mb-8">
            <button type="button"
              class="py-2.5 px-4 text-sm font-semibold rounded-md text-blue-500 bg-blue-100 hover:bg-blue-200 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="20px" class="inline mr-4" viewBox="0 0 512 512">
                <path fill="#fbbd00"
                  d="M120 256c0-25.367 6.989-49.13 19.131-69.477v-86.308H52.823C18.568 144.703 0 198.922 0 256s18.568 111.297 52.823 155.785h86.308v-86.308C126.989 305.13 120 281.367 120 256z"
                  data-original="#fbbd00" />
                <path fill="#0f9d58"
                  d="m256 392-60 60 60 60c57.079 0 111.297-18.568 155.785-52.823v-86.216h-86.216C305.044 385.147 281.181 392 256 392z"
                  data-original="#0f9d58" />
                <path fill="#31aa52"
                  d="m139.131 325.477-86.308 86.308a260.085 260.085 0 0 0 22.158 25.235C123.333 485.371 187.62 512 256 512V392c-49.624 0-93.117-26.72-116.869-66.523z"
                  data-original="#31aa52" />
                <path fill="#3c79e6"
                  d="M512 256a258.24 258.24 0 0 0-4.192-46.377l-2.251-12.299H256v120h121.452a135.385 135.385 0 0 1-51.884 55.638l86.216 86.216a260.085 260.085 0 0 0 25.235-22.158C485.371 388.667 512 324.38 512 256z"
                  data-original="#3c79e6" />
                <path fill="#cf2d48"
                  d="m352.167 159.833 10.606 10.606 84.853-84.852-10.606-10.606C388.668 26.629 324.381 0 256 0l-60 60 60 60c36.326 0 70.479 14.146 96.167 39.833z"
                  data-original="#cf2d48" />
                <path fill="#eb4132"
                  d="M256 120V0C187.62 0 123.333 26.629 74.98 74.98a259.849 259.849 0 0 0-22.158 25.235l86.308 86.308C162.883 146.72 206.376 120 256 120z"
                  data-original="#eb4132" />
              </svg>
              Sign in with Google
            </button>
            <button type="button"
              class="py-2.5 px-4 text-sm font-semibold rounded-md text-blue-500 bg-blue-100 hover:bg-blue-200 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="20px" fill="#007bff" viewBox="0 0 167.657 167.657">
                <path
                  d="M83.829.349C37.532.349 0 37.881 0 84.178c0 41.523 30.222 75.911 69.848 82.57v-65.081H49.626v-23.42h20.222V60.978c0-20.037 12.238-30.956 30.115-30.956 8.562 0 15.92.638 18.056.919v20.944l-12.399.006c-9.72 0-11.594 4.618-11.594 11.397v14.947h23.193l-3.025 23.42H94.026v65.653c41.476-5.048 73.631-40.312 73.631-83.154 0-46.273-37.532-83.805-83.828-83.805z"
                  data-original="#010002"></path>
              </svg>
            </button>
            <button type="button"
              class="py-2.5 px-4 text-sm font-semibold rounded-md text-blue-500 bg-blue-100 hover:bg-blue-200 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="20px" fill="#000" viewBox="0 0 22.773 22.773">
                <path
                  d="M15.769 0h.162c.13 1.606-.483 2.806-1.228 3.675-.731.863-1.732 1.7-3.351 1.573-.108-1.583.506-2.694 1.25-3.561C13.292.879 14.557.16 15.769 0zm4.901 16.716v.045c-.455 1.378-1.104 2.559-1.896 3.655-.723.995-1.609 2.334-3.191 2.334-1.367 0-2.275-.879-3.676-.903-1.482-.024-2.297.735-3.652.926h-.462c-.995-.144-1.798-.932-2.383-1.642-1.725-2.098-3.058-4.808-3.306-8.276v-1.019c.105-2.482 1.311-4.5 2.914-5.478.846-.52 2.009-.963 3.304-.765.555.086 1.122.276 1.619.464.471.181 1.06.502 1.618.485.378-.011.754-.208 1.135-.347 1.116-.403 2.21-.865 3.652-.648 1.733.262 2.963 1.032 3.723 2.22-1.466.933-2.625 2.339-2.427 4.74.176 2.181 1.444 3.457 3.028 4.209z"
                  data-original="#000000"></path>
              </svg>
            </button>
          </div>

          <div>
            <label class="text-gray-800 text-sm mb-2 block">User name</label>
            <div class="relative flex items-center">
              <input name="username" type="text" required
                class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-md outline-blue-600"
                placeholder="Enter user name" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                <path
                  d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"
                  data-original="#000000"></path>
              </svg>
            </div>
          </div>
          <div class="mt-4">
            <label class="text-gray-800 text-sm mb-2 block">Password</label>
            <div class="relative flex items-center">
              <input id="passwordInput" name="password" type="password" required
                class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-md outline-blue-600"
                placeholder="Enter password" />
              <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                <path
                  d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"
                  data-original="#000000"></path>
              </svg>
            </div>
          </div>
          <div class="mt-4 text-right">
            <a href="jajvascript:void(0);" class="text-blue-600 text-sm font-semibold hover:underline">
              Forgot your password?
            </a>
          </div>

          <div class="mt-8">
            <button type="submit"
              class="w-full shadow-xl py-3 px-6 text-sm font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
              Log in
            </button>
          </div>
          <p class="text-sm mt-8 text-center text-gray-800">Don't have an account <a href="javascript:void(0);"
              class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Register here</a></p>
        </form>
      </div>
    </div>
  </div>
</body>


<script>
  document.addEventListener('DOMContentLoaded', () => {
      const closeButtons = document.querySelectorAll('[data-dismiss-target]');
  
      closeButtons.forEach(button => {
        button.addEventListener('click', () => {
          const target = document.querySelector(button.getAttribute('data-dismiss-target'));
          if (target) {
            target.classList.add('hidden'); // Menambahkan kelas `hidden` untuk menyembunyikan elemen
          }
        });
      });
    });

    document.getElementById('togglePassword').addEventListener('click', function () {
      const passwordInput = document.getElementById('passwordInput');
      const currentType = passwordInput.getAttribute('type');
      
      // Toggle input type between 'password' and 'text'
      if (currentType === 'password') {
        passwordInput.setAttribute('type', 'text');
        this.setAttribute('fill', '#000'); // Optionally change icon color
        this.setAttribute('stroke', '#000');
      } else {
        passwordInput.setAttribute('type', 'password');
        this.setAttribute('fill', '#bbb'); // Revert icon color
        this.setAttribute('stroke', '#bbb');
      }
    });


</script>



</html>