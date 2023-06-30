<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="{ 'theme-dark': dark }" x-data="data()">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'BT-SMS')</title>

  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css" integrity="sha512-QfDd74mlg8afgSqm3Vq2Q65e9b3xMhJB4GZ9OcHDVy1hZ6pqBJPWWnMsKDXM7NINoKqJANNGBuVRIpIJ5dogfA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="/panel/css/main.css">

  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>

  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <style>
    [x-cloak] {
      display: none !important;
    }

    body,
    .bg-color {
      background-color: #fafbff !important;
    }

    a.app-menu__item transition transform duration-300:hover,
    a.app-menu__item transition transform duration-300.active,
    a.app-menu__item transition transform duration-300:active {
      background-color: #f6F3ff !important;
      color: #6633ff;
      border: none !important;
    }

    .icons-svg {
      color: #6633ff !important;
    }

    button:focus,
    button.focus {
      border: none !important;
    }

  </style>
  @livewireStyles
</head>

<body class="app sidebar-mini bg-color" x-data="{ sidebar: true }">
  <!-- Navbar-->
  <header class="z-20 py-2 bg-color app-header">
    <a class="text-lg bg-white cursor-default app-header__logo head" href="/">E-Voting &nbsp; System</a>
    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle text-primary hover:text-white" href="#" data-toggle="sidebar" aria-label="Hide Sidebar" @click="sidebar = ! sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="flex items-center space-x-3 text-sm app-nav">
      <li class="text-sm capitalize">
        <span class="">hi, <span class="font-bold"> {{ currentUser()->name }}</span></span>
        <br>
        {{-- <span class="">{{ Auth::user()->roles[0]->name }}</span> --}}
      </li>
      <li class="dropdown">
        {{-- <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"> --}}

        <img src="/img/logo.svg" alt="" class="w-16 h-16 p-2 transition duration-300 transform rounded-full shadow-sm cursor-pointer app-nav__item border-primary hover:scale-105" data-toggle="dropdown" aria-label="Open Profile Menu">
        {{-- </a> --}}
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="/settings"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
          <li><a class="dropdown-item" href="/profile"><i class="fa fas fa-user-plus"></i> Profile</a></li>
          <li>
            <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a>
          </li>
          <form class="hidden logout-form" id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
          </form>
        </ul>
      </li>
    </ul>
  </header>
  <!-- Sidebar menu-->
  <div class="bg-white app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="z-50 object-cover object-center h-screen bg-white shadow-none app-sidebar">
    <div class="z-50 -mt-6 app-sidebar__user">
      <p class="p-3 mx-auto rounded-full bg-secondary">
        <img class="object-cover object-center w-10 h-10 mx-auto" src="/img/logo.svg" alt="User Image">
      </p>

    </div>
    <ul class="space-y-3 text-sm app-menu">
      @if (currentUser()->hasRole('admin'))
      <li>
        <a :class="sidebar ? 'md:mx-4 lg:mx-8' : ''" class="app-menu__item hover:text-priamry {{ request()->is('users*') ? 'active' : '' }} transform space-x-2 py-2 text-gray-800 transition duration-300" href="/users">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span class="app-menu__label">User</span>
        </a>
      <li>
        <a :class="sidebar ? 'md:mx-4 lg:mx-8' : ''" class="app-menu__item hover:text-priamry {{ request()->is('roles*') ? 'active' : '' }} transform space-x-2 py-2 text-gray-800 transition duration-300" href="/roles">
          <i class="text-xl bi bi-person-plus-fill"></i>
          <span class="app-menu__label">Role</span>
        </a>
      <li>
        <a :class="sidebar ? 'md:mx-4 lg:mx-8' : ''" class="app-menu__item hover:text-priamry {{ request()->is('permissions*') ? 'active' : '' }} transform space-x-2 py-2 text-gray-800 transition duration-300" href="/permissions">
          <i class="text-xl bi bi-person-bounding-box"></i>
          <span class="app-menu__label">Permission</span>
        </a>
      </li>
      <li>
        <a :class="sidebar ? 'md:mx-4 lg:mx-8' : ''" class="app-menu__item hover:text-priamry {{ request()->is('sms*') ? 'active' : '' }} transform space-x-2 py-2 text-gray-800 transition duration-300" href="/sms">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
            </path>
          </svg>
          <span class="app-menu__label">Message</span>
        </a>
      </li>
      <li>
        <a :class="sidebar ? 'md:mx-4 lg:mx-8' : ''" class="app-menu__item hover:text-priamry {{ request()->is('visitors*') ? 'active' : '' }} transform space-x-2 py-2 text-gray-800 transition duration-300" href="{{ route('visitors') }}">
          <i class="text-xl bi bi-speedometer"></i>
          <span class="app-menu__label">Visitors</span>
        </a>
      </li>
      @else
      <li><a class="app-menu__item {{ request()->is('profile*') ? 'active' : '' }} transform transition duration-300" href="/profile"><i class="app-menu__icon fa fa-user-circle"></i><span class="app-menu__label">Profile</span></a></li>
      <li><a class="app-menu__item {{ request()->is('admin/cities*') ? 'active' : '' }} transform transition duration-300" href="dashboard.html"><i class="app-menu__icon fas fa-chart-pie"></i><span class="app-menu__label">Result</span></a></li>
      <li><a class="app-menu__item {{ request()->is('vote*') ? 'active' : '' }} transform transition duration-300" href="/vote"><i class="app-menu__icon fas fa-thumbs-up"></i><span class="app-menu__label">Vote</span></a>
      </li>
      @endif

    </ul>
  </aside>
  <main class="shadow-none app-content bg-color">
    {{-- if its admin --}}
    {{-- @if (Auth::user()->hasRole('admin'))
       @livewire('board')
    @endif --}}
    {{-- main content --}}
    {{ $slot ?? '' }}
    @yield('contents')
    <p class="px-2 text-sm font-medium text-gray-500 max-w-max">Powered By<a href="https://bonifade.com" class="text-primary" target="_blank" title="Click to Contact"> Bonifade Technologies</a></p>
  </main>

  <!-- Essential javascripts for application to work-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  {{-- <script src="/panel/js/jquery-3.3.1.min.js"></script> --}}
  <script src="/panel/js/popper.min.js"></script>
  <script src="/panel/js/bootstrap.min.js"></script>
  <script src="/panel/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  {{-- <script src="/panel/js/plugins/pace.min.js"></script> --}}

  @livewireScripts

  <script>
    window.addEventListener('closeModal', event => {
      $('#form').modal('hide');
    });

  </script>

  {{-- show modal --}}
  <script>
    window.addEventListener('showModal', event => {
      $('#form').modal('show');
    });

  </script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @yield('scripts')

  <script>
    // success message
    window.addEventListener('swal:success', function(e) {
      Swal.fire(e.detail);
    });

    // confirm single deleted
    window.addEventListener('swal:confirm', event => {
      Swal.fire({
        title: 'Are you sure?'
        , text: "You wont be able to revert this!"
        , icon: 'warning'
        , showCancelButton: true
        , cancelButtonColor: '#f11'
        , confirmButtonColor: ''
        confirmButtonText: 'Yes delete it'
      }).then((result) => {
        if (result.isConfirmed) {
          Livewire.emit('deleteConfirm');
          // Swal.fire(
          //   'Deleted!'
          //   , 'Your file has been deleted'
          //   , 'success'
          // )
        }
      });
    });

    // confirm multiple delete
    window.addEventListener('swal:multiple', event => {
      Swal.fire({
        title: 'Are you sure you?'
        , text: "You are deleting buck records at once, you won\'t be able to revert this!"
        , icon: 'warning'
        , showCancelButton: true
        , cancelButtonColor: '#f11'
        , confirmButtonText: 'Go Ahead'
      }).then((result) => {
        if (result.isConfirmed) {
          Livewire.emit('deleteMutipleConfirm');
          // Swal.fire(
          //   'Deleted!'
          //   , 'Your file has been deleted'
          //   , 'success'
          // )
        }
      });
    });

  </script>
</body>

</html>
