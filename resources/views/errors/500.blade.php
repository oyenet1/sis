{{-- @extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error')) --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>500 error pages | Meeras School Management System</title>
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
    <div class="flex items-center justify-center w-full space-x-4">
      <p class="font-black -rotate-12 text-7xl tt">5</p>
      <img src="/img/500.png" alt="bonifade technologies" class="object-bottom w-24 rounded-full lg:w-32 aspect-square">
      <p class="font-black rotate-12 text-7xl tt">0</p>
    </div>
    <div class="flex flex-col justify-center space-y-6 text-center">
      <h1 class="text-4xl font-extrabold text-center">OOPS!</h1>
      <div class="mx-auto text-center">
        <p class="text-lg font-medium">Internal Server Error</p>
        <p class="max-w-lg">Sorry, it looks like our server doestn't know how to handle the request. Kindly go
          back home buy clicking the button below</p>
      </div>
      <a href="/" class="block max-w-xs px-12 mx-auto font-normal btn btn-primary btn-lg">Go Back</a>
    </div>

  </div>

</body>

</html>
