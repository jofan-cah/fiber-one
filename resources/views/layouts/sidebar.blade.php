<nav id="sidebar" class="lg:min-w-[250px] w-max max-lg:min-w-8">
  <div id="sidebar-collapse-menu"
    class=" bg-white shadow-lg h-screen fixed top-0 left-0 overflow-auto z-[99] lg:min-w-[250px] lg:w-max max-lg:w-0 max-lg:invisible transition-all duration-500">
    <div class="pt-8 pb-2 px-6 sticky top-0 bg-slate-100 min-h-[80px] z-[100]">
      <a href="javascript:void(0)" class="outline-none"><img
          src="https://fiberone.net.id/wp-content/uploads/2023/03/cropped-Logo-Fiberone.png" alt="logo"
          class='w-[170px]' />
      </a>
    </div>

    @php
    $activeRoutes = ['indexUsers', 'createUsers', 'editUsersById'];
    $isActive = in_array(Request::route()->getName(), $activeRoutes);
    @endphp
    <div class="py-6 px-6">
      <ul class="space-y-2">
        <li>
          <a href="{{route('home')}}"
            class="menu-item  {{Request::route()->getName() == 'home' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800'}}  text-sm flex items-center cursor-pointer  hover:bg-[#d9f3ea] rounded-md px-3 py-3 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
              viewBox="0 0 24 24">
              <path
                d="M19.56 23.253H4.44a4.051 4.051 0 0 1-4.05-4.05v-9.115c0-1.317.648-2.56 1.728-3.315l7.56-5.292a4.062 4.062 0 0 1 4.644 0l7.56 5.292a4.056 4.056 0 0 1 1.728 3.315v9.115a4.051 4.051 0 0 1-4.05 4.05zM12 2.366a2.45 2.45 0 0 0-1.393.443l-7.56 5.292a2.433 2.433 0 0 0-1.037 1.987v9.115c0 1.34 1.09 2.43 2.43 2.43h15.12c1.34 0 2.43-1.09 2.43-2.43v-9.115c0-.788-.389-1.533-1.037-1.987l-7.56-5.292A2.438 2.438 0 0 0 12 2.377z"
                data-original="#000000" />
              <path
                d="M16.32 23.253H7.68a.816.816 0 0 1-.81-.81v-5.4c0-2.83 2.3-5.13 5.13-5.13s5.13 2.3 5.13 5.13v5.4c0 .443-.367.81-.81.81zm-7.83-1.62h7.02v-4.59c0-1.933-1.577-3.51-3.51-3.51s-3.51 1.577-3.51 3.51z"
                data-original="#000000" />
            </svg>
            <span>Dashboard</span>
          </a>
        </li>

        @if (Auth::user()->user_level_id == 'LVL250101001')
        <li>
          <a href="{{route('indexUsers')}}"
            class="menu-item {{ $isActive ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} text-sm flex items-center cursor-pointer hover:bg-[#d9f3ea] rounded-md px-3 py-3 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-4"
              viewBox="0 0 512 512">
              <path
                d="M437.02 74.98C388.668 26.63 324.379 0 256 0S123.332 26.629 74.98 74.98C26.63 123.332 0 187.621 0 256s26.629 132.668 74.98 181.02C123.332 485.37 187.621 512 256 512s132.668-26.629 181.02-74.98C485.37 388.668 512 324.379 512 256s-26.629-132.668-74.98-181.02zM111.105 429.297c8.454-72.735 70.989-128.89 144.895-128.89 38.96 0 75.598 15.179 103.156 42.734 23.281 23.285 37.965 53.687 41.742 86.152C361.641 462.172 311.094 482 256 482s-105.637-19.824-144.895-52.703zM256 269.507c-42.871 0-77.754-34.882-77.754-77.753C178.246 148.879 213.13 114 256 114s77.754 34.879 77.754 77.754c0 42.871-34.883 77.754-77.754 77.754zm170.719 134.427a175.9 175.9 0 0 0-46.352-82.004c-18.437-18.438-40.25-32.27-64.039-40.938 28.598-19.394 47.426-52.16 47.426-89.238C363.754 132.34 315.414 84 256 84s-107.754 48.34-107.754 107.754c0 37.098 18.844 69.875 47.465 89.266-21.887 7.976-42.14 20.308-59.566 36.542-25.235 23.5-42.758 53.465-50.883 86.348C50.852 364.242 30 312.512 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 56.523-20.86 108.266-55.281 147.934zm0 0"
                data-original="#000000" />
            </svg>
            <span>Users </span>
          </a>
        </li>
        @php
        $activeRoutes = ['indexUsersLevel', 'editUsersLevelById', 'createUsersLevel',];
        $isActive = in_array(Request::route()->getName(), $activeRoutes);
        @endphp
        <li>
          <a href="{{route('indexUsersLevel')}}"
            class="menu-item {{ $isActive ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} text-sm flex items-center cursor-pointer hover:bg-[#d9f3ea] rounded-md px-3 py-3 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="mr-4" viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
              <path
                d="m15.71 15.71 2.29-2.3 2.29 2.3 1.42-1.42-2.3-2.29 2.3-2.29-1.42-1.42-2.29 2.3-2.29-2.3-1.42 1.42L16.58 12l-2.29 2.29zM12 8a3.91 3.91 0 0 0-4-4 3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4zM6 8a1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2 1.91 1.91 0 0 1-2-2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z">
              </path>
            </svg>
            <span>Users Level</span>
          </a>
        </li>
        @endif

        @if (Auth::user()->user_level_id == 'LVL250101001'|| Auth::user()->user_level_id == 'LVL250101002' ||
        Auth::user()->user_level_id == 'LVL241223002')
        @php
        $activeRoutes = ['indexOlt','allSite','siteIndex', 'createOdc' ,'indexOdc', 'createOlt', 'editOltById',
        'indexOdp',
        'createOdp',
        'editOdpById'];
        $isActive = in_array(Request::route()->getName(), $activeRoutes);
        @endphp
        <li>
          <a href="javascript:void(0)"
            class="text-gray-800 text-sm {{ $isActive ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} flex items-center cursor-pointer hover:bg-gray-100 rounded-md px-3 py-2.5 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="mr-4" viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
              <path
                d="M20 13.01h-7V10h1c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v4c0 1.103.897 2 2 2h1v3.01H4V18H3v4h4v-4H6v-2.99h5V18h-1v4h4v-4h-1v-2.99h5V18h-1v4h4v-4h-1v-4.99zM10 8V4h4l.002 4H10z">
              </path>
            </svg>
            <span class="overflow-hidden text-ellipsis whitespace-nowrap">Site</span>
            <svg xmlns="http://www.w3.org/2000/svg"
              class="arrowIcon w-3 fill-current -rotate-90 ml-auto transition-all duration-500"
              viewBox="0 0 451.847 451.847">
              <path
                d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"
                data-original="#000000" />
            </svg>
          </a>
          <ul class="sub menu max-h-0 overflow-hidden transition-[max-height] duration-500 ease-in-out ml-2">

            {{-- <li>
              <a href="{{route('allSite')}}"
                class="text-gray-800 text-sm  {{ Request::route()->getName() === 'allSite' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} block cursor-pointer hover:bg-gray-100 rounded-md px-3 py-2 transition-all duration-300">
                <span>ALl Data</span>
              </a>
            </li> --}}
            <li class="my-2">
              <a href="{{route('indexOlt')}}"
                class="text-gray-800 text-sm  {{ Request::route()->getName() === 'indexOlt' || Request::route()->getName() === 'createOlt' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} block cursor-pointer hover:bg-gray-100 rounded-md px-3 py-2 transition-all duration-300">
                <span>OLT</span>
              </a>
            </li>
            <li class="my-2">
              <a href="{{route('indexOdc')}}"
                class=" text-gray-800 text-sm  {{ Request::route()->getName() === 'indexOdc' || Request::route()->getName() === 'createOdc' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} block cursor-pointer hover:bg-gray-100 rounded-md px-3 py-2 transition-all duration-300">
                <span>ODC</span>
              </a>
            </li>
            <li class="my-2">
              <a href="{{route('indexOdp')}}"
                class="text-gray-800 text-sm {{ Request::route()->getName() === 'indexOdp' || Request::route()->getName() === 'createOdp' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }}  block cursor-pointer hover:bg-gray-100 rounded-md px-3 py-2 transition-all duration-300">
                <span>ODP</span>
              </a>
            </li>
            <li class="my-2">
              <a href="{{route('topology')}}"
                class="text-gray-800 text-sm {{ Request::route()->getName() === 'topology' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }}  block cursor-pointer hover:bg-gray-100 rounded-md px-3 py-2 transition-all duration-300">
                <span>Topology</span>
              </a>
            </li>
          </ul>
        </li>


        @php
        $activeRoutes = ['coverage'];
        $isActive = in_array(Request::route()->getName(), $activeRoutes);
        @endphp
        <li>
          @php
          $activeRoutes = [ 'site'];
          $isActive = in_array(Request::route()->getName(), $activeRoutes);
          @endphp
          <a href="{{route('site')}}"
            class="menu-item text-gray-800 {{ $isActive ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} text-sm flex items-center cursor-pointer hover:bg-[#d9f3ea] rounded-md px-3 py-3 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="mr-4" viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
              <path
                d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm7.931 9h-2.764a14.67 14.67 0 0 0-1.792-6.243A8.013 8.013 0 0 1 19.931 11zM12.53 4.027c1.035 1.364 2.427 3.78 2.627 6.973H9.03c.139-2.596.994-5.028 2.451-6.974.172-.01.344-.026.519-.026.179 0 .354.016.53.027zm-3.842.7C7.704 6.618 7.136 8.762 7.03 11H4.069a8.013 8.013 0 0 1 4.619-6.273zM4.069 13h2.974c.136 2.379.665 4.478 1.556 6.23A8.01 8.01 0 0 1 4.069 13zm7.381 6.973C10.049 18.275 9.222 15.896 9.041 13h6.113c-.208 2.773-1.117 5.196-2.603 6.972-.182.012-.364.028-.551.028-.186 0-.367-.016-.55-.027zm4.011-.772c.955-1.794 1.538-3.901 1.691-6.201h2.778a8.005 8.005 0 0 1-4.469 6.201z">
              </path>
            </svg>
            <span>Site</span>
          </a>
        </li>
        @endif

        <li>
          <a href="{{route('coverage')}}"
            class="menu-item text-gray-800 text-sm 
                       {{ Request::route()->getName() === 'coverage' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} flex items-center cursor-pointer hover:bg-[#d9f3ea] rounded-md px-3 py-3 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="mr-4" viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
              <path
                d="m12 17 1-2V9.858c1.721-.447 3-2 3-3.858 0-2.206-1.794-4-4-4S8 3.794 8 6c0 1.858 1.279 3.411 3 3.858V15l1 2zM10 6c0-1.103.897-2 2-2s2 .897 2 2-.897 2-2 2-2-.897-2-2z">
              </path>
              <path
                d="m16.267 10.563-.533 1.928C18.325 13.207 20 14.584 20 16c0 1.892-3.285 4-8 4s-8-2.108-8-4c0-1.416 1.675-2.793 4.267-3.51l-.533-1.928C4.197 11.54 2 13.623 2 16c0 3.364 4.393 6 10 6s10-2.636 10-6c0-2.377-2.197-4.46-5.733-5.437z">
              </path>
            </svg>
            <span>Coverage</span>
          </a>
        </li>
        @if ( Auth::user()->user_level_id == 'LVL241223002'|| Auth::user()->user_level_id == 'LVL250101001' ||
        Auth::user()->user_level_id == 'LVL250101003')
        <li>
          <a href="{{route('uncoverage')}}"
            class="menu-item text-gray-800 text-sm 
                                         {{ Request::route()->getName() === 'uncoverage' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800' }} flex items-center cursor-pointer hover:bg-[#d9f3ea] rounded-md px-3 py-3 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="mr-4" viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
              <path
                d="M3 16h2v5H3zm4-3h2v8H7zM21 3h-2v14.59l-2-2V7h-2v6.59l-2-2V10h-1.59l-7.7-7.71-1.42 1.42 18 18 1.42-1.42-.71-.7V3zm-6 18h1.88L15 19.12V21zm-4 0h2v-3.88l-2-2V21z">
              </path>
            </svg>
            </svg>
            <span>Un Coverage</span>
          </a>
        </li>
        @endif


        @if (Auth::user()->user_level_id == 'LVL250101001'|| Auth::user()->user_level_id == 'LVL250101002' ||
        Auth::user()->user_level_id == 'LVL241223002')
        <li>
          <a href="{{route('indexSubs')}}"
            class="menu-item  {{Request::route()->getName() == 'indexSubs' ? 'text-green-700 bg-[#d9f3ea]' : 'text-gray-800'}}  text-sm flex items-center cursor-pointer  hover:bg-[#d9f3ea] rounded-md px-3 py-3 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4" width="18" height="18" viewBox="0 0 24 24"
              style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
              <path
                d="M8 12.052c1.995 0 3.5-1.505 3.5-3.5s-1.505-3.5-3.5-3.5-3.5 1.505-3.5 3.5 1.505 3.5 3.5 3.5zM9 13H7c-2.757 0-5 2.243-5 5v1h12v-1c0-2.757-2.243-5-5-5zm9.364-10.364L16.95 4.05C18.271 5.373 19 7.131 19 9s-.729 3.627-2.05 4.95l1.414 1.414C20.064 13.663 21 11.403 21 9s-.936-4.663-2.636-6.364z">
              </path>
              <path
                d="M15.535 5.464 14.121 6.88C14.688 7.445 15 8.198 15 9s-.312 1.555-.879 2.12l1.414 1.416C16.479 11.592 17 10.337 17 9s-.521-2.592-1.465-3.536z">
              </path>
            </svg>
            <span>Pelangan</span>
          </a>
        </li>
        @endif
      </ul>


    </div>
  </div>
</nav>

<button id="toggle-sidebar"
  class='lg:hidden w-8 h-8 z-[100] fixed top-[36px] left-[10px] cursor-pointer bg-[#007bff] flex items-center justify-center rounded-full outline-none transition-all duration-500'>
  <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" class="w-3 h-3" viewBox="0 0 55.752 55.752">
    <path
      d="M43.006 23.916a5.36 5.36 0 0 0-.912-.727L20.485 1.581a5.4 5.4 0 0 0-7.637 7.638l18.611 18.609-18.705 18.707a5.398 5.398 0 1 0 7.634 7.635l21.706-21.703a5.35 5.35 0 0 0 .912-.727 5.373 5.373 0 0 0 1.574-3.912 5.363 5.363 0 0 0-1.574-3.912z"
      data-original="#000000" />
  </svg>
</button>