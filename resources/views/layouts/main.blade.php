<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    @if (Request::route() && Request::route()->getPrefix())
        @php
            $prefix = trim(Request::route()->getPrefix(), '/');
        @endphp
        {{ $prefix === 'subs' ? 'Pelangan' : strtoupper($prefix) }} - @yield('title', 'FiberOne')
    @else
        @yield('title', 'Dashboard')
    @endif
</title>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

  <link rel="icon" href="{{ asset('imgfavicon.png')  }}" sizes="192x192" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

  <style>
    /* width */
    ::-webkit-scrollbar {
      width: 16px;
      height: 16px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      border-radius: 100vh;
      background: #edf2f7;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #cbd5e0;
      border-radius: 100vh;
      border: 3px solid #edf2f7;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #a0aec0;
    }
  </style>
</head>

<body>
  <div class="relative bg-[#f7f6f9] h-full min-h-screen font-[sans-serif]">
    <div class="flex items-start">
      @include('layouts.sidebar')
      <section class="main-content w-full mx-6">
        @include('layouts.header')

        <div class="my-10 px-2">
          @yield('content')

        </div>
      </section>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
      // sidebar
   document.querySelectorAll('#sidebar ul > li > a').forEach((menu) => {
        menu.addEventListener('click', () => {
          const subMenu = menu.nextElementSibling;
          if (!subMenu) return;
          const arrowIcon = menu.querySelector('.arrowIcon');

          // Check if the submenu is currently open
          if (subMenu.classList.contains('max-h-0')) {
            subMenu.classList.remove('max-h-0');
            subMenu.classList.add('max-h-[500px]'); // Adjust height as needed
          } else {
            subMenu.classList.remove('max-h-[500px]');
            subMenu.classList.add('max-h-0');
          }

          // Toggle arrow rotation
          arrowIcon.classList.toggle('rotate-0');
          arrowIcon.classList.toggle('-rotate-90');
        });
      });


      let sidebarToggleBtn = document.getElementById('toggle-sidebar');
      let sidebarCollapseMenu = document.getElementById('sidebar-collapse-menu');

      sidebarToggleBtn.addEventListener('click', () => {
        if (!sidebarCollapseMenu.classList.contains('open')) {
            sidebarCollapseMenu.classList.add('open');
            sidebarCollapseMenu.style.cssText = 'width: 250px; visibility: visible; opacity: 1;';
            sidebarToggleBtn.style.cssText = 'left: 236px;';
        } else {
            sidebarCollapseMenu.classList.remove('open');
            sidebarCollapseMenu.style.cssText = 'width: 32px; visibility: hidden; opacity: 0;';
            sidebarToggleBtn.style.cssText = 'left: 10px;';
        }

      });
    });
</script>

</html>
