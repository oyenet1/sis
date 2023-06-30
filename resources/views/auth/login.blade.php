<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  @livewireStyles

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>
  <title>ACCE KANO | Login</title>
  <style>
    [x-cloak] {
      display: none !important;
    }

  </style>
</head>

<body class="relative flex justify-around w-full h-screen bg-white font-fira">
  <div class="relative grid items-center justify-around w-full max-w-4xl gap-4 px-4 mx-auto my-auto md:grid-cols-2 lg:gap-12 xl:max-w-5xl 2xl:max-w-7xl 2xl:gap-16">
    <div class="w-full col-span-2 px-2 pt-4 mx-auto rounded-md shadow-lg md:pb-16 lg:col-span-1">
      <div class="flex items-center justify-center w-24 h-24 px-4 py-4 mx-auto mt-4 rounded-full shadow i max-w-max bg-background 2xl:my-8">
        <img src="/img/logo.png" alt="bonifade logo" class="w-20 h-auto mx-auto">
      </div>
      <form method="POST" action="{{ route('login') }}" class="flex flex-col w-full px-4 mx-auto space-y-8 sm:px-12 lg:px-16" x-data="{ login: 'id', id: true }">
        @csrf
        <h1 class="text-xl font-bold font-rubik text-primary md:text-2xl lg:text-3xl">Login!</h1>
        <small class="text-gray-500">This software can be used to improve students learning. See what else you don't
          know about BT-SMS. <a href="https://bonifade.com" target="_blank" class="font-medium text-primary">Learn
            More</a></small>

        {{-- toggle id and emails --}}
        <div class="flex items-center justify-center m-0 space-x-4 text-sm font-medium">
          <span class="px-4 py-2 rounded-lg cursor-pointer" :class="login === 'id' ? 'bg-gray-200' : 'text-gray-400'" @click="login = 'id'">School
            Id</span>
          <span class="px-4 py-2 rounded-lg cursor-pointer" :class="login === 'email' ? 'bg-gray-200' : 'text-gray-400'" @click="login = 'email'">Email</span>
        </div>

        <div class="w-full space-y-8">
          <div class="">
            <x-forms.i-d />
            @error('school_id')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
          </div>
          <div>
            <x-forms.password label="password" name="password">
              @error('password')
              <span class="text-red-600">{{ $message }}</span>
              @enderror
            </x-forms.password>
            <div class="flex items-center justify-between mt-2 tex-sm">
              <div>
                <label for="remember " class="text-sm text-primary">
                  <input type="checkbox" name="remember" id="remember" class="border-2 rounded-sm border-primary text-secondary focus:bg-secondary focus:text-white">
                  Remember Me
                </label>
              </div>

              <a href="{{ route('password.email') }}" class="text-sm text-gray-400">Forget Password?</a>
            </div>
          </div>
          <button type="submit" class="w-full py-2 text-center text-white transition duration-300 rounded bg-primary hover:bg-secondary">Login</button>
        </div>

      </form>
    </div>
    <div class="relative hidden w-full gap-8 lg:block">
      <img src="/img/sign-in.svg" alt="Bonifade Technologies | school managemnt system" class="object-cover object-center">
    </div>
    <p class="-mt-8 text-sm font-medium text-gray-500 max-w-max">Powered By <a href="https://bonifade.com" class="text-secondary" target="_blank" title="Click to Contact">Meeras</a></p>
    {{-- <a href="mailto:info@bonifade.com"
      class="absolute top-0 px-4 py-2 -mt-8 text-sm font-medium transition duration-300 border-2 rounded text-primary border-primary hover:bg-primary hover:text-white right-3"
      target="_blank" title="Click to Contact">Contact</a> --}}
  </div>
  @livewireScripts
</body>

</html>
