{{-- @extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable')) --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service Unavailable | 503 error </title>
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
    <div class="flex items-center justify-center w-full space-x-1">
      <img src="/img/503.png" alt="bonifade technologies"
        class="object-bottom w-48 rounded-full shadow-sm lg:w-60 xl:w-72 aspect-square">
    </div>
    <div class="flex flex-col justify-center space-y-6 text-center">
      <h1 class="text-4xl font-extrabold text-center">Service Unavailable!</h1>
      <div class="mx-auto text-center">
        <p class="text-lg font-medium">Internal Server Maintenace</p>
        <p class="max-w-lg">We are sorry to imform you that our service is under maintenace, kindly come back
          within some hours. Our Engineering Team is working on it.</p>
      </div>
    </div>
  </div>

</body>

</html>
