<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  @livewireStyles

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>
  <title>SMS | Login</title>
</head>

<body class="relative flex justify-around w-full h-screen bg-white font-rubik">
  <div
    class="relative grid justify-around w-full max-w-4xl gap-4 px-4 mx-auto my-auto xl:max-w-5xl md:grid-cols-2 lg:gap-16">
    <div class="w-full col-span-2 px-2 pb-8 mx-auto rounded-md shadow-lg md:pb-16 lg:col-span-1 ">
      <img src="/img/logo.svg" alt="bonifade logo" class="w-20 h-auto px-5 py-4 mx-auto my-8 rounded-full bg-background">
      <form method="POST" action="{{ route('login') }}"
        class="flex flex-col w-full px-4 pb-4 mx-auto space-y-6 sm:px-12 lg:px-16">
        @csrf
        <h1 class="text-xl font-bold text-primary font-rubik md:text-2xl lg:text-3xl">Login to Dashboard</h1>
        <small class="text-gray-500">This software can be used to improve students learning. See what else you don't
          know about BT-SMS. <a href="https://bonifade.com" target="_blank" class="font-medium text-primary">Learn
            More</a></small>

        <div class="w-full space-y-8">
          <div class="relative w-full overflow-hidden text-gray-500 rounded h-11">
            <input type="email" value="{{ old('email') }}" name="email"
              class="w-full h-full py-2 pl-8 text-sm font-medium placeholder-gray-500 border-2 border-gray-300 rounded focus:border-primary"
              placeholder="Enter your staff ID">
            {{-- span elements --}}
            <svg class="absolute z-20 w-6 h-6 my-auto left-2 top-2" fill="none" stroke="currentColor"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
              </path>
            </svg>
            @error('email')
              <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
          </div>
          <div class="relative w-full overflow-hidden text-gray-500 rounded h-11" x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" value="{{ old('password') }}" placeholder="Enter your password"
              name="password"
              class="w-full h-full py-2 pl-8 text-sm font-medium placeholder-gray-500 border-2 border-gray-300 rounded focus:border-primary">
            <svg class="absolute w-6 h-6 left-2 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
              </path>
            </svg>
            <span class="absolute transition duration-300 cursor-pointer right-2 top-2 hover:text-black"
              @click="show = !show">
              <svg :class="show ? 'block' : 'hidden'" class="w-6 h-6" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                </path>
              </svg>
              <svg :class="show ? 'hidden' : 'block'" class="w-6 h-6" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
            </span>
            @error('password')
              <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
          </div>
          <button type="submit"
            class="w-full py-2 my-8 text-center text-white transition duration-300 rounded bg-primary hover:bg-purple-800">Login</button>
        </div>
      </form>
    </div>
    <div class="relative flex-row flex-wrap justify-around hidden w-full grid-cols-2 gap-8 lg:flex max-h-96">
      <img src="/img/image-card_1.jpg" alt=""
        class="object-cover object-center rounded-md shadow-lg w-44 h-60 2xl:w-52 xl:h-72">
      <img src="/img/image-card_2.jpg" alt=""
        class="object-cover object-center mt-16 rounded-md shadow-lg w-44 h-60 2xl:w-52 xl:h-72">
      <img src="/img/image-card_3.jpg" alt=""
        class="object-cover object-center -mt-16 rounded-md shadow-lg w-44 h-60 2xl:w-52 xl:h-72">
      <img src="/img/image-card_4.jpg" alt=""
        class="object-cover object-center rounded-md shadow-lg w-44 h-60 2xl:w-52 xl:h-72">
    </div>
    <p class="text-sm font-medium text-gray-500 max-w-max">Powered By<a href="https://bonifade.com"
        class="text-primary" target="_blank" title="Click to Contact"> Bonifade Technologies</a></p>
    <a href="mailto:info@bonifade.com"
      class="absolute top-0 px-4 py-2 -mt-8 text-sm font-medium transition duration-300 border-2 rounded text-primary border-primary hover:bg-primary hover:text-white right-3"
      target="_blank" title="Click to Contact">Contact</a>
  </div>
  {{-- <a href="https://bonifade.com" class="absolute px-4 py-2 my-3 text-sm transition duration-300 border-2 rounded text-primary border-primary hover:bg-primary hover:text-white right-3 top-2" target="_blank" title="Click to Contact">Contact</a> --}}
  @livewireScripts
</body>

</html>
