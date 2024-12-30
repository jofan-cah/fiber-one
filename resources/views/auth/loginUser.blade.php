<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="icon" href="{{ asset('imgfavicon.png')  }}" sizes="192x192" />
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
  <section class="bg-gray-50 h-[100vh] flex"> <!-- Mengubah bg menjadi abu-abu -->
    <div class="flex flex-col items-center justify-center lg:w-[500px] px-6 py-4 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="w-45 h-16 mr-2" src="{{ asset('fiberOne.png') }}" alt="logo">
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Sign in to your account
          </h1>
          @if (session('error'))
          <div id="alert-3" class="flex p-4 mb-4 text-red-800 border-2 border-red-300 rounded-lg bg-red-50" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ml-3 text-sm font-medium">
              {{ session('error') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
              <span class="sr-only">Close</span>
              <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </button>
          </div>
          @endif
          <form class="space-y-4 md:space-y-6" action="{{ route('logged') }}" method="POST">
            @csrf
            <div>
              <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
              <input name="username" type="text" required id="username" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="username" required="">
            </div>
            <div>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
              <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
            </div>
            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Menambahkan versi di bawah form login -->
  <footer class="absolute bottom-0 w-full text-center text-sm text-gray-500 dark:text-gray-400">
    <p>Uhuy Version 1.0.0</p>
  </footer>

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
