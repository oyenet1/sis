{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 Unathorised pages | Meeras School Management System</title>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <style>
    @media screen and (min-width: 1024px) {
      .text-7xl {
        font-size: 150px !important;
      }
    }
  </style>
</head>

<body class="flex items-center justify-center w-screen h-screen font-fira bg-background">
  <div class="w-full px-4 pt-8 space-y-4 md:max-w-lg lg:max-w-xl md:px-2 lg:px-0">
    <div class="flex items-center justify-center w-full text-primary space-x-4">
      <p class="font-black -rotate-12 text-7xl tt">4</p>
      {{-- <img src="/img/404.png" alt="bonifade technologies" class="object-bottom w-24 rounded-full lg:w-32 aspect-square"> --}}
      <span class="block mx-auto rounded-full bg-red-600 border-4 border-red-600 p-0 text-white">
        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
        </svg>
      </span>
      <p class="font-black rotate-12 text-7xl tt">3</p>
    </div>
    <div class="flex flex-col justify-center space-y-6 text-center">
      <h1 class="text-4xl font-extrabold text-red-600 text-center"> UNAUTHORISED ACCESS!</h1>
      <div class="mx-auto text-center">
        <p class="text-lg font-medium">Acess Denied</p>
        <p class="max-w-lg">
          {{ session('message') ?? 'User does not have any of the necessary access rights.....' }}
        </p>
      </div>
      <a href="{{ url()->previous() }}" class="block max-w-xs px-12 mx-auto font-normal btn btn-primary btn-lg">Go
        Back</a>
    </div>

  </div>

</body>

</html>
